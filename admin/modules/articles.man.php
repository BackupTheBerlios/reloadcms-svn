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

/******************************************************************************
* Extracting some data from request                                           *
******************************************************************************/
$work_dir = articles_get_work_dir($null);
$category = (empty($_REQUEST['category'])) ? '' : $_REQUEST['category'];
$article = (empty($_REQUEST['edit'])) ? '' : $_REQUEST['edit'];

if(!empty($work_dir) && $work_dir != ARTICLES_PATH) rcms_showAdminMessage($lang['results']['articles'][8] . $work_dir);

/******************************************************************************
* Perform deletion of articles                                                *
******************************************************************************/
if(!empty($_POST['delete'])) {
    foreach ($_POST['delete'] as $id=>$chk) if($chk) $res = articles_delete($category, $id, $work_dir);
    rcms_showAdminMessage($lang['results']['articles'][$res]);
}

/******************************************************************************
* Perform changing of article                                                 *
******************************************************************************/
if(!empty($_POST['editflag'])) {
    $res = articles_save($category, $article, @$_POST['a_title'], @$_POST['a_src'], @$_POST['a_description'], @$_POST['a_text'], @$_POST['a_mode'], @$_POST['a_comments'], $work_dir);
    if(!empty($_POST['a_category']) && $category != $_POST['a_category']) {
        $article = articles_move($category, $article, $_POST['a_category'], $work_dir);
        $category = $_POST['a_category'];
    }
    rcms_showAdminMessage($lang['results']['articles'][$res]);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$categories_list = articles_get_categories_list(true, false, $work_dir);
if(!empty($categories_list)) {
    $frm =new InputForm ('', 'post', $lang['admincp']['browse'], '' , 'multipart/form-data');
    $frm->addrow($lang['admincp']['articles']['manage']['selcat'], $frm->select_tag('category', $categories_list), 'top');
    $frm->show();
} else rcms_showAdminMessage($lang['results']['articles'][9]);

if(!empty($article) && !empty($category)){
    $article_data = articles_get($category, $article, false, 2, $work_dir);
    $frm =new InputForm ('', 'post', $lang['general']['submit'], '' , 'multipart/form-data', 'arted');
    $frm->addbreak($lang['admincp']['articles']['manage']['edit'] . ': ' . $article_data['title']);
    $frm->addrow($lang['articles']['categ'], $frm->select_tag('a_category', $categories_list, $article_data['catid']), 'top');
    $frm->addrow($lang['articles']['subj'], $frm->text_box('a_title', $article_data['title']), 'top');
    $frm->addrow($lang['articles']['author'], $frm->text_box('a_src', $article_data['src']), 'top');
    $frm->addrow('', rcms_show_bbcode_panel('document.arted.a_description'));
    $frm->addrow($lang['articles']['desc'], $frm->textarea('a_description', str_replace('<br />', '', $article_data['desc']), 70, 5), 'top');
    $frm->addrow('', rcms_show_bbcode_panel('document.arted.a_text'));
    $frm->addrow($lang['articles']['text'], $frm->textarea('a_text', str_replace('<br />', '', $article_data['text']), 70, 25), 'top');
    $frm->addrow($lang['articles']['mode'], $frm->radio_button('a_mode', $lang['articles']['modes'], $article_data['mode']), 'top');
    $frm->addrow($lang['articles']['allowcomments'], $frm->radio_button('a_comments', array('yes' => $lang['admincp']['allow'], 'no' => $lang['admincp']['disallow']), $article_data['comments']), 'top');
    $frm->hidden('editflag', '1');
    $frm->hidden('edit', $article);
    $frm->hidden('category', $category);
    $frm->show();
} elseif(!empty($category)){
    $category_name = $categories_list[$category];
    $articles = articles_get_articles_list($category, false, 0, $work_dir);
    $frm = new InputForm ('', 'post', $lang['general']['submit'], '' , 'multipart/form-data');
    $frm->resetButton($lang['general']['reset']);
    $frm->addbreak($lang['admincp']['articles']['manage']['full'] . ': ' . $category_name);
    if(!empty($articles))
        foreach ($articles as $id => $article)
            $frm->addrow($article['title'] . ' [' . (($article['author_name'] != 'guest') ? '<a href="../index.php?module=user.list&user=' . $article['author_name'] . '">' . $article['author_nick'] . '</a>' : $article['author_nick']) . '] [' . rcms_format_time('d F Y H:i:s', $article['time']) . ']',
                $frm->checkbox('delete[' . $article['id'] . ']', '1', $lang['articles']['delete']) . '<br />' .
                $frm->radio_button('edit', array($article['id'] => $lang['articles']['edit']))
            );
    $frm->hidden('category', $category);
    $frm->show();
}
?>