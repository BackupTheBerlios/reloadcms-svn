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
$work_dir_suffix = '';
$work_dir = articles_get_work_dir($work_dir_suffix);

if(!empty($_GET['catid'])) $catid = &$_GET['catid']; elseif(!empty($_POST['catid'])) $catid = &$_POST['catid']; else $catid = 0;
if(!empty($_GET['id'])) $id = &$_GET['id']; elseif(!empty($_POST['id'])) $id = &$_POST['id']; else $id = 0;

/*********************************************************************************
* Article output                                                                 *
*********************************************************************************/
if(!empty($catid) && !empty($id) && $article = articles_get($catid, $id, true, 2, $work_dir)) {
    $article['cat_data'] = articles_get_category($catid, false, $work_dir);
    /* If user posting a comment */
    if(!empty($_POST['comtext'])) {
        articles_post_comment($catid, $id, $_POST['comtext'], $work_dir);
    }
    /* If admin deleting comment */
    if(isset($_POST['cdelete']) && $system->checkForRight('A-MA')) {
        articles_delete_comment($catid, $id, $_POST['cdelete'], $work_dir);
    }
    /* Let's view selected article */
    $window_title = '<a href="./index.php?module=' . $module . $work_dir_suffix . '">' . $lang['articles']['categories'] . '</a> -&gt; ';
    $window_title .= '<a href="./index.php?module=' . $module . '&id=' . $article['cat_data']['id'] . $work_dir_suffix . '">' . ((strlen($article['cat_data']['title'])>20) ? substr($article['cat_data']['title'], 0, 20) . '...' : $article['cat_data']['title']) . '</a> -&gt; ';
    $window_title .= ((strlen($article['title']) > 20) ? substr($article['title'], 0, 20) . '...' : $article['title']);
    
    $system->config['pagename'] = $lang['pages']['articles'] . ' - ' . $article['title'];
    $system->showModuleWindow($window_title, rcms_parse_module_template('article.tpl', $article), 'center');
    
    articles_inc_view_count($catid, $id, $work_dir);
    /* May be show some comments :) */
    $comments = articles_get_comments($catid, $id, $work_dir);
    if(!empty($comments)) {
        $system->showModuleWindow($lang['articles']['comments'], rcms_parse_module_template('comment.tpl', $comments), 'center');
    }
    /* If comments are enabled in this article, show form */
    if($article['comments'] == 'yes') {
        $system->showModuleWindow($lang['articles']['postcomment'], rcms_parse_module_template('comment-post.tpl', $comments), 'center');
    }
} elseif(!empty($catid) && !empty($id)) {
    $system->registerModule('', $lang['results']['articles'][10], 'center');
} elseif(!empty($id)) {
/*********************************************************************************
* List of articles in category                                                   *
*********************************************************************************/
    $contents = articles_get_articles_list($id, true, 1, $work_dir);
    if($contents !== false){
        $result = '';
        $cat_data = articles_get_category($id, true, $work_dir);
        $system->config['pagename'] = $lang['articles']['categ'] . ' ' . $cat_data['title'];
        if(!empty($contents)){
            $contents = array_reverse($contents);
            if(!empty($system->config['perpage'])) {
                $pages = ceil(count($contents)/$system->config['perpage']);
                if(!empty($_GET['page']) && ((int) $_GET['page']) > 0) $page = ((int) $_GET['page'])-1; else $page = 0;
                $start = $page * $system->config['perpage'];
                $total = $system->config['perpage'];
            } else {
                $pages = 1;
                $page = 0;
                $start = 0;
                $total = count($contents);
            }
            $result .= '<div align="right">' . rcms_pagination(count($contents), $system->config['perpage'], $page+1, '?module=' . $module . '&id=' . $_GET['id'] . $work_dir_suffix) . '</div>';
            for ($c = $start; $c < $total+$start; $c++){
                $article = &$contents[$c];
                if(!empty($article)){
                    $result .= rcms_parse_module_template('article.tpl', $article + array('showdesc' => true, 'showtitle' => true,
                                                            'linktext' => (($article['text_nonempty']) ? $lang['articles']['readart'] : $lang['articles']['comments']) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
                                                            'linkurl' => '?module=' . $module . '&catid=' . $article['catid'] . '&id=' . $article['id'] . $work_dir_suffix,
                                                            'cat_data' => $cat_data));
                }
            }
        }
        $system->showModuleWindow('<a href="./index.php?module=' . $module . $work_dir_suffix . '">' . $lang['articles']['categories'] . '</a> -&gt; ' . ((strlen($cat_data['title'])>30) ? substr($cat_data['title'], 0, 30) . '...' : $cat_data['title']), $result, 'center');
    } else {
        $system->showModuleWindow('', $lang['results']['articles'][12], 'center');
    }
} else {
/*********************************************************************************
* List of categories                                                             *
*********************************************************************************/
    rcms_chtitle($lang['articles']['categories']);
    if($contents = articles_get_categories_list(false, true, $work_dir)) {
        $result = '';
        foreach($contents as $category) {
            $result .= rcms_parse_module_template('category.tpl', $category + array('link' => './index.php?module=' . $module . '&id=' . $category['id'] . $work_dir_suffix));
        }
        $system->showModuleWindow($lang['articles']['categories'], $result, 'center');
        $system->config['pagename'] = $lang['articles']['categories'];
    } else {
        $system->showModuleWindow('', $lang['results']['articles'][9], 'center');
    }
}
?>