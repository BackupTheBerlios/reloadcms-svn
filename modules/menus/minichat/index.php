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
$minichat_config = parse_ini_file(CONFIG_PATH . "minichat.ini");

if(!LOGGED_IN && !$minichat_config['allow_guests_view']) return;
if(!empty($_POST['mctext']) && (LOGGED_IN || $minichat_config['allow_guests_post'])) {
    guestbook_add_post(DATA_PATH . 'gstbooks/minichat.last', $_POST['mctext'], @$_POST['mcnick'], 'minichat.ini');
} 
if((!empty($_POST['mcdelete']) || @$_POST['mcdelete'] === '0') && $system->checkForRight('MC-C')) {
    guestbook_remove_post(DATA_PATH . 'gstbooks/minichat.last', $_POST['mcdelete'], 'minichat.ini');
}

$result = '';
$list = guestbook_get_last_msgs(DATA_PATH . 'gstbooks/minichat.last', 'minichat.ini');
foreach ($list as $message_id => $message){
    $result .= rcms_parse_module_template('minichat-mesg.tpl', array('id' => $message_id) + $message);
}

if(LOGGED_IN || $minichat_config['allow_guests_post']) {
    $result .= rcms_parse_module_template('minichat-form.tpl', array('allow_guests_enter_name' => $minichat_config['allow_guests_enter_name']));
}

$system->showMenuWindow($lang['minichat']['title'], $result, "center");
?>