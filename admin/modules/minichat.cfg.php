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
// Update minichat configuration                                              //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['minichat_config'])) {
    if(empty($_POST['minichat_config']['allow_guests_view'])) $_POST['minichat_config']['allow_guests_view'] = '0';
    if(empty($_POST['minichat_config']['allow_guests_post'])) $_POST['minichat_config']['allow_guests_post'] = '0';
    if(empty($_POST['minichat_config']['allow_guests_enter_name'])) $_POST['minichat_config']['allow_guests_enter_name'] = '0';
    if(empty($_POST['minichat_config']['max_db_size'])) $_POST['minichat_config']['max_db_size'] = $_POST['minichat_config']['messages_to_show'];
    write_ini_file($_POST['minichat_config'], CONFIG_PATH . 'minichat.ini');
    rcms_showAdminMessage($lang['admincp']['minichat']['config']['updated']);
}

////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
$minichat_config = parse_ini_file(CONFIG_PATH . "minichat.ini");
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['minichat']['config']['full']);
$frm->addrow($lang['admincp']['minichat']['config']['msgperpage'], $frm->text_box('minichat_config[messages_to_show]', $minichat_config['messages_to_show'], 4));
$frm->addrow($lang['admincp']['minichat']['config']['maxmsglen'], $frm->text_box('minichat_config[max_message_len]', $minichat_config['max_message_len'], 4));
$frm->addrow($lang['admincp']['minichat']['config']['maxwrdlen'], $frm->text_box('minichat_config[max_word_len]', $minichat_config['max_word_len'], 4));
$frm->addrow($lang['admincp']['minichat']['config']['allgstview'], $frm->checkbox('minichat_config[allow_guests_view]', '1', '', $minichat_config['allow_guests_view']));
$frm->addrow($lang['admincp']['minichat']['config']['allgstpost'], $frm->checkbox('minichat_config[allow_guests_post]', '1', '', $minichat_config['allow_guests_post']));
$frm->addrow($lang['admincp']['minichat']['config']['allgstname'], $frm->checkbox('minichat_config[allow_guests_enter_name]', '1', '', $minichat_config['allow_guests_enter_name']));
$frm->addrow($lang['minichat']['maxbasesize'], $frm->text_box('minichat_config[max_db_size]', @$minichat_config['max_db_size']));
$frm->show();
?>