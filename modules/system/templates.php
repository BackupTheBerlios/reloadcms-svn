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

function show_window($title, $data, $align = 'left'){
    global $system;
    $system->showMenuWindow($title, $data, $align);
}

function show_error($data){show_window('', $data, 'center');}

function user_tz_select($default = 0, $select_name = 'timezone') {
	global $lang;

	$tz_select = '<select name="' . $select_name . '">';
	while(list($offset, $zone) = @each($lang['tz'])) {
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$tz_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$tz_select .= '</select>';

	return $tz_select;
}

function user_skin_select($dir, $select_name, $default = '') {
    $skins = rcms_scandir($dir);
    $frm = '<select name="' . $select_name . '" style="width: 100px;">';
    foreach ($skins as $skin){
        if(is_dir($dir . $skin) && is_file($dir . $skin . '/skin_name.txt')){
            $name = file_get_contents($dir . $skin . '/skin_name.txt');
            $frm .= '<option value="' . $skin . '"' . (($default == $skin) ? ' SELECTED>' : '>') . $name . '</option>';
        }
    }
    $frm .= '</select>';
    return $frm;
}

function user_lang_select($dir, $select_name, $default = '') {
    $langs = rcms_scandir($dir);
	$frm = '<select name="' . $select_name . '" style="width: 100px;">';
    foreach ($langs as $lang){
        if(is_dir($dir . $lang) && is_file($dir . $lang . '/langid.txt')){
            $name = file_get_contents($dir . $lang . '/langid.txt');
            $frm .= '<option value="' . $lang . '"' . (($default == $lang) ? ' SELECTED>' : '>') . $name . '</option>';
        }
    }
    $frm .= '</select>';
	return $frm;
}

function rcms_pagination($total, $perpage, $current, $link){
    $return = '';
    if(!empty($perpage)) {
        $pages = ceil($total/$perpage);
        if($pages != 1){
            $c = 1;
            while($c <= $pages){
                if($c != $current) $return .= ' [' . '<a href="' . $link . '&page=' . $c . '">' . $c . '</a>] ';
                else $return .= ' [' . $c . '] ';
                $c++;
            }
        }
    }
    return $return;
}

function rcms_parse_menu($format) {
    global $lang;
    $modules_dir = rcms_scandir(MODULES_PATH);
    $enabled = parse_ini_file(CONFIG_PATH . 'modules.ini');
    $additional = parse_ini_file(CONFIG_PATH . 'navigation.ini', true);
    $result = '';
    $MODULES = array();
    foreach ($enabled as $module) if(file_exists(MODULES_PATH . $module . '/module.php')) include(MODULES_PATH . $module . '/module.php');
    foreach ($MODULES as $module) $result .= str_replace('{link}', '?module=' . $module['id'], str_replace('{title}', $module['name'], $format));
    foreach ($additional as $link) $result .= str_replace('{link}', @$link['url'], str_replace('{title}', @$link['name'], $format));
    return $result;
}

function rcms_parse_module_template($module, $tpldata) {
    global $lang, $system;
    ob_start();
    if(is_file(CUR_SKIN_PATH . $module . '.php')) include(CUR_SKIN_PATH . $module . '.php');
    elseif(is_file(MODULES_TPL_PATH . $module . '.php')) include(MODULES_TPL_PATH . $module . '.php');
    $return = ob_get_contents();
    ob_end_clean();
    return $return;
}

function rcms_show_element($element, $parameters = ''){
    global $lang, $REDIRECTION, $TEMPLATE, $system;
    switch($element){
        case 'title':
            echo $system->config['title'] . ((!empty($system->config['pagename'])) ? ' - ' . $system->config['pagename'] : '');
            break;
        case 'menu_point':
            list($point, $template) = explode('@', $parameters);
            if(!empty($system->output['menus'][$point])){
                foreach($system->output['menus'][$point] as $module){
                    $system->showWindow($module[0], $module[1], $module[2], CUR_SKIN_PATH . 'skin.' . $template . '.php');
                }
            }
            break;
        case 'main_point':
            foreach ($system->output['modules'] as $module) {
                $system->showWindow($module[0], $module[1], $module[2], CUR_SKIN_PATH . 'skin.' . substr(strstr($parameters, '@'), 1) . '.php');
            }
            break;
        case 'navigation':
            echo rcms_parse_menu($parameters);
            break;
        case 'meta':
            readfile(DATA_PATH . 'meta_tags.html');
            echo '<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['options']['encoding'] . '" />' . "\r\n";
            global $rss_cfg;
            if(@$rss_cfg['enable']){
                $allowed = explode(' ', @$rss_cfg['bases']);
                foreach ($allowed as $feed) {
                    $name = (!empty($lang['rss']['feeds'][$feed])) ? $lang['rss']['feeds'][$feed] : $feed;
                    echo '<link rel="alternate" type="application/xml" title="RSS ' . $name . '" href="./index.php?rss=' . $feed . '" />' . "\r\n";
                }
            }
            if(!empty($system->config['meta'])) echo $system->config['meta'];
            break;
        case 'header': readfile(DATA_PATH . 'top.html'); break;
        case 'copyright':
            if(!defined('RCMS_COPYRIGHT_SHOWED') || !RCMS_COPYRIGHT_SHOWED){
                echo '<a href="http://sourceforge.net/projects/reloadcms">' . $lang['copyright']['powered'] . '</a> ' . RCMS_VERSION_BRANCH . '.'  . RCMS_VERSION_SECOND . '-' . RCMS_VERSION_SUFFIX . '@' . RCMS_VERSION_REVIS . '<br>&copy; 2004-2005 ReloadCMS Team';
            }
            break;
    }
}
?>