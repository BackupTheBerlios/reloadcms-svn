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
if(!empty($_POST['block']) && is_array($_POST['block'])){
    $res = '';
    foreach ($_POST['block'] as $username=>$block) {
        if($block) $res .= $lang['results']['users'][user_change_field($username, 'blocked', '1')];
    }
    rcms_showAdminMessage($res);
}
if(!empty($_POST['unblock']) && is_array($_POST['unblock'])){
    $res = '';
    foreach ($_POST['unblock'] as $username=>$unblock) {
        if($unblock) $res .= $lang['results']['users'][user_change_field($username, 'blocked', '0')];
    }
    rcms_showAdminMessage($res);
}
if(!empty($_POST['delete']) && is_array($_POST['delete'])){
    $res = '';
    foreach ($_POST['delete'] as $username=>$delete) if($delete) $res .= $lang['results']['users'][user_delete($username)];
    rcms_showAdminMessage($res);
}
if(!empty($_POST['edit']) && !empty($_POST['save'])){
    rcms_showAdminMessage($lang['results']['users'][user_update($_POST['edit'], false, '', '', $_POST['email'], @$_POST['userdata'], true)]);
}
if(!empty($_POST['rights']) && !empty($_POST['save'])){
    rcms_showAdminMessage($lang['results']['users'][user_set_rights($_POST['rights'], @$_POST['rootuser'], @$_POST['_rights'])]);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['users']['profiles']['title']);
$frm->addrow($lang['users']['usersearch'], $frm->text_box('search', @$_POST['search']));
$frm->show();
if(!empty($_POST['edit']) && $userdata = load_user_info($_POST['edit'])){
    $frm =new InputForm ("", "post", $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['users']['profiles']['edit'] . $userdata['username']);
    $frm->hidden('edit', $userdata['username']);
    $frm->hidden('save', '1');
    $frm->addrow($lang['users']['username'], $userdata['username']);
    $frm->addrow($lang['users']['password'], ' [ ' . $lang['admincp']['hidden'] . ' ] ');
    $frm->addrow($lang['users']['nickname'], $frm->text_box('userdata[nickname]', $userdata['nickname']));
    $frm->addrow($lang['users']['email'], $frm->text_box('email', $userdata['email']));
    $frm->addrow($lang['users']['hideemail'], $frm->checkbox('userdata[hideemail]', '1', '', ((!isset($userdata['hideemail'])) ? true : ($userdata['hideemail']) ? true : false)));
    $frm->addrow($lang['users']['accesslevel'], $frm->text_box('userdata[accesslevel]', @$userdata['accesslevel']));
    $frm->addrow($lang['users']['timezone'], user_tz_select($userdata['tz'], 'userdata[tz]'));
    foreach ($system->data['apf'] as $field_id => $field_name) {
        $frm->addrow($field_name, $frm->text_box('userdata[' . $field_id . ']', $userdata[$field_id]));
    }
    $frm->show();
} elseif(!empty($_POST['rights']) && $userdata = load_user_info($_POST['rights'])){
    $frm =new InputForm ("", "post", $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['users']['profiles']['edit'] . $userdata['username']);
    $frm->hidden('rights', $userdata['username']);
    $frm->hidden('save', '1');
    if($userdata['admin'] == '*'){
        $frm->addrow($lang['users']['rootuser'], $frm->checkbox('rootuser', '1', '', true));
    } else {
        $frm->addrow($lang['users']['rootuser'], $frm->checkbox('rootuser', '1', '', false));
        foreach ($rights_db as $right_id => $right_desc){
            $frm->addrow($right_desc, $frm->checkbox('_rights[' . $right_id . ']', '1', '', user_check_right($_POST['rights'], $right_id)));
        }
    }
    $frm->show();
} elseif(!empty($_POST['search'])){
    $result = user_get_list($_POST['search']);
    $frm =new InputForm ("", "post", $lang['general']['submit']);
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['users']['profiles']['searchresult']);
    $frm->addrow($lang['admincp']['users']['profiles']['searchresult_h']);
    $frm->hidden('search', $_POST['search']);
    foreach ($result as $userdata){
        $frm->addrow($lang['users']['username'] . ': ' . $userdata['username'] . ', ' . $lang['users']['nickname'] . ': ' . $userdata['nickname'],
            $frm->checkbox('delete[' . $userdata['username'] . ']', '1', $lang['general']['delete']) . ' ' .
            ((!@$userdata['blocked']) ? $frm->checkbox('block[' . $userdata['username'] . ']', '1', $lang['users']['block']) . ' ' :
            $frm->checkbox('unblock[' . $userdata['username'] . ']', '1', $lang['users']['unblock']) . '' ) . 
            $frm->radio_button('edit', array($userdata['username'] => $lang['general']['edit'])) . ' ' .
            $frm->radio_button('rights', array($userdata['username'] => $lang['users']['editrights'])));
    }
    $frm->show();
}
?>