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

function poll_create($quest, $variants){
    if(poll_is_running()) return 16;
    if(empty($quest) || empty($variants)) return 14;
    $data['q'] = $quest;
    $data['v'] = explode("\n", preg_replace("/[\n\r]+/", "\n", $variants));
    foreach ($data['v'] as $v_id => $v_total){
        $data['c'][$v_id] = 0;
    }
    $data = serialize($data);
    if(!file_write_contents(DATA_PATH . 'poll.dat', $data)) return 15;
    return 0;
}

function poll_get(){
    if(!poll_is_running()) return false;
    if(!is_file(DATA_PATH . 'poll.dat')) return false;
    if(!($file = @unserialize(@file_get_contents(DATA_PATH . 'poll.dat')))) return false;
    $file['t'] = 0;
    foreach ($file['c'] as $v_id => $v_total){
        $file['t'] += $v_total;
    }
    foreach ($file['c'] as $v_id => $v_total){
        if($file['t'] != 0) $file['p'][$v_id] = round(($v_total/$file['t'])*100); else $file['p'][$v_id] = 0;
    }
    return $file;
}

function poll_vote($var, $ip){
    if(!poll_is_running()) return 13;
    if(!is_file(DATA_PATH . 'poll.dat')) return 12;
    if(!($file = @unserialize(@file_get_contents(DATA_PATH . 'poll.dat')))) return 12;
    if(isset($file['c'][$var])) {
        $file['c'][$var]++;
        if(@is_array($file['ips']) && in_array($ip, $file['ips']) || @$_COOKIE['reloadcms_poll'] == $file['q']) return 11;
        $file['ips'][] = $ip;
        if(!file_write_contents(DATA_PATH . 'poll.dat', serialize($file))) return 15;
    }
    setcookie('reloadcms_poll', $file['q'], FOREVER_COOKIE);
    return 0;
}

function poll_is_running(){
    if(!is_file(DATA_PATH . 'poll.dat')) return false;
    if(!($file = @unserialize(@file_get_contents(DATA_PATH . 'poll.dat')))) return false;
    if(empty($file)) return false;
    return true;
}

function poll_is_voted($ip){
    if(!poll_is_running()) return false;
    if(!($file = @unserialize(@file_get_contents(DATA_PATH . 'poll.dat')))) return false;
    if(@is_array($file['ips']) && (in_array($ip, $file['ips']) || @$_COOKIE['reloadcms_poll'] == $file['q'])) return true;
    return false;
}

function poll_remove(){
    if(!is_file(DATA_PATH . 'poll.dat')) return 13;
    if(!($file = @unserialize(@file_get_contents(DATA_PATH . 'poll.dat')))) return false;
    if(!is_file(DATA_PATH . 'poll.old.dat')) $old = array(); else {
        $old = @unserialize(@file_get_contents(DATA_PATH . 'poll.old.dat'));
    }
    unset($file['ips']);
    $old[] = $file;
    file_write_contents(DATA_PATH . 'poll.old.dat', serialize($old));
    rcms_delete_files(DATA_PATH . 'poll.dat');
    return 0;
}

function poll_get_archive(){
    if(!is_file(DATA_PATH . 'poll.old.dat')) $old = array(); else {
        $old = @unserialize(@file_get_contents(DATA_PATH . 'poll.old.dat'));
    }
    foreach ($old as $id=>$data){
        $old[$id]['t'] = 0;
        foreach ($old[$id]['c'] as $v_id => $v_total){
            $old[$id]['t'] += $v_total;
        }
        foreach ($old[$id]['c'] as $v_id => $v_total){
            if($old[$id]['t'] != 0) $old[$id]['p'][$v_id] = round(($v_total/$old[$id]['t'])*100); else $old[$id]['p'][$v_id] = 0;
        }
    }
    return $old;
}

// Vote in poll form
if(isset($_POST['poll_vote'])) {
    $system->results['vote'] = poll_vote($_POST['poll_vote'], $_SERVER['REMOTE_ADDR']);
}
?>