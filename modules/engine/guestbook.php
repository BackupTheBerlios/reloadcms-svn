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

function guestbook_get_last_msgs($file, $config = 'minichat.ini', $parse = true) {
    if($config) $config = parse_ini_file(CONFIG_PATH . $config);
    if($data = @file_get_contents($file)){
        $data = unserialize($data);
        $c    = count($data);
        if($parse){
            foreach($data as $i=>$msg){
                if(!empty($msg)) $data[$i]['text'] = rcms_parse_text($msg['text'], false, false, true, $config['max_word_len']);
            }
        }
        $ndata = $rdata = array();
        foreach ($data as $key=>$value) $ndata[$key . ''] = $value;
        $ndata = array_reverse($ndata, true);
        $i = 0;
        while($i < $config['messages_to_show'] && $el = each($ndata)){
            $rdata[$el['key']] = $el['value'];
            $i++;
        }
        return $rdata;
    } else return array();
}

function guestbook_add_post($file, $text, $gst_nick, $config = 'minichat.ini') {
    global $system;
    $text = trim($text);
    if(empty($text)) return false;
    $config = parse_ini_file(CONFIG_PATH . $config);
    if($data = @file_get_contents($file)) $data = unserialize($data);
    if(empty($config['max_db_size'])) $config['max_db_size'] = $config['messages_to_show'];
    $tmp = count($data) - $config['max_db_size'];
    if($tmp >= 0){
        $chunk = array_chunk(array_reverse($data, true), $config['max_db_size']-1, true);
        $data = array_reverse($chunk[0], true);
    }
    $newmesg['author_username'] = $system->user["username"];
    if(!LOGGED_IN && (!$config['allow_guests_enter_name'] || empty($gst_nick))) {
        $gst_nick = (strlen($gst_nick) > $config["max_word_len"]) ? '<abbr title="' . htmlspecialchars($gst_nick) . '">' . substr($gst_nick, 0, $config["max_word_len"]) . '</a>' : htmlspecialchars($gst_nick);
    }
    $newmesg['author_nickname'] = (LOGGED_IN) ? $system->user["nickname"] : $gst_nick;
    $newmesg['time'] = rcms_get_time();
    $newmesg['text'] = (strlen($text) > $config["max_message_len"]) ? substr($text, 0, $config["max_message_len"]) : $text;
    $data[] = $newmesg;
    file_write_contents($file, serialize($data));
    return true;
}

function guestbook_remove_post($file, $num, $config = false) {
    if($data = @file_get_contents($file)) $data = unserialize($data);
    unset($data[$num]);
    file_write_contents($file, serialize($data));
    return true;
}

function guestbook_write_to_arch($file, $message){
    $fp = fopen($file, 'a+');
    fwrite($fp, $message['author_username'] . '/' . $message['author_nickname'] . ' ' . rcms_format_time('d F Y H:i:s', $message['time'], 0) . ' (GMT)<br />' . $message['text'] . '<hr />');
    fclose($fp);
}
?>