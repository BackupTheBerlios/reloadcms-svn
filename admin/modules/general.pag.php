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
// Pages control                                                              //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['delete']) && is_array($_POST['delete'])) {
    $msg = '';
    $keys = array_keys($_POST['delete']);
    foreach ($keys as $key){
        if(page_get_langs($key)) {
            foreach ($_POST['delete'][$key] as $alang=>$akey){
                if($akey && page_delete($key, $alang)) $msg .= $lang['results']['general'][0] . '<br />';
                else $msg .= $lang['results']['general'][9] . '<br />';
            }
        } else $msg .= $lang['results']['general'][10] . '<br />';
    }
    rcms_showAdminMessage($msg);
    unset($_POST['edit']);
} elseif (!empty($_POST['newsave'])) {
    $res = page_create(@$_POST['name'], @$_POST['lang'], @$_POST['title'], @$_POST['text']);
    rcms_showAdminMessage($lang['results']['general'][$res]);
} elseif (!empty($_POST['edit']) && !empty($_POST['save'])) {
    if(($pd = explode('.', $_POST['edit'])) && ($page = page_get($pd[0], $pd[1]))){
        $res = page_change(@$pd[0], @$pd[1], @$_POST['name'], @$_POST['lang'], @$_POST['title'], @$_POST['text']);
        rcms_showAdminMessage($lang['results']['general'][$res]);
        if($res == 0) $_POST['edit'] = @$_POST['name'] . '.' . @$_POST['lang'];
    } else rcms_showAdminMessage($lang['results']['general'][8]);
    
}

////////////////////////////////////////////////////////////////////////////////
// Interface generation                                                       //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['new'])){
    $frm = new InputForm ("", "post", $lang['general']['submit']);
    $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
    $frm->addbreak($lang['admincp']['general']['pages']['create']);
    $frm->hidden('newsave', '1');
    $frm->addrow('<abbr title="' . $lang['general']['pages']['pageid_h'] . '">' . $lang['general']['pages']['pageid'] . '</abbr>', $frm->text_box('name', ''));
    $frm->addrow('<abbr title="' . $lang['general']['pages']['pageid_h'] . '">' . $lang['general']['pages']['pagelang'] . '</abbr>', $frm->text_box('lang', ''));
    $frm->addrow($lang['general']['pages']['pagetitle'], $frm->text_box('title', ''));
    $frm->addrow($lang['general']['pages']['pagetext'] . '<br>' . $lang['general']['pages']['pagetext_h'], $frm->textarea('text', '', 70, 25), 'top');
    $frm->show();
} elseif(!empty($_POST['edit'])){
    if(($pd = explode('.', $_POST['edit'])) && ($page = page_get($pd[0], $pd[1]))){
        $frm = new InputForm ("", "post", $lang['general']['submit']);
        $frm->addmessage('<a href="">&lt;&lt;&lt; ' . $lang['general']['back'] . '</a>');
        $frm->addbreak($lang['admincp']['general']['pages']['edit']);
        $frm->hidden('edit', $pd[0] . '.' . $pd[1]);
        $frm->hidden('save', '1');
        $frm->addrow('<abbr title="' . $lang['general']['pages']['pageid_h'] . '">' . $lang['general']['pages']['pageid'] . '</abbr>', $frm->text_box('name', $pd[0]));
        $frm->addrow('<abbr title="' . $lang['general']['pages']['pageid_h'] . '">' . $lang['general']['pages']['pagelang'] . '</abbr>', $frm->text_box('lang', $pd[1]));
        $frm->addrow($lang['general']['pages']['pagetitle'], $frm->text_box('title', $page['title']));
        $frm->addrow($lang['general']['pages']['pagetext'] . '<br>' . $lang['general']['pages']['pagetext_h'], $frm->textarea('text', $page['text'], 70, 25), 'top');
        $frm->show();
    } else rcms_showAdminMessage($lang['results']['general'][8]);
} else {
    $frm = new InputForm ('', 'post', $lang['general']['createpage']);
    $frm->hidden('new', '1');
    $frm->show();
    $pages = page_get_list();
    $frm = new InputForm ("", "post", $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['general']['pages']['title']);
    if(!empty($pages)) {
        foreach ($pages as $page => $langs){
            foreach ($langs as $alang => $title){
                $frm->addrow($lang['general']['pages']['pageid'] . ': ' . $page . ', ' . $lang['general']['pages']['pagelang'] . ': ' . $alang . ', ' . $lang['general']['pages']['pagetitle'] . ': ' . $title,
                    $frm->checkbox('delete[' . $page . '][' . $alang . ']', '1', $lang['general']['delete']) . ' ' .
                    $frm->radio_button('edit', array($page . '.' . $alang => $lang['general']['edit']))
                );
            }
        } 
    }
    $frm->show();
}
?>