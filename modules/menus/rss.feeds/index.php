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
global $rss_cfg;
if(@$rss_cfg['enable']){
    $allowed = explode(' ', @$rss_cfg['bases']);
    $data = '';
    foreach ($allowed as $feed) {
        $name = (!empty($lang['rss']['feeds'][$feed])) ? $lang['rss']['feeds'][$feed] : $feed;
        $data .= '<a href="./index.php?rss=' . $feed . '"<img src="' . SKIN_PATH . 'rss.png" border="0"> ' . $name . '</a><br>';
    }
    if(!empty($data)) $system->showMenuWindow($lang['admincp']['general']['rss']['title'], $data);
}
?>