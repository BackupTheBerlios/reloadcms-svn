<?php
////////////////////////////////////////////////////////////////////////////////
//   Copyright (C) 2004 ReloadCMS Development Team                            //
//   http://reloadcms.sf.net                                                  //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   This product released under GNU General Public License v2                //
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// Returns array with info about selected user                                //
////////////////////////////////////////////////////////////////////////////////
function load_user_info($username){
    $result = @unserialize(@file_get_contents(USERS_PATH . basename($username)));
    if(empty($result)) return false; else return $result;
}

////////////////////////////////////////////////////////////////////////////////
// Checks user for right                                                      //
////////////////////////////////////////////////////////////////////////////////
function user_check_right($username, $right){
    if (!($userdata = load_user_info($username))) return false;
    $user_rights = trim($userdata['admin']);
    if($right == '-any-' && !empty($user_rights)) return true;
    elseif($right == '-any-') return false;
    if ($user_rights == '*') return true;
    elseif (ereg("\|$right\|", $user_rights)) return true;
    return false;
}

////////////////////////////////////////////////////////////////////////////////
// Gets array of users matching expression                                    //
////////////////////////////////////////////////////////////////////////////////
function user_get_list($expr = '*'){
    global $rights_db;
    $return = array();
    if(empty($expr)) $users = @rcms_scandir(USERS_PATH); else $users = @rcms_scandir(USERS_PATH, $expr);
    foreach ($users as $user){
        if($data = load_user_info($user)) $return[] = $data;
    }
    return $return;
}

////////////////////////////////////////////////////////////////////////////////
// Updates user's profile or creates new one                                  //
////////////////////////////////////////////////////////////////////////////////
function user_update($username, $reg, $password, $confirm, $email, $userdata, $admin = false){
    global $system, $lang, $userfields;
    // For security reasons we must extract basename from username
    $username = basename($username);
    // If our mode is registration...
    if($reg){
        // If there is user with name you trying to register we exiting with error
        if(is_file(USERS_PATH . $username)) return 6;
        // If your username isn't valid we also exiting with error
        if(empty($username) || preg_replace("/[\d\w]+/i", '', $username) != '') return 14;
        // And finally if password doesn't equal to it's confirmation we exiting with error
        if(empty($password) || empty($confirm) || $password != $confirm) return 12;
        // We must count number our users
        $count = count(rcms_scandir(USERS_PATH));
        // If our user is first - we must set him an admin rights
        $_userdata['admin'] = ($count == 0) ? '*' : ' ';
        // Also we must set a md5 hash of user's password to userdata
        $_userdata['password'] = md5($password);
        $_userdata['username'] = $username;
    } else {
        // If we updating profile we must check if user is exists
        if(!is_file(USERS_PATH . $username)) return 16;
        // If new password must be set we must check it's confirmation
        if(!empty($password) && !empty($confirm) && $password != $confirm) return 12;
        // So we must load old user's profile
        $_userdata = load_user_info($username);
        // And set new password if needed
        $_userdata['password']  = (empty($password)) ? $_userdata['password'] : md5($password);
        $_userdata['username'] = $username;
    }
    // Check e-mail address and set it to profile
    if(empty($email) || !rcms_is_valid_email($email)) return 11; else $_userdata['email'] = $email;
    if(!$reg) user_remove_from_cache($username, $cache);
    if(!user_check_email_in_cache($username, $email, $cache)) return 21;
    // Parse some system fields
    $userdata['nickname'] = empty($userdata['nickname']) ? $username : $userdata['nickname'];
    if(!user_check_nick_in_cache($username, $userdata['nickname'], $cache)) return 20;
    $userdata['hideemail'] = empty($userdata['hideemail']) ? '0' : '1';
    $userdata['tz'] = (float) @$userdata['tz'];
    $userdata['userlevel'] = (int) @$userdata['userlevel'];
    // Get list of system fields and ...
    foreach ($userfields[0] as $field => $acc){
        // ... if we have right to change value of this field...
        if($admin || ($reg && $acc <= USERS_ALLOW_SET) || $acc == USERS_ALLOW_CHANGE){
            // If this field isn't set we must set it to default value (when registering new)
            if(!isset($userdata[$field]) && $reg) $userdata[$field] = @$userfields[1][$field];
            // ... we will change it if it is set :)
            if(isset($userdata[$field])) $_userdata[$field] = strip_tags(trim($userdata[$field]));
        }
    }
    // Do same actions for additional fields
    foreach ($system->data['apf'] as $field => $desc) $_userdata[$field] = strip_tags(trim($userdata[$field]));
    // Save new profile data
    if(!file_write_contents(USERS_PATH . $username, serialize($_userdata))) return 10;
    // Register user's nick and e-mail in cache
    user_register_in_cache($username, $userdata['nickname'], $email, $cache);
    // If activation is turned off we successfully exiting
    if(!$reg || !@$system->config['regconf'] || $count == 0) {
        return ($reg) ? 1 : 2;
    } else {
        // If activation is on we sending message to user and exiting
        $site_url = parse_url($system->config['site_url']);
        $key = user_set_unconfirmed($username);
        $link = $system->config['site_url'] . '/index.php?activate=' . $username . '&key=' . $key;
        rcms_send_mail($email, 'activation@' . $site_url['host'], $lang['users']['actreqsender'], $lang['options']['encoding'], $lang['users']['actreqsubj'], $lang['users']['actreqtext'] . $link);
        return 4;
    }
}

////////////////////////////////////////////////////////////////////////////////
// Sends email with password to user if he request it                         //
////////////////////////////////////////////////////////////////////////////////
function user_forgot_password($username, $email){
    global $system, $lang;
    $username = basename($username);
    if (!($data = load_user_info($username))) return 16;
    if($email != $data['email']) return 11;
    $new_password = gen_rand_string(8);
    $site_url = parse_url($system->config['site_url']);
    if(rcms_send_mail($data['email'], 'passreq@' . $site_url['host'], $lang['users']['pasreqsender'], $lang['options']['encoding'], $lang['users']['pasreqsubj'], $lang['users']['pasreqtext'] . $new_password)) {
        $data['password'] = md5($new_password);
        if(!file_write_contents(USERS_PATH . $username, serialize($data))) return 10;
        return 3;
    } return 11;
}

////////////////////////////////////////////////////////////////////////////////
// Changes value of one field in user's profile                               //
////////////////////////////////////////////////////////////////////////////////
function user_change_field($username, $field, $value){
    $username = basename($username);
    if (!($userdata = load_user_info($username))) return 16;
    $userdata[$field] = $value;
    if(!file_write_contents(USERS_PATH . $username, serialize($userdata))) return 10;
    return 0;
}

////////////////////////////////////////////////////////////////////////////////
// Changes rights of selected user                                            //
////////////////////////////////////////////////////////////////////////////////
function user_set_rights($username, $root, $rights){
    $username = basename($username);
    if (!($userdata = load_user_info($username))) return 16;
    if(empty($rights)) $rights = array();
    if($root) $userdata['admin'] = '*';
    else {
        $userdata['admin'] = '';
        foreach ($rights as $right=>$cond){
            if($cond) $userdata['admin'] .= '|' . $right . '|';
        }
    }
    if(!file_write_contents(USERS_PATH . $username, serialize($userdata))) return 10;
    return 0;
}

////////////////////////////////////////////////////////////////////////////////
// Deletes user                                                               //
////////////////////////////////////////////////////////////////////////////////
function user_delete($username){
    $username = basename($username);
    if(!rcms_delete_files(USERS_PATH . $username)) return 5;
    user_remove_from_cache($username, $cache);
    user_activate_admin($username);
    return 0;
}

function user_is_confirmed($username){
    if(!is_file(DATA_PATH . 'users.unconfirmed.dat')) return true;
    $userdata = @unserialize(@file_get_contents(DATA_PATH . 'users.unconfirmed.dat'));
    if(!empty($userdata[$username])) return false;
    return true;
}

function user_set_unconfirmed($username){
    if(!is_file(DATA_PATH . 'users.unconfirmed.dat')) $userdata = array(); else {
        $userdata = @unserialize(@file_get_contents(DATA_PATH . 'users.unconfirmed.dat'));
    }
    $userdata[$username]['code'] = gen_rand_string(8);
    $userdata[$username]['time'] = time();
    file_write_contents(DATA_PATH . 'users.unconfirmed.dat', serialize($userdata));
    return $userdata[$username]['code'];
}

function user_activate($username, $key){
    if(!is_file(DATA_PATH . 'users.unconfirmed.dat')) $userdata = array(); else {
        $userdata = @unserialize(@file_get_contents(DATA_PATH . 'users.unconfirmed.dat'));
    }
    if(user_is_confirmed($username)) return true;
    if(@$userdata[$username]['code'] == $key) unset($userdata[$username]); else return false;
    @file_write_contents(DATA_PATH . 'users.unconfirmed.dat', serialize($userdata));
    return true;
}

function user_activate_admin($username){
    if(!is_file(DATA_PATH . 'users.unconfirmed.dat')) $userdata = array(); else {
        $userdata = @unserialize(@file_get_contents(DATA_PATH . 'users.unconfirmed.dat'));
    }
    unset($userdata[$username]);
    @file_write_contents(DATA_PATH . 'users.unconfirmed.dat', serialize($userdata));
    return true;
}

function user_purge_unconfirmed(){
    if(!is_file(DATA_PATH . 'users.unconfirmed.dat')) $userdata = array(); else {
        $userdata = @unserialize(@file_get_contents(DATA_PATH . 'users.unconfirmed.dat'));
    }
    if(!empty($userdata)){
        foreach ($userdata as $user => $data){
            if(($data['time']+(3*24*60*60))<time()){
                unset($userdata[$user]);
                user_delete($user);
            }
        }
    }
    @file_write_contents(DATA_PATH . 'users.unconfirmed.dat', serialize($userdata));
    return true;
}

function user_create_link($user, $nick){
    global $lang;
    if($user != 'guest') return '<a href="index.php?module=user.list&user=' . $user . '">' . $nick . '</a>';
    elseif(!empty($nick)) return $nick;
    else return $lang['users']['guest'];
}

function user_register_in_cache($username, $usernick, $email, &$cache){
    if(!isset($cache) || !is_array($cache)){
        if(!is_file(DATA_PATH . 'users.cache.dat')) $cache = array(); else {
            $cache = @unserialize(@file_get_contents(DATA_PATH . 'users.cache.dat'));
        }
    }
    $cache['nicks'][$username] = $usernick;
    $cache['mails'][$username] = $email;
    file_write_contents(DATA_PATH . 'users.cache.dat', serialize($cache));
    return true;
}

function user_remove_from_cache($username, &$cache){
    if(!isset($cache) || !is_array($cache)){
        if(!is_file(DATA_PATH . 'users.cache.dat')) $cache = array(); else {
            $cache = @unserialize(@file_get_contents(DATA_PATH . 'users.cache.dat'));
        }
    }
    if(!empty($cache['nicks'][$username])) unset($cache['nicks'][$username]);
    if(!empty($cache['mails'][$username])) unset($cache['mails'][$username]);
    file_write_contents(DATA_PATH . 'users.cache.dat', serialize($cache));
    return true;
}

function user_check_nick_in_cache($username, $usernick, &$cache){
    if(!isset($cache) || !is_array($cache)){
        if(!is_file(DATA_PATH . 'users.cache.dat')) $cache = array(); else {
            $cache = @unserialize(@file_get_contents(DATA_PATH . 'users.cache.dat'));
        }
    }
    if(empty($cache['nicks'])) return true;
    return !rcms_in_array_recursive($usernick, $cache['nicks']);
}

function user_check_email_in_cache($username, $email, &$cache){
    if(!isset($cache) || !is_array($cache)){
        if(!is_file(DATA_PATH . 'users.cache.dat')) $cache = array(); else {
            $cache = @unserialize(@file_get_contents(DATA_PATH . 'users.cache.dat'));
        }
    }
    if(empty($cache['mails'])) return true;
    return !rcms_in_array_recursive($email, $cache['mails']);
}
?>