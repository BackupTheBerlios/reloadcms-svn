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
if($system->checkForRight('A-CC')) $modulesdata['articles']['createcat'] = 'articles.cat.add';
if($system->checkForRight('A-MC')) $modulesdata['articles']['managecat'] = 'articles.cat.man';
if($system->checkForRight('A-A')) $modulesdata['articles']['create'] = 'articles.add';
if($system->checkForRight('A-MA')) $modulesdata['articles']['manage'] = 'articles.man';
?>