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

// Unset any globals created by register_globals being turned ON
while (list($global) = each($GLOBALS)){
	if (!preg_match('/^(_POST|_GET|_COOKIE|_SERVER|_FILES|GLOBALS|HTTP.*|_REQUEST)$/', $global)){
		unset($$global);
	}
}
unset($global);


////////////////////////////////////////////////////////////////////////////////
// Defining constants                                                         //
////////////////////////////////////////////////////////////////////////////////
define('RCMS_VERSION_BRANCH', '1');
define('RCMS_VERSION_SECOND', '0');
define('RCMS_VERSION_SUFFIX', 'final');
define('RCMS_VERSION_REPOS', 'reloadcms_stable');
define('RCMS_VERSION_REVIS', '111');

// Main paths
define('SYSTEM_MODULES_PATH',RCMS_ROOT_PATH . 'modules/system/');
define('ENGINE_PATH',        RCMS_ROOT_PATH . 'modules/engine/');
define('MENU_MODULES_PATH',  RCMS_ROOT_PATH . 'modules/menus/');
define('MODULES_TPL_PATH',   RCMS_ROOT_PATH . 'modules/templates/');
define('MODULES_PATH',       RCMS_ROOT_PATH . 'modules/main/');
define('FUNCTIONS_PATH',     RCMS_ROOT_PATH . 'functions/');
define('CONFIG_PATH',        RCMS_ROOT_PATH . 'config/');
define('LANG_PATH',          RCMS_ROOT_PATH . 'languages/');
define('ADMIN_PATH',         RCMS_ROOT_PATH . 'admin/');
define('ADMIN_LIBS_PATH',    RCMS_ROOT_PATH . 'admin/libs/');
define('SKIN_PATH',          RCMS_ROOT_PATH . 'skins/');
define('BACKUP_PATH',        RCMS_ROOT_PATH . 'backups/');

// Content paths
define('DATA_PATH',     RCMS_ROOT_PATH . 'content/');
define('USERS_PATH',    DATA_PATH . 'users/');
define('ARTICLES_PATH', DATA_PATH . 'articles/');
define('MINICHAT_PATH', DATA_PATH . 'minichat/');
define('NEWS_PATH',     DATA_PATH . 'news/');
define('FILES_PATH',    DATA_PATH . 'uploads/');
define('PAGES_PATH',    DATA_PATH . 'pages/');
define('GALLERY_PATH',  DATA_PATH . 'gallery/');
define('FORUM_PATH',    DATA_PATH . 'forum/');

// Cookies
define('FOREVER_COOKIE', time()+3600*24*365*5);

////////////////////////////////////////////////////////////////////////////////
// Loading modules                                                            //
////////////////////////////////////////////////////////////////////////////////
include_once(SYSTEM_MODULES_PATH . 'load.php');

////////////////////////////////////////////////////////////////////////////////
// magic_quotes_gpc fix                                                       //
////////////////////////////////////////////////////////////////////////////////
if(ini_get('magic_quotes_gpc')){
    stripslash_array($_POST);
    stripslash_array($_GET);
    stripslash_array($_COOKIE);
}

////////////////////////////////////////////////////////////////////////////////
// Loading modules                                                            //
////////////////////////////////////////////////////////////////////////////////
$em_dir = opendir(ENGINE_PATH);
while ($em = readdir($em_dir)){
	if(substr($em, 0, 1) != '.' && is_file(ENGINE_PATH . $em)){
		include_once(ENGINE_PATH . $em);
	}
}
closedir($em_dir);


?>
