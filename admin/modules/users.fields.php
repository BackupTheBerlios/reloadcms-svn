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
if(!empty($_POST['field_id']) && !empty($_POST['field_name'])){
    if(count($_POST['field_id']) != count($_POST['field_id'])){
        rcms_showAdminMessage($lang['results']['users'][9]);
    } else {
        $cnt = count($_POST['field_id']);
        for($i = 0; $i < $cnt; $i++){
            if(!empty($_POST['field_id'][$i])) $result[$_POST['field_id'][$i]] = $_POST['field_name'][$i];
        }
        write_ini_file($result, CONFIG_PATH . 'users.fields.ini') or rcms_showAdminMessage($lang['results']['users'][8]);
    }
}

// Interface generation
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['users']['fields']['full']);
$frm->addrow($lang['users']['fieldid'], $lang['users']['fieldname']);
foreach ($system->data['apf'] as $field_id => $field_name){
    $frm->addrow($frm->text_box('field_id[]', $field_id), $frm->text_box('field_name[]', $field_name));
}
$frm->addrow($frm->text_box('field_id[]', ''), $frm->text_box('field_name[]', ''));
$frm->addmessage($lang['users']['fielddesc']);
$frm->show();
?>