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
rcms_loadAdminLib('ucm');

////////////////////////////////////////////////////////////////////////////////
// Menus control                                                              //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['delete']) && is_array($_POST['delete'])) {
    $msg = '';
    $keys = array_keys($_POST['delete']);
    foreach ($keys as $key){
        $res = ucm_delete($key);
        $msg .= $lang['results']['general'][$res] . '<br />';
    }
    rcms_showAdminMessage($msg);
    unset($_POST['edit']);
} elseif (!empty($_POST['newsave'])) {
    $res = ucm_create(@$_POST['id'], @$_POST['title'], @$_POST['text'], @$_POST['align']);
    rcms_showAdminMessage($lang['results']['general'][$res]);
} elseif (!empty($_POST['edit']) && !empty($_POST['save'])) {
    $res = ucm_change(@$_POST['edit'], @$_POST['id'], @$_POST['title'], @$_POST['text'], @$_POST['align']);
    rcms_showAdminMessage($lang['results']['general'][$res]);
    $_POST['edit'] = @$_POST['id'];
}

////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['new'])){
    $frm = new InputForm ("", "post", $lang['general']['submit']);
    $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
    $frm->addbreak($lang['admincp']['general']['ucm']['create']);
    $frm->hidden('newsave', '1');
    $frm->addrow('<abbr title="' . $lang['general']['ucm']['id_h'] . '">' . $lang['general']['ucm']['id'] . '</abbr>', $frm->text_box('id', ''));
    $frm->addrow('<abbr title="' . $lang['general']['ucm']['title_h'] . '">' . $lang['general']['ucm']['title'] . '</abbr>', $frm->text_box('title', ''));
    $frm->addrow($lang['general']['alignment'], $frm->select_tag('align', $lang['general']['align']));
    $frm->addrow($lang['general']['ucm']['text'] . '<br>' . $lang['general']['ucm']['text_h'], $frm->textarea('text', '', 70, 25), 'top');
    $frm->show();
} elseif(!empty($_POST['edit'])){
    if($menu = ucm_get($_POST['edit'])){
        $frm = new InputForm ("", "post", $lang['general']['submit']);
        $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
        $frm->addbreak($lang['admincp']['general']['ucm']['edit']);
        $frm->hidden('edit', $_POST['edit']);
        $frm->hidden('save', '1');
        $frm->addrow('<abbr title="' . $lang['general']['ucm']['id_h'] . '">' . $lang['general']['ucm']['id'] . '</abbr>', $frm->text_box('id', $_POST['edit']));
        $frm->addrow('<abbr title="' . $lang['general']['ucm']['title_h'] . '">' . $lang['general']['ucm']['title'] . '</abbr>', $frm->text_box('title', $menu[0]));
        $frm->addrow($lang['general']['alignment'], $frm->select_tag('align', $lang['general']['align'], $menu[2]));
        $frm->addrow($lang['general']['ucm']['text'] . '<br>' . $lang['general']['ucm']['text_h'], $frm->textarea('text', $menu[1], 70, 25), 'top');
        $frm->show();
    } else rcms_showAdminMessage($lang['results']['general'][8]);
} else {
    $frm = new InputForm ('', 'post', $lang['general']['createucm']);
    $frm->hidden('new', '1');
    $frm->show();
    $frm = new InputForm ("", "post", $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['general']['ucm']['title']);
    $menus = ucm_list();
    foreach ($menus as $id => $menu){
        $frm->addrow($lang['general']['ucm']['id'] . ': ' . $id . ', ' . $lang['general']['ucm']['title'] . ': ' . $menu[0],
            $frm->checkbox('delete[' . $id . ']', '1', $lang['general']['delete']) . ' ' .
            $frm->radio_button('edit', array($id => $lang['general']['edit']))
        );
    }
    $frm->show();
}
?>