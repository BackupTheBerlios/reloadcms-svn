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
if(!empty($_POST['cleanstats'])) statistic_clean();

if($stats = statistic_get()){
    $frm =new InputForm ("", "post", $lang['counter']['clean']);
    $frm->addrow($lang['counter']['hitsall'], $stats['totalhits']);
    $frm->addrow($lang['counter']['hits'], $stats['todayhits']);
    $frm->addrow($lang['counter']['hosts'], count($stats['todayhosts']));
    $frm->addbreak($lang['counter']['agents']);
    arsort($stats['ua']);
    foreach ($stats['ua'] as $agent => $count) $frm->addrow($agent, $count);
    $frm->addbreak($lang['counter']['pages']);
    arsort($stats['popular']);
    array_splice($stats['popular'], 20);
    foreach ($stats['popular'] as $page => $count) $frm->addrow($page, $count);
    $frm->addbreak($lang['counter']['users']);
    arsort($stats['todayhosts']);
    foreach ($stats['todayhosts'] as $ip => $count) $frm->addrow($ip);
    $frm->hidden('cleanstats', '1');
    $frm->show();
} 

?>