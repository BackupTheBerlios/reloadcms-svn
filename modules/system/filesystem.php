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

//---------------------------------------------------------//
// This function perform removing of files and directories //
//---------------------------------------------------------//
function rcms_delete_files($file, $recursive = false, $wildcard = false) {
    if($recursive) {
        if($wildcard) $els = rcms_scandir(dirname($file), basename($file));
        else $els = rcms_scandir($file);
        foreach ($els as $el) rcms_delete_files($file . '/' . $el, true);
    }
    if(!$wildcard){
        if(is_dir($file)) return rmdir($file); else return unlink($file);
    } else {
        $els = rcms_scandir(dirname($file), basename($file));
        foreach ($els as $el) {
            if(is_dir(dirname($file) . '/' . $el)) rmdir(dirname($file) . '/' . $el); else unlink(dirname($file) . '/' . $el);
        }
    }
}

//---------------------------------------------------------//
// This function perform renaming of file                  //
//---------------------------------------------------------//
function rcms_rename_file($oldfile, $newfile) {
    rename($oldfile, $newfile);
    if(is_dir($newfile)) @chmod($newfile, 0777);
    else @chmod($newfile, 0666);
    return true;
}

//---------------------------------------------------------//
// This function perform cretiong of directory             //
//---------------------------------------------------------//
function rcms_mkdir($dir) {
    if(!is_dir($dir)){
        if(!is_dir(dirname($dir))) rcms_mkdir(dirname($dir));
    }
    return @mkdir($dir, 0777);
}

//---------------------------------------------------------//
// This function is php5 file_put_contents copy            //
//---------------------------------------------------------//
function file_write_contents($file, $text) {
    if($fp = @fopen($file, "w+")) {
        if(!@fwrite($fp,$text)) return false;
        @fclose($fp);
    } else return false;
    @chmod($file, 0666);
    return true;
}

//---------------------------------------------------------//
// This function is created for compatibility              //
//---------------------------------------------------------//
if(!function_exists('file_get_contents')){
    function file_get_contents($file) {
        if(!$file = file($file)) return false;
        if(!$file = implode('', $file)) return false;
        return $file;
    }
}

//---------------------------------------------------------//
// Function to create ini files                            //
//---------------------------------------------------------//
function write_ini_file($data, $filename, $process_sections = false){
    $fp = @fopen($filename, 'w+');
    if(!$fp) return false;
    if(!$process_sections){
        if(is_array($data)){
            foreach ($data as $key => $value){
                if(!fwrite($fp, $key . ' = "' . str_replace('"', '&quot;', $value) . "\"\n")) return false;
            }
        }
    } else {
        if(is_array($data)){
            foreach ($data as $key => $value){
                if(!fwrite($fp, '[' . $key . ']' . "\n")) return false;
                foreach ($value as $ekey => $evalue){
                    if(!fwrite($fp, $ekey . ' = "' . str_replace('"', '&quot;', $evalue) . "\"\n")) return false;
                }
            }
        }
    }
    @fclose($fp);
    @chmod($filename, 0666);
    return true;
}

//---------------------------------------------------------//
// Advanced php5 scandir analog                            //
//---------------------------------------------------------//
function rcms_scandir($directory, $exp = '', $type = 'all') {
    $dir = $ndir = array();
    if(is_dir($directory)){
        $fh = opendir($directory);
        while (false !== ($filename = readdir($fh))) if(substr($filename, 0, 1) != '.') $dir[] = $filename;
        closedir($fh);
        if($exp != ''){
            $exp = '/' . str_replace('*', '(.*)', str_replace('.', '\\.', $exp)) . '/';
            foreach ($dir as $i => $v) if (preg_replace($exp, '', $v) == '') $ndir[] = $v;
            $dir = $ndir;
        }
        if($type !== 'all'){
            $func = 'is_' . $type;
            foreach ($dir as $i => $v) if($func($directory . '/' . $v)) $ndir[] = $v;
            $dir = $ndir;
        }
        natsort($dir);
	}
    return $dir;
}

function rcms_get_current_id($directory, $ending) {
	$files = rcms_scandir($directory, '*' . $ending);
	$endfile = @end($files);
	$current = substr($endfile, 0, strlen($endfile)-strlen($ending));
	$current +=1;
	return $current . $ending;
}
?>