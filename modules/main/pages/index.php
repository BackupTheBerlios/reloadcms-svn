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
if(!empty($_GET['id'])) {
    $langs = array_keys(page_get_langs($_GET['id']));
    if(empty($langs)) {
        $system->showModuleWindow('', $lang['results']['general'][11]);
    } elseif(!empty($_POST['page_lang']) && $page = page_get($_GET['id'], $_POST['page_lang'])) {
        $system->config['pagename'] = $page['title'];
        $system->showModuleWindow($page['title'], $page['text']);
    }
    elseif(count($langs) == 1 && $page = page_get($_GET['id'], $langs[0])) {
        $system->config['pagename'] = $page['title'];
        $system->showModuleWindow($page['title'], $page['text']);
    }
    else {
        $system->config['pagename'] = $lang['general']['pagelang'];
        $system->showModuleWindow($lang['general']['pagelang'], rcms_parse_module_template('pages-lang-sel.tpl', $langs));
    }
} else {
    $system->showModuleWindow('', $lang['results']['general'][11]);
}
?>
