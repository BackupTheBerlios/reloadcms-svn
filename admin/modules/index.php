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
if(!LOGGED_IN){
    $frm =new InputForm (RCMS_ROOT_PATH, "post", $lang['users']['login'], '_top');
    $frm->addbreak($lang['admin_cp']['notlogged']);
    $frm->hidden('login_form', '1');
    $frm->addrow($lang['users']['username'], $frm->text_box("username", '', 20), 'top');
    $frm->addrow($lang['users']['password'], $frm->text_box("password", '', 20, 50, true), 'top');
    $frm->addrow($lang['users']['remember'], $frm->checkbox("remember", '1', ''), 'top');
    $frm->show();
} else {
    $rights = &$system->rights;
    if ($rights === array()) {
        $frm =new InputForm (RCMS_ROOT_PATH, "get", $lang['general']['return'], '_top');
        $frm->addbreak($lang['admin_cp']['loggedbutnotadmin']);
        $frm->show();
    } else {
        if(isset($_POST['remarks'])) file_write_contents(DATA_PATH . 'admin_remarks.txt', $_POST['remarks']);
        $frm =new InputForm ('', "post", $lang['general']['submit']);
        $frm->addbreak($lang['admin_cp']['loggedok']);
        if($rights !== 'ROOT') foreach ($rights as $right => $right_desc) $frm->addrow($right, $right_desc, 'top');
        else $frm->addrow($lang['users']['youareroot']);
        $frm->addbreak($lang['admin_cp']['remarks']);
        $frm->addrow($frm->textarea('remarks', file_get_contents(DATA_PATH . 'admin_remarks.txt'), 60, 10), '', 'middle', 'center');
        $frm->show();
    }
}
?>