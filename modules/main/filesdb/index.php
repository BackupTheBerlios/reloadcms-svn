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
$filesdb = download_get_data_file(DATA_PATH . 'downloads.dat');
if(!empty($_GET['id']) && !empty($filesdb[((int)$_GET['id']) - 1]) && !empty($_GET['fid']) && !empty($filesdb[((int)$_GET['id']) - 1]['files'][((int)$_GET['fid']) - 1])) {
    $cid = ((int)$_GET['id']) - 1;
    $fid = ((int)$_GET['fid']) - 1;
    $system->config['pagename'] = $filesdb[$cid]['files'][$fid]['name'];
    $result = '';
    if(!empty($filesdb[$cid]['files'][$fid])){
        $result .= rcms_parse_module_template('fdb-file.tpl', $filesdb[$cid]['files'][$fid]);
    }
    $system->showModuleWindow('', $result, 'center');
} elseif(!empty($_GET['id']) && !empty($filesdb[((int)$_GET['id']) - 1])) {
    $cid = ((int)$_GET['id']) - 1;
    $system->config['pagename'] = $filesdb[$cid]['name'];
    $result = '';
    if(!empty($filesdb[$cid]['files'])){
        foreach ($filesdb[$cid]['files'] as $fid => $fdata){
            $result .= rcms_parse_module_template('fdb-file.tpl', $fdata);
        }
    }
    $system->showModuleWindow('<a href="./index.php?module=' . $module .  '">' . $lang['files']['categories'] . '</a> -&gt; ' . $filesdb[$cid]['name'], $result, 'center');
} else {
    $system->config['pagename'] = $lang['files']['categories'];
    if(!empty($filesdb)){
        $result = '';
        foreach ($filesdb as $cid => $cdata){
            $result .= rcms_parse_module_template('fdb-cat.tpl', $cdata + array('link' => './index.php?module=' . $module . '&id=' . ($cid + 1)));
        }
        $system->showModuleWindow($lang['files']['categories'], $result, 'center');
    } else $system->showModuleWindow('', $lang['files']['nocats']);
}
?>
