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

/*********************************************************************************
* General definitions                                                            *
*********************************************************************************/
$lang['general']['filename'] = 'Filename';
$lang['general']['filesize'] = 'Size';
$lang['general']['filemtime'] = 'Last modified';
$lang['admincp']['general']['config']['welcome']  = 'Text of Welcome message';
$lang['admincp']['general']['config']['sitename'] = 'Title of your site';
$lang['admincp']['general']['config']['siteurl'] = 'URL of your site';
$lang['admincp']['general']['config']['leftcol'] = 'Left column width';
$lang['admincp']['general']['config']['rightcol'] = 'Right column width';
$lang['admincp']['general']['config']['defskin'] = 'Default skin';
$lang['admincp']['general']['config']['deflang'] = 'Default language';
$lang['admincp']['general']['config']['allowchskin'] = 'Allow users to select skin';
$lang['admincp']['general']['config']['allowchlang'] = 'Allow users to select language';
$lang['admincp']['general']['config']['meta'] = 'Additional meta tags for your site';
$lang['admincp']['general']['config']['top'] = 'This code will be shown in the top of page';
$lang['admincp']['general']['config']['copyright'] = 'This code will be shown under the copyright';
$lang['admincp']['general']['backup']['desc'] = 'To backup all your data from directories "config" and "content"
press "Create backup" button. Speed of backup creation depends on size of your site. To delete all your old backups mark
special checkbox.';
$lang['admincp']['general']['menus']['leftcol'] = 'Left column';
$lang['admincp']['general']['menus']['unused'] = 'Unused modules';
$lang['admincp']['general']['menus']['rightcol'] = 'Right column';
$lang['admincp']['general']['modules']['enabled'] = 'Enabled modules';
$lang['admincp']['general']['modules']['disabled'] = 'Disabled modules';
$lang['general']['pages']['pageid'] = 'Page ID';
$lang['general']['pages']['pageid_h'] = 'Only symbols allowed by file system. Please use only small latinic letters and digits.';
$lang['general']['pages']['pagelang'] = 'Page language';
$lang['general']['pages']['pagetitle'] = 'Page title';
$lang['general']['pages']['pagetext'] = 'Page text';
$lang['general']['pages']['pagetext_h'] = 'All HTML is allowed in this field and line breaks will not be transformed to &lt;br&gt; tags!';
$lang['general']['ucm']['id'] = 'Menu ID';
$lang['general']['ucm']['id_h'] = 'Only symbols allowed by file system. Please use only small latinic letters and digits.';
$lang['general']['ucm']['title'] = 'Menu title';
$lang['general']['ucm']['title_h'] = 'If you leave this field blank title part of window will not be shown';
$lang['general']['ucm']['text'] = 'Menu contents';
$lang['general']['ucm']['text_h'] = 'All HTML is allowed in this field and line breaks will not be transformed to &lt;br&gt; tags!';
$lang['general']['alignment'] = 'Text alignment';
$lang['general']['align']['center'] = 'Center';
$lang['general']['align']['left'] = 'Left';
$lang['general']['align']['right'] = 'Right';
$lang['general']['align']['justify'] = 'Justify';
$lang['general']['modules']['desc'] = 'Left panel is a list of enabled modules, right panel - of disabled. You can move elements by using buttons. Modules that use navigation marked with [M] and they will be in menu in the same order that is here.';
$lang['general']['menus']['desc'] = 'Here you can move menus from one panel to another and up/down in one panel. Menus listed in middle panel is disabled and will not be shown.';
$lang['general']['url'] = 'URL';
$lang['general']['title'] = 'Title';
$lang['general']['navigation_desc'] = 'If you want to remove link leave it\'s url empty. If you want to add new item fill in it\'s data to the last row.';
/*********************************************************************************
* Specific actions                                                               *
*********************************************************************************/
$lang['admincp']['general']['backup']['delold'] = 'Delete old backups';
$lang['admincp']['general']['backup']['doit'] = 'Create backup';
$lang['admincp']['general']['backup']['getit'] = 'Download this backup';
$lang['general']['selflstoupl'] = 'Select files to upload';
$lang['general']['deletefile'] = 'Delete file';
$lang['general']['createpage'] = 'Create page';
$lang['general']['createucm'] = 'Create menu';
/*********************************************************************************
* Messages                                                                       *
*********************************************************************************/
$lang['admincp']['general']['backup']['done'] = 'Backup Complete';
$lang['results']['general'][16] = 'No file uploaded';
$lang['results']['general'][15] = 'Error while uploading file';
$lang['results']['general'][14] = 'Error while deleting file';
$lang['results']['general'][13] = 'Module not found';
$lang['results']['general'][12] = 'This module is not enabled';
$lang['results']['general'][11] = 'Page ID or language is incorrect or empty';
$lang['results']['general'][10] = 'There is no page with this id';
$lang['results']['general'][9] = 'Cannot delete page';
$lang['results']['general'][8] = 'Cannot open page for editing';
$lang['results']['general'][7] = 'Cannot save changes to page';
$lang['results']['general'][6] = 'Cannot save changes to menu';
$lang['results']['general'][5] = 'Menu ID is incorrect or empty';
$lang['results']['general'][4] = 'Cannot delete menu';
$lang['results']['general'][3] = 'You have filled not all fields';
$lang['results']['general'][2] = 'Deleted successfully';
$lang['results']['general'][1] = 'Uploaded successfully';
$lang['results']['general'][0] = 'Operation successful';
$lang['general']['navigation_error'] = 'Cannot save data';
/*********************************************************************************
* Titles                                                                         *
*********************************************************************************/
$lang['general']['pagelang'] = 'Select language of page';
/*********************************************************************************
* Administration Titles                                                          *
*********************************************************************************/
$lang['admincp']['general']['title'] = 'General configuration';
$lang['admincp']['general']['config']['title'] = 'Configuration';
$lang['admincp']['general']['config']['full'] = 'Your site configuration';
$lang['admincp']['general']['backup']['title'] = 'Data backup';
$lang['admincp']['general']['backup']['full'] = 'Data backup CP';
$lang['admincp']['general']['files']['title'] = 'Uploaded files';
$lang['admincp']['general']['files']['full'] = 'Uploaded files';
$lang['admincp']['general']['files']['upload'] = 'Upload files';
$lang['admincp']['general']['menus']['title'] = 'Menus management';
$lang['admincp']['general']['modules']['title'] = 'Modules management';
$lang['admincp']['general']['pages']['title'] = 'Pages management';
$lang['admincp']['general']['pages']['edit'] = 'Page editing';
$lang['admincp']['general']['pages']['create'] = 'Page creation';
$lang['admincp']['general']['ucm']['title'] = 'User-Created menus';
$lang['admincp']['general']['ucm']['create'] = 'Menu creation';
$lang['admincp']['general']['ucm']['edit'] = 'Menu editing';
$lang['admincp']['general']['navigation']['title'] = 'Navigation panel';
/*********************************************************************************
* Administrative rights                                                          *
*********************************************************************************/
$rights_db['G-C'] = 'Right to edit site configuration';
$rights_db['G-B'] = 'Right to backup data';
$rights_db['G-F'] = 'Right to upload files';
$rights_db['G-M'] = 'Right to manage menus';
$rights_db['G-MD'] = 'Right to manage modules';
$rights_db['G-UCM'] = 'Right to manage user-created menus';
?>