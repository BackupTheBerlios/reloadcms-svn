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

//------------------------------------------------//
// File uploads API: Uploading array of files     //
//------------------------------------------------//
// 16 - No file uploaded                          //
// 15 - Error while uploading file                //
// 1  - Successfull                               //
////////////////////////////////////////////////////
function fupload_array($files, $dir = FILES_PATH){
    if(!empty($files)){
        $total = count($files['name']);
        for ($i = 0; $i<$total; $i++){
            if(!$files['error'][$i]){
                if(!move_uploaded_file($files['tmp_name'][$i], $dir . $files['name'][$i])) return 15;
            }
        }
        return 1;
    } else return 16;
}

function fupload_get_list($dir = FILES_PATH){
    $sd = rcms_scandir($dir);
    $i = 0;
    $return = array();
    foreach ($sd as $file){
        $return[$i]['name'] = $file;
        $return[$i]['size'] = filesize(FILES_PATH . $file);
        $return[$i]['mtime'] = filemtime(FILES_PATH . $file);
        $i++;
    }
    return $return;
}

//------------------------------------------------//
// File uploads API: Deleting file                //
//------------------------------------------------//
// 14 - Error while deleting file                 //
// 2  - Successfull                               //
////////////////////////////////////////////////////
function fupload_delete($file, $dir = FILES_PATH){
    if(is_file($dir . $file)) { rcms_delete_files($dir . $file); return 2;} else return 14;
}
?>