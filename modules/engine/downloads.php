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

function download_get_data_file($file){
    if(!($cont = @file_get_contents($file))) return array();
    return @unserialize($cont);
}

function download_save_data_file($file, $cont){
    if(!is_writeable($file) && is_file($file)) return false;
    $res = array();
    foreach ($cont as $key => $value){
        if($value !== false) $res[$key] = $value;
    }
    if(!($data = serialize($res))) return false;
    if(!(file_write_contents($file, $data))) return false;
    return true;
}

function downloads_create_category($name, $desc, $file){
    if(empty($name)) return false;
    if(($data = download_get_data_file($file)) === false) return false;
    $data[] = array('name' => $name, 'desc' => $desc, 'files' => array());
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}

function downloads_save_category($id, $name, $desc, $file){
    if(empty($name)) return false;
    if(($data = download_get_data_file($file)) === false) return false;
    if(empty($data[$id])) return false;
    $data[$id]['name'] = $name;
    $data[$id]['desc'] = $desc;
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}

function downloads_delete_category($id, $file){
    if(($data = download_get_data_file($file)) === false) return false;
    $data[$id] = false;
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}

function downloads_create_file($cid, $name, $desc, $link, $size, $author, $file){
    if(empty($name)) return false;
    if(($data = download_get_data_file($file)) === false) return false;
    if(empty($data[$cid])) return false;
    $data[$cid]['files'][] = array('name' => $name, 'desc' => $desc, 'link' => $link, 'size' => $size, 'date' => rcms_get_time(),  'author' => $author);
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}

function downloads_update_file($cid, $fid, $name, $desc, $link, $size, $author, $file){
    if(empty($name)) return false;
    if(($data = download_get_data_file($file)) === false) return false;
    if(empty($data[$cid])) return false;
    if(empty($data[$cid]['files'][$fid])) return false;
    $data[$cid]['files'][$fid]['name'] = $name;
    $data[$cid]['files'][$fid]['link'] = $link;
    $data[$cid]['files'][$fid]['size'] = $size;
    $data[$cid]['files'][$fid]['author'] = $author;
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}

function downloads_delete_file($cid, $fid, $file){
    if(($data = download_get_data_file($file)) === false) return false;
    if(empty($data[$cid])) return false;
    if(empty($data[$cid]['files'][$fid])) return false;
    unset($data[$cid]['files'][$fid]);
    if(!(download_save_data_file($file, $data))) return false;
    return true;
}
?>