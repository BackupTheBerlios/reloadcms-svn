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
$files = array();
foreach ($filesdb as $cid => $cdata) foreach ($cdata['files'] as $fid => $fdata) $files[$cid . '.' . $fid] = $fdata['date'];
natsort($files);
$files = array_reverse($files);
$files = array_slice($files, 0, 10);
$result = '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
$i=2;
if(!empty($files)){
    foreach($files as $id => $date) {
        list($cid, $fid) = explode('.', $id);
        $result .= '<tr><td class="row' . $i . '"><a href="index.php?module=filesdb&id=' . $cid . '&fid=' . $fid . '">' . $filesdb[$cid]['name'] . ' -&gt; ' . $filesdb[$cid]['files'][$fid]['name'] . '</a></td></tr>';
        $i++;
        if($i>3) $i=2;
    }
}
$result .= '</table>';
$system->showMenuWindow($lang['files']['last'], $result, 'center');
?>
