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
$images = rcms_scandir(GALLERY_PATH);

function is_pic($element){
    return preg_match('/.*\.(jpg|gif|png|bmp|JPG|GIF|BMP|PNG)$/', $element);
}

rcms_chtitle($lang['gallery']['menu']);

function show_gallery_item($id) {
    global $system;
    $images = rcms_scandir(GALLERY_PATH);
    $gal='';
    for ($i=0; $i<count($images); $i++) { 
        if (is_pic($images[$i])) {
            if ($id != $i) $gal .= '<a href="?module=gallery&id=' . $i . '">[' . $i . ']</a> '; 
            else $gal .= '<b>[' . $i . ']</b>&nbsp;'; 
        }
    }
    $gal .= '<br><hr>';
    $gal .= '<p align="center"><img src="' . GALLERY_PATH . $images[$id] . '"></p><br>';
    $system->showModuleWindow('', $gal, 'left');
}

function gallery_get_comments($id) {
    $images = rcms_scandir(GALLERY_PATH);
    if($data = @file_get_contents(GALLERY_PATH . $images[$id] . '.cm')){
        $data = unserialize($data);
        foreach($data as $i => $msg){ 
            if(!empty($data[$i])) $data[$i]['text'] = rcms_parse_text($data[$i]['text'], true, false, true, 50); 
        } 
        return $data;
    } else return array(); 
}

function gallery_post_comment($id, $text) {
    global $system;
    $images = rcms_scandir(GALLERY_PATH);
    if($data = @file_get_contents(GALLERY_PATH .  $images[$id] . '.cm')) $data = unserialize($data); else $data = array();
    $newmesg['author_user'] = $system->user["username"];
    $newmesg['author_nick'] = $system->user["nickname"];
    $newmesg['time'] = rcms_get_time();
    $newmesg['text'] = substr($text, 0, 2048);
    $data[] = $newmesg;
    file_write_contents(GALLERY_PATH .  $images[$id] . '.cm', serialize($data));
    return true;
}

function gallery_delete_comment($id, $cid) {
    $images = rcms_scandir(GALLERY_PATH);
    if($data = @file_get_contents(GALLERY_PATH .  $images[$id] . '.cm')) $data = unserialize($data); else return false;
    if(isset($data[$cid])) {
        unset($data[$cid]);
        file_write_contents(GALLERY_PATH .  $images[$id] . '.cm', serialize($data));
    }
    return true;
} 

if(!empty($images)){
    if (!isset($_GET['id'])) $_GET['id'] = 0;
    show_gallery_item($_GET['id']);
    if(!empty($_POST['comtext'])) gallery_post_comment($_GET['id'], $_POST['comtext']); 
    if(isset($_POST['cdelete']) && $system->checkForRight('A-MA')) gallery_delete_comment($_GET['id'], $_REQUEST['cdelete']);
    $comm = gallery_get_comments($_GET['id']);
    if (!empty($comm)) $system->showModuleWindow('Comments', rcms_parse_module_template('comment.tpl', $comm), "center");
    $system->showModuleWindow($lang['articles']['postcomment'], rcms_parse_module_template('comment-post.tpl', $comm), 'center');
} else $system->showModuleWindow('', $lang['gallery']['empty']);
?>