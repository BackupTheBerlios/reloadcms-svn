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
/**
* Main ReloadCMS class. Contains site configuration,
* info about user and session.
*
* @author   Anton Vlasov <druidvav@users.sf.net>
*/
class rcms_system{
    // Public properties
    var $language = '';
    var $skin = '';
    var $config = array();
    var $logged_in = false;
    var $user = array();
    var $results = array();
    var $rights = array();
    var $data = array();
    
    // Private properties
    var $cookie_lang = 'reloadcms_lang';
    var $cookie_skin = 'reloadcms_skin';
    var $cookie_user = 'reloadcms_user';
    var $output = array('modules' => array(), 'menus' => array());
    var $current_point = '';
    
    ////////////////////////////////////////////////////////////////
    // Public functions                                           //
    ////////////////////////////////////////////////////////////////
    /**
     * @return void
     * @param string $language_select_form
     * @param string $skin_select_form
     * @desc This function is a constructor for main reloadcms object. First
             parameter is result of user's language selection, second is result
             of skin selection.
     */
    function rcms_system($language_select_form = '', $skin_select_form = '', $activation_name = '', $activation_key = ''){
        global $rights_db;
        $this->loadConfiguration();
        $this->initializeLanguage($language_select_form);
        $this->initializeSkin($skin_select_form);
        $this->loadLanguage();
        
        // Try to activate user if we get his info
        if(@$this->config['regconf'] && !empty($activation_name) && !empty($activation_key)) {
            if(!user_activate($activation_name, $activation_key)) $this->results['activation'] = 18;
            else $this->results['activation'] = 19;
        }
        
        // Also we must purge unconfirmed users
        if(@$this->config['regconf']) user_purge_unconfirmed();
        
        // And finally initialize user
        $result = $this->initializeUser();
        // and load his rights
        $this->loadRights();
    }
    
    /**
     * @return boolean
     * @param string $username
     * @param string $password
     * @param boolean $remember
     * @desc This function check user's data and log in him.
     */
    function logInUser($username, $password, $remember){
        $username = basename($username);
        if(!$this->logged_in && $this->checkUserData($username, $password, 'user_login', false, $userdata)){
            // OK... Let's allow user to log in :)
            setcookie($this->cookie_user, $username . ':' . $userdata['password'], ($remember) ? time()+3600*24*365 : null);
            $_COOKIE[$this->cookie_user] = $username . ':' . $userdata['password'];
            $this->initializeUser(true);
            $this->loadRights();
            return true;
        } return false;
    }
    
    /**
     * @return boolean
     * @desc This function log out user from system and destroys his cookie.
     */
    function logOutUser(){
        if($this->logged_in){
            setcookie($this->cookie_user, '', time()-3600);
            unset($_COOKIE[$this->cookie_user]);
            $this->initializeUser(true);
            $this->loadRights();
            return true;
        }
    }
    
     /**
     * @param string $right
     * @return boolean
     * @desc Check if user have specified right
     */
    function checkForRight($right = '-any-'){
        if($right == '-any-' && !empty($this->rights)) return true; elseif ($right == '-any-') return false;
        if ($this->rights == 'ROOT') return true; elseif (isset($this->rights[$right])) return true;
        return false;
    }
    
    function showModuleWindow($title, $data, $align = 'left'){ $this->output['modules'][] = array($title, $data, $align); }
    function addInfoToHead($info){ $this->config['meta'] = @$this->config['meta'] . $info; }
    function setCurrentPoint($point){ $this->current_point = $point; }
    
    function showMenuWindow($title, $data, $align = 'left'){ 
        if($this->current_point == '__MAIN__') $this->showModuleWindow($title, $data, $align);
        elseif(!empty($this->current_point)){
            $this->output['menus'][$this->current_point][] = array($title, $data, $align);
        } else return false;
    }
    
    function showWindow($title, $content, $align, $template){
        if($title == '__NOWINDOW__') echo $content;
        elseif(is_readable($template)) require($template);
        else return false;
    }
    
    ////////////////////////////////////////////////////////////////
    // Private functions                                          //
    ////////////////////////////////////////////////////////////////
    /**
     * @return void
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function loads main configuration
             from config.ini to class.
     */
    function loadConfiguration(){
        $this->config = parse_ini_file(CONFIG_PATH . 'config.ini');
        $this->language = $this->config['default_lang'];
        $this->skin = $this->config['default_skin'];
    }
    
    /**
     * @return void
     * @param string $language_select_form
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function initialize and finally
             choose what language will be used in current session. Parameter
             $language_select_form is result of user's language selection.
     */
    function initializeLanguage($language_select_form = ''){
        if(!empty($this->config['allowchlang'])){
            if(!empty($language_select_form) && is_dir(LANG_PATH . basename($language_select_form))) {
                setcookie($this->cookie_lang, basename($language_select_form), FOREVER_COOKIE);
                $_COOKIE[$this->cookie_lang] = basename($language_select_form);
            }
            if(!empty($_COOKIE[$this->cookie_lang])) $this->language = basename($_COOKIE[$this->cookie_lang]);
        }
    }
    
    /**
     * @return void
     * @param string $skin_select_form
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function initialize and finally
             choose what skin will be used in current session. Parameter
             $skin_select_form is result of user's skin selection.
     */    
    function initializeSkin($skin_select_form = ''){
        if(!empty($this->config['allowchskin'])){
            if(!empty($_COOKIE[$this->cookie_skin]) && is_file(SKIN_PATH . basename($_COOKIE[$this->cookie_skin]) . '/skin.general.php')) $this->skin = basename($_COOKIE[$this->cookie_skin]);
            if(!empty($skin_select_form) && is_file(SKIN_PATH . basename($_POST['user_selected_skin']) . '/skin.general.php')) {
                $this->skin = $skin_select_form;
                setcookie($this->cookie_skin, basename($skin_select_form), FOREVER_COOKIE);
            }
        }
        define('CUR_SKIN_PATH', SKIN_PATH . $this->skin . '/');
    }
    
    /**
     * @return void
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function loads language data
             into rCMS variables.
     */ 
    function loadLanguage(){
        global $lang, $rights_db;
        $lngdir = rcms_scandir(LANG_PATH . $this->language);
        foreach ($lngdir as $langfile){
            if(is_file(LANG_PATH . $this->language . '/' . $langfile) && $langfile != 'langid.txt'){
                include_once(LANG_PATH . $this->language . '/' . $langfile);
            }
        }
    }
    
    /**
     * @return boolean
     * @param string $skipcheck Use this parameter to skip userdata checks
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function initialize user and
             load his profile to object.
     */
    function initializeUser($skipcheck = false){
        global $lang;
        // Load default guest userdata
        $this->user = array('nickname' => $lang['users']['guest'], 'username' => 'guest', 'admin' => ' ', 'tz' => 0);
        // If user cookie is not present we exiting without error
        if(empty($_COOKIE[$this->cookie_user])) {
            $this->logged_in = false;
            return true;
        }
        // So we have a cookie, let's extract data from it
        $cookie_data = explode(':', $_COOKIE[$this->cookie_user], 2);
        if($skipcheck){
            // If this cookie is invalid - we exiting destroying cookie and exiting with error
            if(count($cookie_data) != 2){
                setcookie($this->cookie_user, null, time()-3600);
                $this->results['user_init'] = 15;
                return false;
            }
            // Now we must validate user's data
            if($this->checkUserData($cookie_data[0], $cookie_data[1], 'user_init', true, $this->user)){
                $this->logged_in = true;
                return true;
            } else {
                setcookie($this->cookie_user, null, time()-3600);
                $this->logged_in = false;
                return false;
            }
        }
        
        $userdata = load_user_info($cookie_data[0]);
        if($userdata == false){
            setcookie($this->cookie_user, null, time()-3600);
            $this->logged_in = false;
            return false;
        }
        $this->user = $userdata;
        $this->logged_in = true;
        return true;
    }
    
    /**
     * @return boolean
     * @param string $username
     * @param string $password
     * @param string $report_to
     * @param boolean $hash
     * @param link $userdata
     * @desc This function is an internal private function for class rcms_system
             and must not be used externally. This function check user's data and
             validate his data file.
     */
    function checkUserData($username, $password, $report_to, $hash, &$userdata){
        if(preg_replace("/[\d\w]+/i", "", $username) != ""){
            $this->results[$report_to] = 14;
            return false;
        }
        // If login is not exists - we exiting with error
        if(!is_file(USERS_PATH . $username)){
            $this->results[$report_to] = 16;
            return false;
        }
        // So all is ok. Let's load userdata
        $result = load_user_info($username);
        // If userdata is invalid we must delete invalid user
        // and exit with error
        if(empty($result)){
            user_delete($username);
            $this->results[$report_to] = 14;
            return false;
        }
        // If password is invalid - exit with error
        if((!$hash && md5($password) !== $result['password']) || ($hash && $password !== $result['password'])) {
            $this->results[$report_to] = 13;
            return false;
        }
        // If user is blocked - exit with error
        if(@$result['blocked']) {
            $this->results[$report_to] = 7;
            return false;
        }
        // If activation is ON and user doesnot confirm it's account
        if(@$this->config['regconf'] && !user_is_confirmed($result['username'])) {
            $this->results[$report_to] = 17;
            return false;
        }
        $userdata = $result;
        return true;
    }
    
    function loadRights(){
        global $rights_db;
        $this->rights = array();
        if($this->user['admin'] !== '*') {
            preg_match_all('/\|(.*?)\|/', $this->user['admin'], $rights_r);
            foreach ($rights_r[1] as $right){
                $this->rights[$right] = (empty($rights_db[$right])) ? ' ' : $rights_db[$right];
            }
        } else {
            $this->rights = 'ROOT';
        }
    }
}
?>