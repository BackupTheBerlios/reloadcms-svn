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

if (!empty($_POST['profile_form']) && LOGGED_IN) {
    $result = user_update($system->user['username'], false, $_POST['password'], $_POST['confirmation'], $_POST['email'], @$_POST['userdata']);
    $system->config['pagename'] = $lang['users']['profileupdate'];
    $system->showModuleWindow($lang['users']['profileupdate'], $lang['results']['users'][$result]);
} elseif (!empty($_POST['registration_form']) && !LOGGED_IN) {
    $result = user_update($_POST['username'], true, $_POST['password'], $_POST['confirmation'], $_POST['email'], @$_POST['userdata']);
    $system->config['pagename'] = $lang['users']['registration'];
    $system->showModuleWindow($lang['users']['registration'], $lang['results']['users'][$result], 'center');
} elseif (!LOGGED_IN) {
    $system->config['pagename'] = $lang['users']['registration'];
    $system->showModuleWindow($lang['users']['registration'], rcms_parse_module_template('user-profile.tpl', array(
        'mode' => 'registration_form',
        'fields' => $system->data['apf'])));
} elseif (LOGGED_IN) {
    $system->config['pagename'] = $lang['users']['profileupdate'];
    $system->showModuleWindow($lang['users']['profileupdate'], rcms_parse_module_template('user-profile.tpl', array(
        'mode' => 'profile_form',
        'fields' => $system->data['apf'],
        'values' => $system->user)));
}
?>