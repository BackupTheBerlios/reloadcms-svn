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

function page_get_langs($name, $dir = PAGES_PATH){
    $name = basename($name);
    $pages = rcms_scandir($dir, '*.' . $name .'.html');
    $result = array();
    foreach ($pages as $page) {
        $pagearray = explode('.', $page);
        $result[$pagearray[0]] = @file_get_contents($dir . str_replace('.html', '.txt', $page));
    }
    return $result;
}

function page_get($name, $slang, $dir = PAGES_PATH){
    $name = basename($name);
    $slang = basename($slang);
    if(file_exists($dir . $slang . '.' . $name . '.html')) {
        $result['title'] = @file_get_contents($dir . $slang . '.' . $name . '.txt');
        $result['text'] = @file_get_contents($dir . $slang . '.' . $name . '.html');
        if($result['title'] === false || $result['text'] === false) return false;
        return $result;
    } else return false;
}

function page_create($name, $lang, $title, $text, $dir = PAGES_PATH){
    $name = trim(basename($name));
    $lang = basename($lang);
    if(is_file($dir . $lang . '.' . $name . '.txt') || is_file($dir . $lang . '.' . $name . '.html')) return 7;
    $title = strip_tags($title);
    if(preg_replace("/[a-z0-9]*/i", '', $name) != '' || empty($name)) return 11;
    if(preg_replace("/[a-z0-9]*/i", '', $lang) != '' || empty($lang)) return 11;
    if(empty($title)) return 3;
    if(empty($text)) return 3;
    if(!file_write_contents($dir . $lang . '.' . $name . '.txt', $title)) return 7;
    if(!file_write_contents($dir . $lang . '.' . $name . '.html', $text)) return 7;
    return 0;
}

function page_change($curname, $curlang, $newname, $newlang, $title, $text, $dir = PAGES_PATH){
    $curname = basename($curname);
    $curlang = basename($curlang);
    $newname = basename($newname);
    $newlang = basename($newlang);
    if(empty($title)) return 3;
    if(empty($text)) return 3;
    if(file_exists($dir . $curlang . '.' . $curname . '.html')) {
        if(preg_replace("/[a-z0-9]*/i", '', $newname) != '' || empty($newname)) return 11;
        if(preg_replace("/[a-z0-9]*/i", '', $newlang) != '' || empty($newlang)) return 11;
        rcms_rename_file($dir . $curlang . '.' . $curname . '.html', $dir . $newlang . '.' . $newname . '.html');
        rcms_rename_file($dir . $curlang . '.' . $curname . '.txt', $dir . $newlang . '.' . $newname . '.txt');
        $title = strip_tags($title);
        if(!file_write_contents($dir . $newlang . '.' . $newname . '.txt', $title)) return 7;
        if(!file_write_contents($dir . $newlang . '.' . $newname . '.html', $text)) return 7;
        return 0;
    } else return 7;
}

function page_delete($name, $slang, $dir = PAGES_PATH){
    $name = basename($name);
    $slang = basename($slang);
    if(file_exists($dir . $slang . '.' . $name . '.html')) {
        rcms_delete_files($dir . $slang . '.' . $name . '.txt');
        rcms_delete_files($dir . $slang . '.' . $name . '.html');
        return true;
    } else return false;
}

function page_get_list($dir = PAGES_PATH){
    $pages = rcms_scandir($dir, '*.html');
    $result = array();
    foreach ($pages as $page) {
        $pagearray = explode('.', $page);
        $result[$pagearray[1]][$pagearray[0]] = @file_get_contents($dir . str_replace('.html', '.txt', $page));
    }
    return $result;
}
?>