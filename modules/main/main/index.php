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
$system->showModuleWindow('', file_get_contents(DATA_PATH . 'intro.html'), 'left');

$articles = articles_parse_list(1, true, NEWS_PATH);
$result = '';
if(!empty($articles)){
    foreach($articles as $article) {
        $cat_data = articles_get_category($article['catid'], false, NEWS_PATH);
        if(!empty($article)){
            $cat_data = articles_get_category($article['catid'], false, NEWS_PATH);
            $result .= rcms_parse_module_template('article.tpl', $article + array('showdesc' => true, 'showtitle' => true,
                                                        'linktext' => (($article['text_nonempty']) ? $lang['articles']['readmore'] : $lang['articles']['comments']) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
                                                        'linkurl' => './index.php?module=articles&catid=' . $article['catid'] . '&id=' . $article['id'] . '&work_dir=news',
                                                        'cat_data' => $cat_data));
        }
    }
}
$system->showModuleWindow($lang['articles']['latestnews'], $result, 'center');
$system->config['pagename'] = $lang['pages']['index'];
?>