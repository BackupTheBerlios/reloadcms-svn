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
if(!empty($_POST['poll_new'])){
    rcms_showAdminMessage($lang['results']['polls'][poll_create($_POST['poll_question'], $_POST['poll_variants'])]);
}
if(!empty($_POST['rmpoll'])){
    rcms_showAdminMessage($lang['results']['polls'][poll_remove()]);
}

if(!poll_is_running()){
    $frm =new InputForm ("", "post", $lang['general']['submit']);
    $frm->addbreak($lang['admincp']['poll']['poll']['new']);
    $frm->hidden('poll_new', '1');
    $frm->addrow($lang['poll']['question'], $frm->text_box("poll_question", '', 40));
    $frm->addrow($lang['poll']['answers'], $frm->textarea("poll_variants", '', 50, 10), 'top');
    $frm->show();
} else {
    $polldata =  poll_get();
    $frm =new InputForm ("", "post", $lang['general']['submit']);
    $frm->addrow($lang['poll']['question'] . ': ' . $polldata['q']);
    foreach ($polldata['v'] as $id => $answer) $frm->addrow($polldata['c'][$id], $answer);
    $frm->addrow($frm->checkbox('rmpoll', '1', $lang['admincp']['poll']['poll']['del']));
    $frm->show();    
}
?>