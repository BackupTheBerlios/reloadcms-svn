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

if (!empty($system->results['user_login'])) {
    $system->showMenuWindow($lang['users']['login'], $lang['results']['users'][$system->results['user_login']], 'center');
}
$system->showMenuWindow($lang['users']['hello'] . $system->user['nickname'], rcms_parse_module_template('user-panel.tpl', array()));
?>