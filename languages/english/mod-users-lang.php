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
$lang['users']['username'] = 'Login';
$lang['users']['password'] = 'Password';
$lang['users']['passwordconfirm'] = 'Confirm password';
$lang['users']['nickname'] = 'Nickname';
$lang['users']['email'] = 'E-mail';
$lang['users']['hideemail'] = 'Hide your e-mail address';
$lang['users']['emailhidden'] = 'User\'s e-mail address is hidden';
$lang['users']['timezone'] = 'Time zone';
$lang['users']['guest'] = 'Guest';
$lang['users']['fieldid'] = 'Field ID';
$lang['users']['fieldname'] = 'Field title';
$lang['users']['fielddesc'] = 'If you want to remove field leave it\'s id and name empty. If you want to add new item write it\'s data to the last fields.';
$lang['users']['reglogin'] = 'Enter <abbr title="Must contain only Latin letters and/or digits">login</abbr> that you will use to enter the site';
$lang['users']['regnick'] = 'Your nickname (Will be shown to other users)';
$lang['users']['regemail'] = 'Your e-mail (Must be valid. Only technical information will be sent)';
$lang['users']['updpassword'] = 'Password (Leave blank if you want to keep old)';
$lang['users']['usersearch'] = 'Enter username to search for (you also can use * as wildcard).';
$lang['users']['block'] = 'Block';
$lang['users']['unblock'] = 'Unblock';
$lang['users']['editrights'] = 'Edit rights';
$lang['users']['rootuser'] = 'Check if this is a "root" user (user that have all rights including unlisted)';
/*********************************************************************************
* General actions                                                                *
*********************************************************************************/
$lang['users']['remember'] = 'Remember me';
$lang['users']['register'] = 'Registration';
$lang['users']['login'] = 'Log in';
$lang['users']['logout'] = 'Log out';
$lang['users']['myprofile'] = 'My profile';
/*********************************************************************************
* Specific actions                                                               *
*********************************************************************************/
/*********************************************************************************
* Titles                                                                         *
*********************************************************************************/
$lang['users']['hello'] = 'Hello, ';
$lang['users']['registration'] = 'Registration';
$lang['users']['profileupdate'] = 'Profile update';
$lang['users']['registeredusers'] = 'Registered users';
$lang['pages']['userlist'] = 'User list';
/*********************************************************************************
* Administration Titles                                                          *
*********************************************************************************/
$lang['admincp']['users']['title'] = 'User admin';
$lang['admincp']['users']['fields']['title'] = 'Profile fields';
$lang['admincp']['users']['fields']['full'] = 'Select addition profile fields';
$lang['admincp']['users']['profiles']['title'] = 'Users management';
$lang['admincp']['users']['profiles']['searchresult'] = 'Search result';
$lang['admincp']['users']['profiles']['searchresult_h'] = 'To keep your users\' database solid please do not delete users\' accounts. It is better if you just block them.';
$lang['admincp']['users']['profiles']['edit'] = 'Account editing: ';
/*********************************************************************************
* Messages                                                                       *
*********************************************************************************/
$lang['results']['users'][16] = 'There are no user with this name';
$lang['results']['users'][15] = 'Not logged in';
$lang['results']['users'][14] = 'Illegal username';
$lang['results']['users'][13] = 'Invalid password';
$lang['results']['users'][12] = 'Password doesn\'t match it\'s confirmation';
$lang['results']['users'][11] = 'Invalid email address';
$lang['results']['users'][10] = 'Cannot create/modify file';
$lang['results']['users'][9] = 'Number of IDs is not equal to number of names';
$lang['results']['users'][8] = 'Cannot write ini file';
$lang['results']['users'][7] = 'Your account has been blocked by administrator';
$lang['results']['users'][6] = 'User with login already exists';
$lang['results']['users'][5] = 'Cannot delete account';
$lang['results']['users'][2] = 'Profile has been updated successful.';
$lang['results']['users'][1] = 'You have registered successful. Now you can log in to site.';
$lang['results']['users'][0] = 'Operation successful';
/*********************************************************************************
* Administrative rights                                                          *
*********************************************************************************/
$rights_db['U-F'] = 'Right to manage additional profile fields';
$rights_db['U-P'] = 'Right to manage profiles';
/*********************************************************************************
* Added after .60                                                                *
*********************************************************************************/
$lang['users']['forgotpas'] = 'Forgot password?';
$lang['users']['sendnew'] = 'Send new password';
$lang['users']['pasreqsender'] = 'ReloadCMS - Password request';
$lang['users']['pasreqsubj'] = 'Password generation request';
$lang['users']['pasreqtext'] = 'Here is your new password: ';
$lang['results']['users'][3] = 'New password was sent to your mailbox';
$lang['admincp']['general']['config']['regconfirmation'] = 'Account activation by mail';
$lang['results']['users'][19] = 'Account has been activated.';
$lang['results']['users'][18] = 'Cannot activate account. It can be deleted because you exceed three days limit or you open this page by broken link.';
$lang['results']['users'][17] = 'You have registered here, but you was not activate your account. Information about how to activate account was sent for you by e-mail after registration.';
$lang['results']['users'][4] = 'You have registered here, but you must activate your account. Information about how to activate account is sent for you by e-mail.';
$lang['users']['actreqsender'] = 'ReloadCMS - Account activation';
$lang['users']['actreqsubj'] = 'Account activation';
$lang['users']['actreqtext'] = 'To activate your account follow this link: ';
?>