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

if(!empty($_GET['user']) && $userdata = load_user_info(basename($_GET['user']))){
    $system->config['pagename'] = $lang['users']['registeredusers'] . ' - ' . $userdata['username'];
    $system->showModuleWindow ('', rcms_parse_module_template('user-view.tpl', array('userdata' => $userdata, 'fields' => $system->data['apf'])));
} else {
    $system->config['pagename'] = $lang['users']['registeredusers'];
    $system->showModuleWindow($lang['users']['registeredusers'], rcms_parse_module_template('user-list.tpl', user_get_list()));
}
?>