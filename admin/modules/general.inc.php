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
if($system->checkForRight('G-C'))  $modulesdata['general']['config'] = 'config';
if($system->checkForRight('G-RSS'))$modulesdata['general']['rss'] = 'general.rss';
if($system->checkForRight('G-C'))  $modulesdata['general']['navigation'] = 'general.nav';
if($system->checkForRight('G-M'))  $modulesdata['general']['menus'] = 'general.men';
if($system->checkForRight('G-MD')) $modulesdata['general']['modules'] = 'general.mod';
if($system->checkForRight('G-F'))  $modulesdata['general']['pages'] = 'general.pag';
if($system->checkForRight('G-F'))  $modulesdata['general']['ucm'] = 'general.ucm';
if($system->checkForRight('G-F'))  $modulesdata['general']['files'] = 'general.fls';
if($system->checkForRight('G-B'))  $modulesdata['general']['backup'] = 'general.bkp';
?>