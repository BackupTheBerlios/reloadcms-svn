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
define('RCMS_ROOT_PATH', '../');

include(RCMS_ROOT_PATH . 'common.php');
include(ADMIN_PATH . 'formsgen.php');

function rcms_loadAdminLib($lib){require_once(ADMIN_LIBS_PATH . $lib . '.php');}

//------------------------------------------------------------------------------------------------------//
// preparations...

if(!empty($_GET['show'])) $show = $_GET['show']; else $show = '';

$moddir = opendir('./modules');
while($modfile = readdir($moddir)) if(is_file('./modules/' . $modfile)) $modulesdir[] = $modfile;
$modules     = preg_grep ("/[\s\S]+.inc.php/", $modulesdir);
$modulesdata = array();
foreach($modules as $module) include('./modules/'.$module);

switch($show){
	case 'nav':
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lang['options']['encoding']?>">
<link rel="stylesheet" href="./style.css" type="text/css">
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="100%">
		<table width="100%" cellpadding="4" cellspacing="1" border="0">
		<tr>
			<th class="menu" height="25">&#0187; <?=$lang['admincp']['Return']['title']?></th>
		</tr>
		<tr>
			<td class="row1"><a class="genmed" href="../" target="_top"><?=$lang['admincp']['Return']['Index']['title']?></a></td>
		</tr>
		<tr>
			<td class="row1"><a class="genmed" href="./index.php?show=module" target="main"><?=$lang['admincp']['Return']['AdminIndex']['title']?></a></td>
		</tr>
<?php foreach($modulesdata as $block=>$modules) { ?>
		<tr>
			<th class="menu" height="25">&#0187; <?php if(isset($lang['admincp'][$block]['title'])) echo $lang['admincp'][$block]['title']; else echo $block; ?></th>
		</tr>
<?php foreach($modules as $module=>$id) { ?>
		<tr>
			<td class="row1"><a class="genmed" href="./index.php?show=module&id=<?=$id?>" target="main"><?php if(isset($lang['admincp'][$block][$module]['title'])) echo $lang['admincp'][$block][$module]['title']; else echo $module;?></a></td>
		</tr>
<?php } ?>
<?php } ?>
		</table>
	</td>
</tr>
</table>
</body>
</html>
<?php
	break;
	case 'module':
echo'	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['options']['encoding'] . '">
<link rel="stylesheet" href="./style.css" type="text/css">
</head>
<body>
';
	if(!isset($_GET['id'])) $_GET['id'] = 'index';
	else {
		$tmp = explode('/', $_GET['id']);
		$_GET['id'] = $tmp[count($tmp)-1];
		$tmp = explode('\\', $_GET['id']);
		$_GET['id'] = $tmp[count($tmp)-1];
	}
	$module = $_GET['id'];
	if(!is_file('./modules/' . $module . '.php')) die($lang['admincp']['module-not-found'] . $module . '.');
	else {
	    $secure = false;
	    foreach ($modulesdata as $modulesdata) if(in_array($module, $modulesdata)) $secure = true;
	    if($module == 'index') $secure = true;
	    if($secure) define('SECURE', true); else die($lang['admincp']['hacking-attempt']);
	    include('./modules/' . $module . '.php');
	}
echo'
</body>
</html>
';
	break;
	default:
echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['options']['encoding'] . '">
<title>'.$lang['admincp']['title'].'</title>
</head>
<frameset cols="190, *" border="0" framespacing="0" frameborder="NO">
	<frame src="./index.php?show=nav" name="nav" marginwidth="3" marginheight="3" scrolling="yes">
	<frame src="./index.php?show=module" name="main" marginwidth="0" marginheight="0" scrolling="auto">
</frameset>
<noframes>
	<body bgcolor="white" text="#000000">
		<p>Sorry, but your browser does not support frames</p>
	</body>
</noframes>
</html>
';
}
?>