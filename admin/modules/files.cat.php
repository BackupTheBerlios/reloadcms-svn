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

if(!empty($_POST['newsave']))
    if(downloads_create_category(@$_POST['ctitle'], @$_POST['cdesc'], DATA_PATH . 'downloads.dat')) rcms_showAdminMessage($lang['files']['ccreated']);
    else rcms_showAdminMessage($lang['files']['error']);
elseif(!empty($_POST['delete']) && is_array($_POST['delete'])) {
    $result = '';
    foreach ($_POST['delete'] as $id => $cond){
        if(!empty($cond)){
            if(downloads_delete_category($id, DATA_PATH . 'downloads.dat')) $result .= $lang['files']['cdeleted'] . ' (' . $id . ')<br>';
            else $result .= $lang['files']['error'] . ' (' . $id . ')<br>';
        }
    }
    rcms_showAdminMessage($result);
    $_POST['edit'] = 0;
} elseif (!empty($_POST['edit']) && !empty($_POST['save'])){
    if(downloads_save_category($_POST['edit']-1, @$_POST['ctitle'], @$_POST['cdesc'], DATA_PATH . 'downloads.dat'))
        rcms_showAdminMessage($lang['files']['cupdated']);
    else rcms_showAdminMessage($lang['files']['error']);
}

////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['new'])){
    $frm = new InputForm ('', 'post', $lang['general']['submit']);
    $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
    $frm->addbreak($lang['files']['createcat']);
    $frm->hidden('newsave', '1');
    $frm->addrow($lang['files']['ctitle'], $frm->text_box('ctitle', ''));
    $frm->addrow($lang['files']['cdesc'], $frm->text_box('cdesc', ''));
    $frm->show();
} elseif(!empty($_POST['edit']) && $filesdb = download_get_data_file(DATA_PATH . 'downloads.dat')){
    if(!empty($filesdb[$_POST['edit']-1])){
        $category = &$filesdb[$_POST['edit']-1];
        $frm = new InputForm ('', 'post', $lang['general']['submit']);
        $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
        $frm->addbreak($lang['files']['editcat']);
        $frm->hidden('save', '1');
        $frm->hidden('edit', $_POST['edit']);
        $frm->addrow($lang['files']['ctitle'], $frm->text_box('ctitle', $category['name']));
        $frm->addrow($lang['files']['cdesc'], $frm->text_box('cdesc', $category['desc']));
        $frm->show();
    } else rcms_showAdminMessage($lang['files']['invalidid']);
} else {
    $frm = new InputForm ('', 'post', $lang['files']['createcat']);
    $frm->hidden('new', '1');
    $frm->show();
    $frm = new InputForm ('', 'post', $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $filesdb = download_get_data_file(DATA_PATH . 'downloads.dat');
    if(!empty($filesdb)){
        foreach ($filesdb as $cid => $cdata){
            $frm->addrow($cdata['name'] . ' (' . $cdata['desc'] . '). ' . $lang['files']['cfiles'] . count($cdata['files']),
                $frm->checkbox('delete[' . $cid . ']', '1', $lang['general']['delete']) . ' ' .
                $frm->radio_button('edit', array($cid+1 => $lang['general']['edit']), 0)
            );
        }
    }
    $frm->show();
}
?>