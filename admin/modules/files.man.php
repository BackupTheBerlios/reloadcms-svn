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

if(!empty($_POST['newsave'])){
    if(!empty($_POST['type']) && $_POST['type'] == 1) {
        $_POST['link'] = basename($_POST['link']);
        $size = (int) @filesize(FILES_PATH . $_POST['link']);
    } else {
        $size = '-';
    }
    if(downloads_create_file($_POST['newsave']-1, @$_POST['title'], @$_POST['desc'], @$_POST['link'], $size, @$_POST['author'], DATA_PATH . 'downloads.dat')) rcms_showAdminMessage($lang['files']['fadded']);
    else rcms_showAdminMessage($lang['files']['error']);
} elseif(!empty($_POST['delete']) && is_array($_POST['delete']) && !empty($_POST['cid'])) {
    $result = '';
    $cid = (int) $_POST['cid']-1;
    foreach ($_POST['delete'] as $fid => $cond){
        if(!empty($cond)){
            if(downloads_delete_file($cid, $fid, DATA_PATH . 'downloads.dat')) $result .= $lang['files']['fdeleted'] . ' (' . $cid . ':' . $fid . ')<br>';
            else $result .= $lang['files']['error'] . ' (' . $cid . ':' . $fid . ')<br>';
        }
    }
    rcms_showAdminMessage($result);
    unset($_POST['edit']);
} elseif ((!empty($_POST['edit']) || @$_POST['edit'] === '0') && !empty($_POST['save']) && !empty($_POST['cid'])){
    if(!empty($_POST['type']) && $_POST['type'] == 1) {
        $_POST['link'] = basename($_POST['link']);
        $size = (int) @filesize(FILES_PATH . $_POST['link']);
    } else {
        $size = '-';
    }
    if(downloads_update_file($_POST['cid']-1, $_POST['edit'], @$_POST['title'], @$_POST['desc'], @$_POST['link'], $size, @$_POST['author'], DATA_PATH . 'downloads.dat')) rcms_showAdminMessage($lang['files']['fupdated']);
    else rcms_showAdminMessage($lang['files']['error']);
}

$filesdb = download_get_data_file(DATA_PATH . 'downloads.dat');
////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['new'])){
    $frm = new InputForm ('', 'post', '&lt;&lt;&lt; ' . $lang['general']['back']); $frm->hidden('cid', $_POST['new']); $frm->show();
    $frm = new InputForm ('', 'post', $lang['general']['submit']);
    $frm->addbreak($lang['files']['addfile']);
    $frm->hidden('newsave', $_POST['new']);
    $frm->hidden('cid', $_POST['new']);
    $frm->addrow($lang['files']['title'], $frm->text_box('title', ''));
    $frm->addrow($lang['files']['desc'], $frm->text_box('desc', ''));
    $frm->addrow($lang['files']['author'], $frm->text_box('author', ''));
    $frm->addrow($lang['files']['link'], $frm->text_box('link', ''));
    $frm->addrow($lang['files']['type'], $frm->select_tag('type', $lang['files']['types']));
    $frm->show();
} elseif((!empty($_POST['edit']) || @$_POST['edit'] === '0') && !empty($_POST['cid']) && !empty($filesdb[@$_POST['cid']-1]['files'][@$_POST['edit']])){
    $cid = $_POST['cid'] - 1;
    $fid = $_POST['edit'];
    $frm = new InputForm ('', 'post', '&lt;&lt;&lt; ' . $lang['general']['back']); $frm->hidden('cid', $cid+1); $frm->show();
    $frm = new InputForm ('', 'post', $lang['general']['submit']);
    $frm->addbreak($lang['files']['editfile']);
    $frm->hidden('save', '1');
    $frm->hidden('edit', $_POST['edit']);
    $frm->hidden('cid', $_POST['cid']);
    $frm->addrow($lang['files']['title'], $frm->text_box('title', $filesdb[$cid]['files'][$fid]['name']));
    $frm->addrow($lang['files']['desc'], $frm->text_box('desc', $filesdb[$cid]['files'][$fid]['desc']));
    $frm->addrow($lang['files']['author'], $frm->text_box('author', @$filesdb[$cid]['files'][$fid]['author']));
    $frm->addrow($lang['files']['link'], $frm->text_box('link', $filesdb[$cid]['files'][$fid]['link']));
    $frm->addrow($lang['files']['type'], $frm->select_tag('type', $lang['files']['types']));
    $frm->show();
} elseif(!empty($_POST['cid'])) {
    $frm = new InputForm ('', 'post', '&lt;&lt;&lt; ' . $lang['general']['back']); $frm->show();
    $frm = new InputForm ('', 'post', $lang['files']['addfile']); $frm->hidden('new', $_POST['cid']); $frm->show();
    if(!empty($filesdb[$_POST['cid']-1]['files'])){
        $frm = new InputForm ('', 'post', $lang['general']['submit']);
        $frm->resetButton($lang['general']['reset']);
        $frm->hidden('cid', $_POST['cid']);
        foreach ($filesdb[$_POST['cid']-1]['files'] as $fid => $fdata){
            $frm->addrow($fdata['link'] . '<br>' . $fdata['name'] . ' (' . $fdata['desc'] . '). ' . $lang['files']['filesize'] . $fdata['size'],
                $frm->checkbox('delete[' . $fid . ']', '1', $lang['general']['delete']) . ' ' .
                $frm->radio_button('edit', array($fid => $lang['general']['edit']), 0), 'top'
            );
        }
        $frm->show();
    }
} else {
    $clist = array();
    foreach ($filesdb as $cid => $cdata) $clist[$cid+1] = $cdata['name'];
    if(!empty($clist)){
        $frm =new InputForm ('', 'post', $lang['admincp']['browse']);
        $frm->addrow($lang['files']['browsecat'], $frm->select_tag('cid', $clist));
        $frm->show();
    } else rcms_showAdminMessage($lang['files']['nocats']);
}
?>