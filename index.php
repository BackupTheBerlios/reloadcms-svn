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

////////////////////////////////////////////////////////////////////////////////
// Initializations                                                            //
////////////////////////////////////////////////////////////////////////////////
define('RCMS_ROOT_PATH', './');
require_once(RCMS_ROOT_PATH . 'common.php');
$rss_cfg = @parse_ini_file(CONFIG_PATH . 'rss.ini');

if(empty($_GET['rss']) || !@$rss_cfg['enable']){
////////////////////////////////////////////////////////////////////////////////
// General index                                                              //
////////////////////////////////////////////////////////////////////////////////
    if(!empty($_GET['module'])) $module = basename($_GET['module']); else $module = 'main';
    // Send main headers
    header('Last-Modified: ' . gmdate('r')); 
    header('Content-Type: text/html; charset=' . $lang['options']['encoding']);
    header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
    header("Pragma: no-cache");
    // Check if selected module is disabled
    $system->setCurrentPoint('__MAIN__');
    if(in_array($module, parse_ini_file(CONFIG_PATH . 'modules.ini'))) include_once(MODULES_PATH . $module . '/index.php');
    else $system->showModuleWindow('', $lang['results']['general'][12], 'center');
    // Load menu modules
    $menu_points = @parse_ini_file(CONFIG_PATH . 'menus.ini', true);
    include_once(CUR_SKIN_PATH . 'skin.php');
    if(!empty($menu_points)){
        foreach($menu_points as $point => $menus){
            $system->setCurrentPoint($point);
            if(!empty($menus) && isset($skin['menu_point'][$point])){
                foreach ($menus as $menu){
                    if(is_dir(MENU_MODULES_PATH . $menu) && file_exists(MENU_MODULES_PATH . $menu . '/index.php')){
                        $module = $menu;
                        $module_dir = MENU_MODULES_PATH . $menu;
                        require(MENU_MODULES_PATH . $menu . '/index.php');
                    } else {
                        $system->showMenuWindow('', $lang['results']['general'][13], 'center');
                    }
                }
            }
        }
    }
    // Start output
    require_once(CUR_SKIN_PATH . 'skin.general.php');
} else {
////////////////////////////////////////////////////////////////////////////////
// RSS Feed                                                                   //
////////////////////////////////////////////////////////////////////////////////
    $dir = $_GET['rss'];
    $allowed = explode(' ', $rss_cfg['bases']);
    if(in_array($dir, $allowed)){
        if(is_dir(DATA_PATH . $dir) && is_file(DATA_PATH . $dir . '/0.last')){
            header('Content-Type: text/xml');
            echo "<?xml version=\"1.0\" encoding=\"" . $lang['options']['encoding'] . "\" ?>\r\n";
?>
<rss version="2.0">
    <channel>
        <title><?=$system->config['title']?> - <?=@$lang['rss']['feeds'][$dir]?></title>
        <link><?=$system->config['site_url']?></link>
        <description><?=@$rss_cfg['description']?></description>
        <language><?=@$rss_cfg['language']?></language>
        <copyright><?=@$rss_cfg['copyright']?></copyright>
        <lastBuildDate><?=date('r')?></lastBuildDate>
        <generator><?=$lang['copyright']['powered'] . ' ' . RCMS_VERSION_BRANCH . '.'  . RCMS_VERSION_SECOND . '-' . RCMS_VERSION_SUFFIX?></generator>
        <ttl>40</ttl>
<?php
$articles = articles_parse_list(1, true, DATA_PATH . $dir . '/');
$result = '';
if(!empty($articles)){
    foreach($articles as $article) {
        if(!empty($article)){?>
        <item>
            <title><?=htmlspecialchars($article['title'])?></title>
            <description><?=htmlspecialchars($article['desc'])?></description>
            <link><?=$system->config['site_url'] . '/index.php?module=articles&amp;catid=' . $article['catid'] . '&amp;id=' . $article['id'] . '&amp;work_dir=news'?></link>
            <pubDate><?=date('r', $article['time'])?></pubDate>
        </item><?php
        }
    }
}
?>
    </channel>
</rss>
<?php
        }
    }
}
?>