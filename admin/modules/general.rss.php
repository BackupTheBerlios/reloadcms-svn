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
if(!empty($_POST['rss'])) write_ini_file($_POST['rss'], CONFIG_PATH . 'rss.ini');

$rss_cfg = @parse_ini_file(CONFIG_PATH . 'rss.ini');

// Interface generation
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['general']['rss']['title']);
$frm->addrow($lang['rss']['enable'], $frm->checkbox('rss[enable]', '1', '', @$rss_cfg['enable']));
$frm->addrow($lang['rss']['rssbases'], $frm->text_box("rss[bases]", @$rss_cfg['bases'], 40), 'top');
$frm->addrow($lang['rss']['language'] . '<br>' . $lang['rss']['language_desc'], $frm->text_box("rss[language]", @$rss_cfg['language'], 40), 'top');
$frm->addrow($lang['rss']['description'], $frm->text_box("rss[description]", @$rss_cfg['description'], 60), 'top');
$frm->addrow($lang['rss']['copyright'], $frm->text_box("rss[copyright]", @$rss_cfg['copyright'], 60), 'top');
$frm->show();
?>