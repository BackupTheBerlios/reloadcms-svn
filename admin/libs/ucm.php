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
function ucm_create($id, $title, $data, $align = 'left', $dir = MENU_MODULES_PATH) {
    $id = basename(trim($id));
    if(preg_replace("/[a-z0-9]*/i", '', $id) != '' || empty($id)) return 5;
    $workdir = $dir . 'ucm.' . $id . '/';
    if(!rcms_mkdir($workdir)) return 6;
    if(file_write_contents($workdir . 'index.php', "<?php show_window('" . $title . "', file_get_contents(\$module_dir . '/data.txt'), '$align'); ?>") && file_write_contents($workdir . 'data.txt', $data)){
        return 0;
    } else return 6;
}


function ucm_change($curid, $newid, $title, $data, $align = 'left', $dir = MENU_MODULES_PATH){
    $curid = basename($curid);
    $newid = basename($newid);
    if(is_file($dir . 'ucm.' . $curid. '/index.php')) {
        if(preg_replace("/[a-z0-9]*/i", '', $newid) != '' || empty($newid)) return 5;
        rcms_rename_file($dir . 'ucm.' . $curid, $dir . 'ucm.' . $newid);
        if(file_write_contents($dir . 'ucm.' . $newid . '/index.php', "<?php show_window('" . $title . "', file_get_contents(\$module_dir . '/data.txt'), '$align'); ?>") && file_write_contents($dir . 'ucm.' . $newid . '/data.txt', $data)){
            $config = file_get_contents(CONFIG_PATH . 'menus.ini');
            $config = str_replace('"ucm.' . $curid . '"', '"ucm.' . $newid . '"', $config);
            if(!file_write_contents(CONFIG_PATH . 'menus.ini', $config)) return 6;
            return 0;
        } else return 6;
    } else return 6;
}

function ucm_delete($id, $dir = MENU_MODULES_PATH) {
    $id = basename($id);
    $workdir = $dir . 'ucm.' . $id;
    if(is_dir($workdir)) {
        if(rcms_delete_files($workdir, true)) {
            $config = file_get_contents(CONFIG_PATH . 'menus.ini');
            $config = preg_replace('/[0-9]* = "ucm.' . $id . '"\s/i', '', $config);
            if(!file_write_contents(CONFIG_PATH . 'menus.ini', $config)) return 6;
            return 0;
        } else return 4;
    } else return 4;
}

function ucm_list($dir = MENU_MODULES_PATH){
    $dirs = rcms_scandir($dir, 'ucm.*');
    $return = array();
    foreach ($dirs as $mdir){
        preg_match_all("/\<\?php show_window\('(.*?)', (.*), '(.*?)'\); \?\>/ims", file_get_contents($dir . $mdir . '/index.php'), $matches, PREG_SET_ORDER);
        $return[substr($mdir,4)] = array($matches[0][1], file_get_contents($dir . $mdir . '/data.txt'), $matches[0][3]);
    }
    return $return;
}

function ucm_get($id, $dir = MENU_MODULES_PATH){
    $dirs = rcms_scandir($dir, 'ucm.*');
    $workdir = $dir . 'ucm.' . $id;
    $return = array();
    if(is_dir($workdir)) {
        preg_match_all("/\<\?php show_window\('(.*?)', (.*), '(.*?)'\); \?\>/ims", file_get_contents($workdir . '/index.php'), $matches, PREG_SET_ORDER);
        $return = array($matches[0][1], file_get_contents($workdir . '/data.txt'), $matches[0][3]);
    }
    return $return;
}
?>