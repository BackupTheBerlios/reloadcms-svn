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
rcms_loadAdminLib('articles');

/******************************************************************************
* Extracting some data from request                                           *
******************************************************************************/
$work_dir = articles_get_work_dir($null);
if(!empty($work_dir) && $work_dir != ARTICLES_PATH) rcms_showAdminMessage($lang['results']['articles'][8] . $work_dir);

/******************************************************************************
* Perform adding of category                                                  *
******************************************************************************/
if(!empty($_POST['ctitle'])) {
    $res = articles_creare_category($_POST['ctitle'], @$_POST['cdesc'], @$_FILES['cicon'], @$_POST['caccess'], $work_dir);
    rcms_showAdminMessage($lang['results']['articles'][$res]);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$frm =new InputForm ('', 'post', $lang['general']['submit'], '' , 'multipart/form-data', 'mainfrm');
$frm->addbreak($lang['admincp']['articles']['createcat']['full']);
$frm->addrow($lang['articles']['cattitle'], $frm->text_box('ctitle', ''), 'top');
$frm->addrow('', rcms_show_bbcode_panel('document.mainfrm.cdesc'));
$frm->addrow($lang['articles']['catdesc'], $frm->textarea('cdesc', '', 70, 5), 'top');
$frm->addrow($lang['articles']['accesslevel'], $frm->text_box('caccess', ''), 'top');
$frm->addrow($lang['articles']['caticon'], $frm->file('cicon'), 'top');
$frm->show();
?>