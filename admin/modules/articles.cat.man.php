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
* Update categories                                                           *
******************************************************************************/
if(!empty($_POST['cid'])) {
    $result = '';
    $res = articles_update_category(@$_POST['cid'], @$_POST['ctitle'], @$_POST['cdesc'], @$_FILES['cicon'], @$_POST['caccess'], @$_POST['ckillicon'], $work_dir);
    $result .= $lang['results']['articles'][$res] . '<br />';
    if(!empty($_POST['cdel'])) {
        $res = articles_delete_category($_POST['cid'], $work_dir);
        $result .= $lang['results']['articles'][$res] . '<br />';
    }
    rcms_showAdminMessage($result);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$categories_list = articles_get_categories_list(false, false, $work_dir);
if(empty($categories_list)) rcms_showAdminMessage($lang['results']['articles'][9]);
else {
    foreach($categories_list as $data) {
        $frm = new InputForm('', 'post', $lang['general']['submit'], '', 'multipart/form-data', 'cat' . $data['id']);
        $frm->addbreak($lang['admincp']['articles']['managecat']['full'] . $data['title']);
        $frm->hidden('cid', $data['id']);
        $frm->addrow($lang['articles']['cattitle'], $frm->text_box('ctitle', $data['title']));
        $frm->addrow('', rcms_show_bbcode_panel('document.cat' . $data['id'] . '.cdesc'));
        $frm->addrow($lang['articles']['catdesc'], $frm->textarea('cdesc', $data['description']));
        $frm->addrow($lang['articles']['accesslevel'], $frm->text_box('caccess', $data['accesslevel']), 'top');
        if(!$data['icon']) $frm->addrow($lang['articles']['caticon'], $frm->file('cicon'));
        else $frm->addrow($lang['articles']['caticon'] . ' - ' . $data['icon'] . '<br />' . $lang['articles']['chktodel'], $frm->checkbox('ckillicon', '1', ''));
        $frm->addrow($lang['articles']['delete'], $frm->checkbox('cdel', '1', ''));
        $frm->show();
    }
}
?>