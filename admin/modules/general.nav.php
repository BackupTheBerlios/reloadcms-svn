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
if(!empty($_POST['urls']) && !empty($_POST['names']) && is_array($_POST['urls']) && is_array($_POST['names'])){
    if(count($_POST['urls']) !== count($_POST['names'])){
        rcms_showAdminMessage($lang['general']['navigation_error']);
    } else {
        $result = array();
        $cnt = count($_POST['urls']);
        for($i = 0; $i < $cnt; $i++){
            if(!empty($_POST['urls'][$i])) {
                $result[$i]['url'] = @$_POST['urls'][$i];
                $result[$i]['name'] = $_POST['names'][$i];
            }
        }
        write_ini_file($result, CONFIG_PATH . 'navigation.ini', true) or rcms_showAdminMessage($lang['general']['navigation_error']);
    }
}

$links = parse_ini_file(CONFIG_PATH . 'navigation.ini', true);

// Interface generation
$frm =new InputForm ("", "post", $lang['general']['submit']);
$frm->addbreak($lang['admincp']['general']['navigation']['title']);
$frm->addrow($lang['general']['url'], $lang['general']['title']);
foreach ($links as $link){
    $frm->addrow($frm->text_box('urls[]', $link['url']), $frm->text_box('names[]', $link['name']));
}
$frm->addrow($frm->text_box('urls[]', ''), $frm->text_box('names[]', ''));
$frm->addmessage($lang['general']['navigation_desc']);
$frm->show();
?>