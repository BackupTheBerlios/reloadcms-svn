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
// Loading system libraries                                                   //
////////////////////////////////////////////////////////////////////////////////
include_once(SYSTEM_MODULES_PATH . 'filesystem.php');
include_once(SYSTEM_MODULES_PATH . 'etc.php');
include_once(SYSTEM_MODULES_PATH . 'templates.php');
include_once(SYSTEM_MODULES_PATH . 'system.php');
include_once(SYSTEM_MODULES_PATH . 'users.php');

////////////////////////////////////////////////////////////////////////////////
// Initializing session                                                       //
////////////////////////////////////////////////////////////////////////////////
$system = new rcms_system(@$_POST['lang_form'], @$_POST['user_selected_skin'], @$_GET['activate'], @$_GET['key']);
if(!empty($_POST['login_form']))  $system->logInUser(@$_POST['username'], @$_POST['password'], !empty($_POST['remember']) ? true : false);
if(!empty($_POST['logout_form'])) $system->logOutUser();
define('LOGGED_IN', $system->logged_in);

////////////////////////////////////////////////////////////////////////////////
// User's API constants                                                       //
////////////////////////////////////////////////////////////////////////////////
define('USERS_ALLOW_CHANGE', 0);
define('USERS_ALLOW_SET', 1);
define('USERS_DISALLOW_CHANGE', 2);

////////////////////////////////////////////////////////////////////////////////
// User's API main data loading                                               //
////////////////////////////////////////////////////////////////////////////////
$system->data['apf'] = parse_ini_file(CONFIG_PATH . 'users.fields.ini');
// Enter access levels for fields here
$userfields[0] = array(
    'nickname' => USERS_ALLOW_CHANGE,
    'hideemail' => USERS_ALLOW_CHANGE,
    'admin' => USERS_DISALLOW_CHANGE,
    'tz' => USERS_ALLOW_CHANGE,
    'accesslevel' => USERS_DISALLOW_CHANGE,
    'blocked' => USERS_DISALLOW_CHANGE
);
foreach ($system->data['apf'] as $field => $desc) $userfields[0][$field] = USERS_ALLOW_CHANGE;

// Enter default values for fields here
$userfields[1] = array('hideemail' => 0, 'admin' => ' ', 'tz' => 0, 'accesslevel' => 0, 'blocked' => 0);

// Show some messages about activation or initialization
if(!empty($system->results['activation'])) $system->showModuleWindow('', $lang['results']['users'][$system->results['activation']], 'center');
if(!empty($system->results['user_init'])) $system->showModuleWindow('', $lang['results']['users'][$system->results['user_init']], 'center');
            
?>