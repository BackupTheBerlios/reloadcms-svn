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
if(!empty($_POST['nconfig'])) write_ini_file($_POST['nconfig'], CONFIG_PATH . 'config.ini');
if(isset($_POST['meta_tags'])) file_write_contents(DATA_PATH . "meta_tags.html", $_POST['meta_tags']);
if(isset($_POST['top'])) file_write_contents(DATA_PATH . "top.html", $_POST['top']);
if(isset($_POST["welcome_mesg"])) file_write_contents(DATA_PATH . 'intro.html', $_POST["welcome_mesg"]);

$system->loadConfiguration();
$config = &$system->config;
// Interface generation
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['general']['config']['full']);
$frm->addrow($lang['admincp']['general']['config']['sitename'], $frm->text_box("nconfig[title]", $config['title'], 40));
$frm->addrow($lang['admincp']['general']['config']['siteurl'], $frm->text_box("nconfig[site_url]", $config['site_url'], 40));
$frm->addrow($lang['admincp']['general']['config']['defskin'], user_skin_select(SKIN_PATH, 'nconfig[default_skin]', $config['default_skin']));
$frm->addrow($lang['admincp']['general']['config']['deflang'], user_lang_select(LANG_PATH, 'nconfig[default_lang]', $config['default_lang']));
$frm->addrow($lang['admincp']['general']['config']['latestnumber'], $frm->text_box('nconfig[num_of_latest]', @$config['num_of_latest']));
$frm->addrow($lang['general']['perpage'], $frm->text_box('nconfig[perpage]', @$config['perpage']));
$frm->addrow($lang['admincp']['general']['config']['allowchskin'], $frm->checkbox('nconfig[allowchskin]', '1', '', @$config['allowchskin']));
$frm->addrow($lang['admincp']['general']['config']['allowchlang'], $frm->checkbox('nconfig[allowchlang]', '1', '', @$config['allowchlang']));
$frm->addrow($lang['admincp']['general']['config']['regconfirmation'], $frm->checkbox('nconfig[regconf]', '1', '', @$config['regconf']));
$frm->addrow($lang['admincp']['general']['config']['meta'], $frm->textarea("meta_tags", file_get_contents(DATA_PATH . "meta_tags.html"), 80, 5));
$frm->addrow($lang['admincp']['general']['config']['top'], $frm->textarea("top", file_get_contents(DATA_PATH . "top.html"), 80, 5));
$frm->addrow($lang['admincp']['general']['config']['welcome'], $frm->textarea("welcome_mesg", file_get_contents(DATA_PATH . 'intro.html'), 80, 10), 'top');
$frm->show();
?>