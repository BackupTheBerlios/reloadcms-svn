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
$system->showMenuWindow('', '
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
id="musica" align="middle" height="150" width="150">
<param name="allowScriptAccess" value="sameDomain">
<param name="movie" value="./aclock.swf">
<param name="quality" value="high">
<param name="wmode" value="transparent">
<param name="bgcolor" value="#ffffff">
<embed src="./aclock.swf" quality="high" bgcolor="#ffffff" name="musica"
allowscriptaccess="sameDomain" type="application/x-shockwave-flash"
pluginspage="http://www.macromedia.com/go/getflashplayer" align="center" height="150" width="150">
</object>', 'center');
?>