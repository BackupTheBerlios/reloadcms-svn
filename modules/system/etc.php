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

function rcms_in_array_recursive($needle, $haystack) {
    foreach ($haystack as $value){
        if(is_array($value)) return rcms_in_array_recursive($needle, $value);
        else return in_array($needle, $haystack);
    }
}

function stripslash_array(&$array){
    foreach ($array as $key => $value) {
        if(is_array($array[$key])) stripslash_array($array[$key]);
        else $array[$key] = stripslashes($value);
    }
}

function rcms_redirect($url) {echo '<script language="javascript">document.location.href="' . $url . '";</script>';}
function rcms_chtitle($text) {global $system; echo '<script language="javascript">document.getElementsByTagName("title")[0].text = "' . $system->config['title'] . ' - ' . $text . '";</script>';}

function rcms_send_mail($to, $from, $sender, $encoding, $subj, $text) {
    // Build header
	$headers = 'From: ' . $from . "\n";
	$headers .= 'Sender: <' . $sender . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= 'Message-ID: <' . md5(uniqid(time())) . "@" . $sender . ">\n";
	$headers .= 'Date: ' . gmdate('D, d M Y H:i:s T', time()) . "\n";
	$headers .= "Content-type: text/plain; charset={$encoding}\n";
	$headers .= "Content-transfer-encoding: 8bit\n";
	$headers .= "X-Mailer: ReloadCMS\n";
	$headers .= "X-MimeOLE: ReloadCMS\n";
    return mail($to, $subj, $text, $headers);
}

// Generates an alphanumeric random string of given length
function gen_rand_string($num_chars) {
	$chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

	list($usec, $sec) = explode(' ', microtime());
	mt_srand($sec * $usec);

	$max_chars = count($chars) - 1;
	$rand_str = '';
	for ($i = 0; $i < $num_chars; $i++)	{
		$rand_str .= $chars[mt_rand(0, $max_chars)];
	}

	return $rand_str;
}

function rcms_get_time(){
    return mktime();
}

function rcms_format_time($format, $gmepoch, $tz = ''){
    global $lang, $system;

    if(empty($tz)) $tz = $system->user['tz'];
    
    if ($system->language != 'english'){
        @reset($lang['datetime']);
        while (list($match, $replace) = @each($lang['datetime'])){
            $translate[$match] = $replace;
        }
    }
    return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}

function rcms_parse_text($str, $bbcode = true, $html = false, $nl2br = true, $wordwrap = false, $imgbbcode = false){
    $colors = array('aqua', 'black', 'blue', 'fuchsia', 'gray', 'green', 'lime', 'maroon', 'navy',
                'olive', 'purple', 'red', 'silver', 'teal', 'white', 'yellow');
    $colors = implode('|', $colors);
    if(!$html) $str = htmlspecialchars($str);
    if($bbcode) {
        $str = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $str);
        $str = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $str);
        $str = preg_replace("#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $str);
        $str = preg_replace("#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $str);
        $str = preg_replace("#\[move\](.+?)\[\/move\]#is", "<marquee>\\1</marquee>", $str);
        $str = preg_replace("#\[align=(left|center|right)*\](.*?)\[\/align(=\\1|)\]#is", "<div align=\"\\1\">\\2</div>", $str);
        $str = preg_replace("#\[quote\](.*?)\[\/quote\]#is", "<blockquote><smallfont>Quote:</smallfont><hr>\\1<hr></blockquote>", $str);
        $str = preg_replace("#\[file\](.+?)\[/file\]#is", "<a href=\"" . FILES_PATH . "\\1\">\\1</a>", $str);
        $str = preg_replace("#\[color=([\#a-f0-9]*|" . $colors . ")\](.*?)\[/color(=\\1|)\]#", "<font color=\"\\1\">\\2</font>", $str);
        $str = preg_replace_callback("#\[code\](.*?)\[\/code\]#is", 'rcms_prc_code', $str);
    }
    if($imgbbcode) $str = preg_replace("#\[img\][\s]*([^\\[]*)[\s]*\[/img\]#i", "<img src=\"\\1\" border=0>", $str);
    $str = make_clickable($str);
    if(!empty($wordwrap)) $str = preg_replace("#(<(.*?)>|[^\s<>\n\r]{" . $wordwrap . "}?)#i", " \\1", $str);
    if(!empty($nl2br)) $str = implode('<br />', preg_split("/(\r\n|\n|\r)/", $str));
    return $str;
}

function rcms_prc_link($matches){
    if(strlen($matches[2])>25){
        return ' <a href="' . $matches[2] . '" target="_blank">' . substr($matches[2], 0, 11) . '...' . substr($matches[2], -11) . '</a>';
    } else return ' <a href="' . $matches[2] . '" target="_blank">' . $matches[2] . '</a>';
}

function rcms_prc_link_short($matches){
    if(strlen($matches[2])>25){
        return ' <a href="http://' . $matches[2] . '" target="_blank">' . substr($matches[2], 0, 11) . '...' . substr($matches[2], -11) . '</a>';
    } else return ' <a href="http://' . $matches[2] . '" target="_blank">' . $matches[2] . '</a>';
}

function rcms_prc_mail($matches){
    if(strlen($matches[2])>25){
        return ' <a href="mailto:' . $matches[2] . '@' . $matches[3] . '" target="_blank">' . substr($matches[2], 0, 11) . '...' . substr($matches[2], -11) . '</a>';
    } else return ' <a href="mailto:' . $matches[2] . '@' . $matches[3] . '" target="_blank">' . $matches[2] . '</a>';
}

function rcms_prc_code($matches){
    return '<p align="left"><hr>' . str_replace('<br />', '', highlight_string(strtr($matches[1], array_flip(get_html_translation_table(HTML_ENTITIES))), true)) . '<hr></p>';
}

function make_clickable($text) {
	$ret = ' ' . $text;
	$ret = preg_replace_callback("#(^|[\n ])([\w]+?://[^ \"\n\r\t<]*)#is", "rcms_prc_link", $ret);
	$ret = preg_replace_callback("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#is", "rcms_prc_link_short", $ret);
	$ret = preg_replace_callback("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "rcms_prc_mail", $ret);
	$ret = substr($ret, 1);
	return($ret);
}

function rcms_is_valid_email($text) {
    if(preg_match('/^([a-zA-Z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]+(\.[a-zA-Z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]+)*)@((([a-z]([-a-z0-9]*[a-z0-9])?)|(#[0-9]+)|(\[((([01]?[0-9]{0,2})|(2(([0-4][0-9])|(5[0-5]))))\.){3}(([01]?[0-9]{0,2})|(2(([0-4][0-9])|(5[0-5]))))\]))\.)*(([a-z]([-a-z0-9]*[a-z0-9])?)|(#[0-9]+)|(\[((([01]?[0-9]{0,2})|(2(([0-4][0-9])|(5[0-5]))))\.){3}(([01]?[0-9]{0,2})|(2(([0-4][0-9])|(5[0-5]))))\]))$/', $text))
	   return true;
	else return false;
}

function rcms_show_bbcode_panel($textarea){
    return rcms_parse_module_template('bbcodes-panel.tpl', array('textarea' => $textarea));
}
?>