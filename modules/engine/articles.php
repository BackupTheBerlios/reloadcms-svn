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

//------------------------------------------------//
// Articles API: Article creation and update      //
//------------------------------------------------//
function articles_save($catid, $artid, $title, $src, $desc, $text, $mode = 'text', $comments = 'yes', $dir = ARTICLES_PATH) {
    global $system;
    if(!is_dir($dir . $catid)) return 12;
	if($artid != 0 && !is_dir($dir . $catid . '/' . $artid)) return 10;
	// For security reasons all html will be striped off
	$title = trim(strip_tags($title));
	$src   = trim(strip_tags($src));
	$text  = trim($text);
	$desc  = trim($desc);
	// Now check for empty fields
	if(empty($title)) return 16;
	if(empty($src)) $src = "-";
	if(empty($text) && empty($desc)) return 15;
	if(empty($desc)) $desc = substr($text, 0, 200) . ' ...';
	// Getting current article id and preparing directory
	$_artid = $artid;
	if($artid == 0) $artid = @file_get_contents($dir . $catid . '/last') + 1;
	$artprefix = $dir . $catid . '/' . $artid . '/';
	if(!is_dir($artprefix)) rcms_mkdir($artprefix);
	$time = rcms_get_time();
	if(!empty($_artid)) $old = articles_get($catid, $artid, false, 0, $dir);
	// Writing files
	write_ini_file(array(
	   'title' => $title,
	   'src'  => $src,
	   'author_nick' => $system->user['nickname'],
	   'author_name' => $system->user['username'],
	   'time' => $time,
	   'comments' => $comments,
	   'views' => !empty($_artid) ? $old['views'] : 0,
	   'mode' => $mode,
	   'comcount' => !empty($_artid) ? $old['comcount'] : 0,
	), $artprefix . 'define');
	file_write_contents($artprefix . 'short', $desc);
	file_write_contents($artprefix . 'full', $text);
	if($_artid == 0) file_write_contents($dir . $catid . '/last', $artid);
	if($_artid == 0) articles_register_last($catid, $artid, $system->config['num_of_latest'], $time, $dir);
	return 0;
}

//------------------------------------------------//
// Articles API: Article moving                   //
//------------------------------------------------//
function articles_move($catid, $artid, $newcatid, $dir = ARTICLES_PATH) {
	$newartid = @file_get_contents($dir . $newcatid . '/last') + 1;
	$oldartprefix = $dir . $catid . '/' . $artid . '/';
	$newartprefix = $dir . $newcatid . '/' . $newartid . '/';
	rcms_rename_file($oldartprefix, $newartprefix);
	file_write_contents($dir . $newcatid . '/last', $newartid);
    articles_move_at_last($catid, $artid, $newcatid, $newartid, $dir);
    return $newartid;
}

//------------------------------------------------//
// Articles API: Article deletion                 //
//------------------------------------------------//
function articles_delete($catid, $artid, $dir = ARTICLES_PATH) {
    global $system;
    if(!is_dir($dir . $catid)) return 12;
	if(!is_dir($dir . $catid . '/' . $artid)) return 10;
	
	$artprefix = $dir . $catid . '/' . $artid . '/';
	rcms_delete_files($artprefix, true);
	
	articles_remove_from_last($catid, $artid, $system->config['num_of_latest'], $dir);
	$last = file_get_contents($dir . $catid . '/last');
	if($last == $artid){
        $lartid = $artid-1;
        while(!is_file($dir . $catid . '/' . $lartid . '/define') && $lartid != 0) $lartid--;
        $last = file_write_contents($dir . $catid . '/last', $lartid);
	}
	return 0;
}

//------------------------------------------------//
// Articles API: Category creation                //
//------------------------------------------------//
function articles_creare_category($title, $desc = '', $icon = array(), $access = 0, $dir = ARTICLES_PATH) {
    // If title is empty we cannot create category
	if(empty($title)) return 4;
	// So let's get new category id and create directory for category
	$categories = rcms_scandir($dir, '', 'dir');
	$catid = 1;
	while(is_dir($dir . $catid)) $catid++;
	$catprefix = $dir . $catid . '/';
	rcms_mkdir($catprefix);
	// Now we can safely create category files
    file_write_contents($catprefix . 'title', $title);
	file_write_contents($catprefix . 'description', $desc);
	file_write_contents($catprefix . 'access', $access);
	file_write_contents($catprefix . 'last', '0');
	// If there is an icon uploaded let's parse it
	if(!empty($icon) && empty($icon['error'])){
	    $icon['name'] = basename($icon['name']);
	    $icon['tmp']  = explode('.', $icon['name']);
	    if($icon['type'] == 'image/gif' || $icon['type'] == 'image/jpeg' || $icon['type'] == 'image/png'){
            move_uploaded_file($icon['tmp_name'], $catprefix . 'icon.' . $icon['tmp'][count($icon['tmp'])-1]);
        } else return 6;
	}
	return 0;
}

//------------------------------------------------//
// Articles API: Update category info             //
//------------------------------------------------//
// 4  - Category title is empty                   //
// 2  - Successfull                               //
////////////////////////////////////////////////////
function articles_update_category($id, $title, $desc, $icon = array(), $access = 0, $killicon = false, $dir = ARTICLES_PATH) {
    if(empty($title)) return 4;
    $catdata = articles_get_category($id, false, $dir);
    $catprefix = $dir . $id . '/';
	file_write_contents($catprefix . 'title', $title);
	file_write_contents($catprefix . 'description', $desc);
	file_write_contents($catprefix . 'access', $access);
	if(!empty($killicon)) rcms_delete_files($catdata['iconfull']);
	if(!empty($icon) && empty($icon['error'])){
	    $icon['name'] = basename($icon['name']);
	    $icon['tmp']  = explode('.', $icon['name']);
	    if($icon['type'] == 'image/gif' || $icon['type'] == 'image/jpeg' || $icon['type'] == 'image/png'){
            move_uploaded_file($icon['tmp_name'], $catprefix . 'icon.' . $icon['tmp'][count($icon['tmp'])-1]);
        } else return 5;
	}
    return 2;
}

//------------------------------------------------//
// Articles API: Delete category                  //
//------------------------------------------------//
// 12 - There are no specified category           //
// 0  - Successfull                               //
////////////////////////////////////////////////////
function articles_delete_category($id, $dir = ARTICLES_PATH) {
    if(!is_dir($dir . $id)) return 12;
    $catprefix = $dir . $id . '/';
    $articles = rcms_scandir($dir);
    foreach ($articles as $article) if(is_dir($catprefix . $article)) articles_delete($id, $article, $dir);
    rcms_delete_files($catprefix, true);
    return 0;
}

//------------------------------------------------//
// Articles API: work_dir check                   //
//------------------------------------------------//
function articles_get_work_dir(&$work_dir_suffix) {
    switch (@$_GET['work_dir']){
        case 'news': $work_dir_suffix = '&work_dir=' . $_GET['work_dir']; return NEWS_PATH;
        default: return ARTICLES_PATH;
    }
}

//------------------------------------------------//
// Articles API: Article getting                  //
//------------------------------------------------//
function articles_get($catid, $artid, $parse = true, $level = 0, $dir = ARTICLES_PATH) {
    global $system;
    if(!is_file($dir . $catid . '/access')) $minlevel = 0;
    else $minlevel = (int) file_get_contents($dir . $catid . '/access');
    if($minlevel > @$system->user['accesslevel'] && !$system->checkForRight('-any-')) return false;
    if(@is_file($dir . $catid . '/' . $artid . '/define')){
        $article_data = @parse_ini_file($dir . $catid . '/' . $artid . '/define');
        if($level > 0) {
            $article_data['desc'] = @file_get_contents($dir . $catid . '/' . $artid . '/short');
            if ($parse) $article_data['desc'] = rcms_parse_text($article_data['desc'], true, (@$article_data['mode'] == 'html') ? true : false, (@$article_data['mode'] == 'html') ? false : true, false, true);
	    }
	    if($level == 1) {
            $size = @filesize($dir . $catid . '/' . $artid . '/full');
            $article_data['text_nonempty'] = ($size < 1) ? false : true;
	    }
	    if($level > 1) {
            $article_data['text'] = @file_get_contents($dir . $catid . '/' . $artid . '/full');
            if ($parse) $article_data['text'] = rcms_parse_text($article_data['text'], true, (@$article_data['mode'] == 'html') ? true : false, (@$article_data['mode'] == 'html') ? false : true, false, true);
	    }
        $article_data['id']   = $artid;
	    $article_data['catid'] = $catid;
	    $article_data['comcnt'] = $article_data['comcount'];
	    return $article_data;
    } return false;
}

//------------------------------------------------//
// Articles API: Increase article view count      //
//------------------------------------------------//
function articles_inc_view_count($catid, $artid, $dir = ARTICLES_PATH) {
    if(@is_file($dir . $catid . '/' . $artid . '/define')){
	    $article_data = @parse_ini_file($dir . $catid . '/' . $artid . '/define');
	    $article_data['views']++;
	    $article_data = @write_ini_file($article_data, $dir . $catid . '/' . $artid . '/define');
	    return true;
    } return false;
}

//------------------------------------------------//
// Articles API: Get comments to the article      //
//------------------------------------------------//
function articles_get_comments($catid, $artid, $dir = ARTICLES_PATH) {
    if($data = @file_get_contents($dir . $catid . '/' . $artid . '/comments')){
        $data = unserialize($data);
        foreach($data as $i => $msg){
            if(!empty($data[$i])) $data[$i]['text'] = rcms_parse_text($data[$i]['text'], true, false, true, 50);
        }
        return $data;
    } else return array();
}

//------------------------------------------------//
// Articles API: Category getting                 //
//------------------------------------------------//
function articles_get_category($catid, $parse = true, $dir = ARTICLES_PATH) {
    global $system;
    $cat_prefix = $dir . $catid . '/';
    if(!is_file($cat_prefix . '/access')) $minlevel = 0;
    else $minlevel = (int) file_get_contents($cat_prefix . '/access');
    if($minlevel > @$system->user['accesslevel'] && !$system->checkForRight('-any-')) return false;
    // If category exists
    if(@is_dir($cat_prefix)){
		$return['id'] = $catid;
		$return['title'] = file_get_contents($cat_prefix . 'title');
        $return['description'] = file_get_contents($cat_prefix . 'description');
        if(!is_file($cat_prefix . '/access')) $return['accesslevel'] = 0;
        else $return['accesslevel'] = (int) file_get_contents($cat_prefix . '/access');
        if($parse) $return['description'] = rcms_parse_text($return['description'], true, false, true, false, true);
        $return['articles_clv'] = count(rcms_scandir($dir . '/' . $catid, '', 'dir'));
        $return['last_article'] = articles_get($catid, file_get_contents($cat_prefix . 'last'), $parse, 0, $dir);
        // Search for icon
        if(is_file($cat_prefix . 'icon.gif')) {
            $return['icon'] = 'icon.gif';
            $return['iconfull'] = $cat_prefix . 'icon.gif';
        } elseif(is_file($cat_prefix . 'icon.png')) {
            $return['icon'] = 'icon.png';
            $return['iconfull'] = $cat_prefix . 'icon.png';
        } elseif(is_file($cat_prefix . 'icon.jpg')) {
            $return['icon'] = 'icon.jpg';
            $return['iconfull'] = $cat_prefix . 'icon.jpg';
        }elseif(is_file($cat_prefix . 'icon.jpeg'))  {
            $return['icon'] = 'icon.jpeg';
            $return['iconfull'] = $cat_prefix . 'icon.jpeg';
        } else $return['icon'] = false;
        // Finish!
        return $return;
    } return false;
}

//------------------------------------------------//
// Articles API: Categories list getting          //
//------------------------------------------------//
function articles_get_categories_list($short = true, $parse = true, $dir = ARTICLES_PATH) {
    if($categories = rcms_scandir($dir, '', 'dir')) {
        for($i=0; $i<count($categories); $i++){
            if($data = articles_get_category($categories[$i], $parse, $dir))
                if(!$short) $return[$i] = $data; else $return[$data['id']] = $data['title'];
        }
    }
    if(!empty($return)) return $return;
    else return false;
}

//------------------------------------------------//
// Articles API: Articles list getting            //
//------------------------------------------------//
function articles_get_articles_list($cat_id, $parse = true, $level = 0, $dir = ARTICLES_PATH) {
    global $system;
    if(!is_file($dir . $cat_id . '/access')) $minlevel = 0;
    else $minlevel = (int) file_get_contents($dir . $cat_id . '/access');
    if($minlevel > @$system->user['accesslevel'] && !$system->checkForRight('-any-')) return false;
    if($articles = rcms_scandir($dir . $cat_id, '', 'dir')) {
        for($i=0; $i<count($articles); $i++) $return[$i] = articles_get($cat_id, $articles[$i], $parse, $level, $dir);
    }
    if(!empty($return)) return $return;
    elseif(is_file($dir . $cat_id . '/title')) return array();
    else return false;
}

//------------------------------------------------//
// Articles API: Comment posting                  //
//------------------------------------------------//
function articles_post_comment($catid, $artid, $text, $dir = ARTICLES_PATH) {
    global $system;
    if(!is_file($dir . $catid . '/access')) $minlevel = 0;
    else $minlevel = (int) file_get_contents($dir . $catid . '/access');
    if($minlevel > @$system->user['accesslevel'] && !$system->checkForRight('-any-')) return false;
    if($data = @file_get_contents($dir . $catid . '/' . $artid . '/comments')) $data = unserialize($data); else $data = array();
    $article_data = parse_ini_file($dir . $catid . '/' . $artid . '/define');
    $newmesg['author_user'] = $system->user["username"];
    $newmesg['author_nick'] = $system->user["nickname"];
    $newmesg['time'] = rcms_get_time();
    $newmesg['text'] = substr($text, 0, 2048);
    $data[] = $newmesg;
    $save = serialize($data);
    file_write_contents($dir . $catid . '/' . $artid . '/comments', $save);
    $article_data['comcount']++;
    write_ini_file($article_data, $dir . $catid . '/' . $artid . '/define');
    return true;
}

//------------------------------------------------//
// Articles API: Comment deletion                 //
//------------------------------------------------//
function articles_delete_comment($catid, $artid, $comment, $dir = ARTICLES_PATH) {
    $prefix = $dir . $catid . '/' . $artid . '/';
    if($data = @file_get_contents($prefix . 'comments')) $data = unserialize($data); else return false;
    $article_data = parse_ini_file($prefix . 'define');
    if(isset($data[$comment])) {
        unset($data[$comment]);
        file_write_contents($prefix . 'comments', serialize($data));
        $article_data['comcount']--;
        write_ini_file($article_data, $prefix . 'define');
    }
    return true;
}

//------------------------------------------------//
// Articles API: Getting a last articles list     //
//------------------------------------------------//
function articles_parse_list($level = 0, $parse = true, $dir = ARTICLES_PATH) {
    if(file_exists($dir . '0.last')){
        $result = array();
        $file = file($dir . '0.last');
        for($i=0; $i<count($file); $i++) {
            $file[$i] = preg_replace('/[\n\r]*/', '', $file[$i]);
            $file[$i] = explode('.', $file[$i], 2);
            if($article = articles_get($file[$i][0], $file[$i][1], $parse, $level, $dir)) $result[] = $article;
        }
        return $result;
    } else return array();
}

//------------------------------------------------//
// Articles API: Register last article in list    //
//------------------------------------------------//
function articles_register_last($catid, $artid, $total_number, $time, $dir = ARTICLES_PATH) {
    $last_articles = articles_parse_list(false, false, $dir);
    $last_articles_file = '';
    reset($last_articles);
    for ($i = 0; $i < $total_number; $i++){
        $line = current($last_articles);
        if($time > (int) $line['time']) {
            $last_articles_file .= $catid . '.' . $artid . "\n";
            $time = 0;
        } else {
            if(!empty($line)) $last_articles_file .= $line['catid'] . '.' . $line['id'] . "\n";
            next($last_articles);
        }
    }
    file_write_contents($dir . '0.last', $last_articles_file);
    return true;
}

//------------------------------------------------//
// Articles API: Update list if article is moved  //
//------------------------------------------------//
function articles_move_at_last($catid, $artid, $newcat, $newid, $dir = ARTICLES_PATH) {
    $file = @file_get_contents($dir . '0.last') or '';
    $file = @str_replace($catid . '.' . $artid, $newcat . '.' . $newid, $file);
	file_write_contents($dir . '0.last', $file);
}

//------------------------------------------------//
// Articles API: Remove article from the list     //
//------------------------------------------------//
function articles_remove_from_last($catid, $artid, $total_number, $dir = ARTICLES_PATH) {
	$last_articles = @file($dir . '0.last');
	$last_articles_file = '';
	for ($i = 0; $i <= $total_number; $i++){
	    if(isset($last_articles[$i]) && $last_articles[$i] != $catid . '.' . $artid . "\n") $last_articles_file .= $last_articles[$i];
	}
	file_write_contents($dir . '0.last', $last_articles_file);
	return true;
}
?>