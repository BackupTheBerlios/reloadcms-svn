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
if($system->checkForRight('N-CC')) $modulesdata['news']['createcat'] = 'articles.cat.add&work_dir=news';
if($system->checkForRight('N-MC')) $modulesdata['news']['managecat'] = 'articles.cat.man&work_dir=news';
if($system->checkForRight('N-A')) $modulesdata['news']['create'] = 'articles.add&work_dir=news';
if($system->checkForRight('N-MA')) $modulesdata['news']['manage'] = 'articles.man&work_dir=news';
?>