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

function statistic_register(){
    global $system;
    if(is_file(DATA_PATH . 'stats.dat')) {
        $stats = @file(DATA_PATH . 'stats.dat');
        $stats = @unserialize($stats[0]);
    }
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $userip    = $_SERVER['REMOTE_ADDR'];
    //$referer   = $_SERVER['HTTP_REFERER'];
    $page      = $_SERVER['REQUEST_URI'];
    
    // Add popularity to browser
    if(!empty($stats['ua'][$useragent])) $stats['ua'][$useragent]++; else $stats['ua'][$useragent] = 1;
    // Add popularity to page
    if(!empty($stats['popular'][$page])) $stats['popular'][$page]++; else $stats['popular'][$page] = 1;
    // Register last user's visit time
    $stats['ips'][$userip] = time();
    // Register user in total hits count
    if(!empty($stats['totalhits'])) $stats['totalhits']++; else $stats['totalhits'] = 1;
    // Check the last update time
    if(!empty($stats['update']) && $stats['update'] < mktime(0, 0, 0, date('n'), date('j'), date('Y'))) {
        unset($stats['todayhits']);    // Remove yestarday's hits
        unset($stats['todayhosts']);    // Remove yestarday's hosts
    }
    if(!empty($stats['todayhits'])) $stats['todayhits']++; else $stats['todayhits'] = 1;
    if(empty($stats['todayhosts'][$userip])) $stats['todayhosts'][$userip] = true;
    // Online users
    if($system->user['username'] != 'guest'){
        $stats['online'][$system->user['username']]['nick'] = $system->user['nickname'];
        $stats['online'][$system->user['username']]['time'] = rcms_get_time();
    }
    $online = array();
    if(!empty($stats['online'])){
        foreach ($stats['online'] as $name => $data) if($data['time'] > rcms_get_time() - 15*60) $online[$name] = $data;
        $stats['online'] = $online;
    }
    
    // Update time's update
    $stats['update'] = time();
    
    @file_write_contents(DATA_PATH . 'stats.dat', serialize($stats));
    return true;    
}

function statistic_get(){
    if(is_file(DATA_PATH . 'stats.dat')) {
        $stats = @file(DATA_PATH . 'stats.dat');
        $stats = @unserialize($stats[0]);
        return $stats;
    } else return false;
}

function statistic_clean(){
    return rcms_delete_files(DATA_PATH . 'stats.dat');
}
?>