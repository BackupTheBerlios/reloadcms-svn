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
$system->config['pagename'] = $lang['users']['forgotpas'];

if(!empty($_POST['sendnewpas']) && !LOGGED_IN) {
    $system->showModuleWindow ('', $lang['results']['users'][user_forgot_password(@$_POST['name'], @$_POST['email'])]);
}
if (!LOGGED_IN) {
    $system->showModuleWindow ($lang['users']['forgotpas'], rcms_parse_module_template('user-respas.tpl', array()));
}
?>