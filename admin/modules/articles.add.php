<?php
////////////////////////////////////////////////////////////////////////////////
//   Copyright (C) 2004 ReloadCMS Development Team                            //
//   http://reloadcms.sf.net                                                  //
//                                                                            //
//   This program is free software. You can redistribute it and/or modify     //
//   it under the terms of either the current Phorum License (viewable at     //
//   phorum.org) or the Phorum License that was distributed with this file    //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   This product released under GNU General Public License v2                //
////////////////////////////////////////////////////////////////////////////////
rcms_loadAdminLib('articles');

/******************************************************************************
* Extracting some data from request                                           *
******************************************************************************/
$work_dir = articles_get_work_dir($null);
if(!empty($work_dir) && $work_dir != ARTICLES_PATH) rcms_showAdminMessage($lang['results']['articles'][8] . $work_dir);

////////////////////////////////////////////////////////////////////////////////
// Perform article posting                                                    //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['a_category'])) {
    $res = articles_save($_POST['a_category'], 0, @$_POST['a_title'], @$_POST['a_src'], @$_POST['a_description'], @$_POST['a_text'], @$_POST['a_mode'], @$_POST['a_comments'], $work_dir);
    rcms_showAdminMessage($lang['results']['articles'][$res]);
}

////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
$categories_list = articles_get_categories_list(true, false, $work_dir);
if(!empty($categories_list)) {
    $frm =new InputForm ('', 'post', $lang['general']['submit'], '' , 'multipart/form-data', 'artadd');
    $frm->addbreak($lang['admincp']['articles']['create']['full']);
    $frm->addrow($lang['articles']['categ'], $frm->select_tag('a_category', $categories_list), 'top');
    $frm->addrow($lang['articles']['subj'], $frm->text_box('a_title', ''), 'top');
    $frm->addrow($lang['articles']['author'], $frm->text_box('a_src', ''), 'top');
    $frm->addrow('', rcms_show_bbcode_panel('document.artadd.a_description'));
    $frm->addrow($lang['articles']['desc'], $frm->textarea('a_description', '', 70, 5), 'top');
    $frm->addrow('', rcms_show_bbcode_panel('document.artadd.a_text'));
    $frm->addrow($lang['articles']['text'], $frm->textarea('a_text', '', 70, 25), 'top');
    $frm->addrow($lang['articles']['mode'], $frm->radio_button('a_mode', $lang['articles']['modes'], 'text'), 'top');
    $frm->addrow($lang['articles']['allowcomments'], $frm->radio_button('a_comments', array('yes' => $lang['admincp']['allow'], 'no' => $lang['admincp']['disallow']), 'yes'), 'top');
    $frm->show();
} else rcms_showAdminMessage($lang['results']['articles'][9]);
?>