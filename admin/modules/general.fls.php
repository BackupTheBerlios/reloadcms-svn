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
rcms_loadAdminLib('file-uploads');

/******************************************************************************
* Perform uploading                                                           *
******************************************************************************/
if(!empty($_FILES['upload'])) {
    $res = fupload_array($_FILES['upload']);
    rcms_showAdminMessage($lang['results']['general'][$res]);
}
/******************************************************************************
* Perform deletion                                                            *
******************************************************************************/
if(!empty($_POST['delete'])) {
    $result = '';
    foreach ($_POST['delete'] as $file => $cond){
        $file = basename($file);
        if(!empty($cond)) {
            $res = fupload_delete($file);
            $result .= $lang['results']['general'][$res];
        }
    }
    if(!empty($result)) rcms_showAdminMessage($result);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$frm =new InputForm ("", "post", $lang['general']['submit'], '' , 'multipart/form-data');
$frm->addbreak($lang['admincp']['general']['files']['upload']);
$frm->addrow($lang['general']['selflstoupl'], $frm->file('upload[]') . $frm->file('upload[]') . $frm->file('upload[]'), 'top');
$frm->show();
$files = fupload_get_list();
$frm =new InputForm ("", "post", $lang['general']['submit'], '' , 'multipart/form-data');
$frm->addbreak($lang['admincp']['general']['files']['full']);
if(!empty($files)) 
    foreach ($files as $file) 
        $frm->addrow($lang['general']['filename'] . ' = ' . $file['name'] . ' [' . $lang['general']['filesize'] . ' = ' . $file['size'] . '] [' . $lang['general']['filemtime'] . ' = ' . date("d F Y H:i:s", $file['mtime']) . ']', $frm->checkbox('delete[' . $file['name'] . ']', 'true', $lang['general']['deletefile']), 'top');
$frm->show();
?>