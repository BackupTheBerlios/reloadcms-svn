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
global $system;
$pages = page_get_list($dir = PAGES_PATH);
foreach ($pages as $id => $names){
    if(!empty($names[$system->language])) $title = $names[$system->language];
    elseif(!empty($names[$system->config['default_lang']])) $title = $names[$system->config['default_lang']];
    else $title = $names[key($names)];
    $MODULES[] = array(
        'id' => $module . '&id=' . $id,
        'name' => $title
    );
}
?>