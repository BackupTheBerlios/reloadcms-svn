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
$articles = articles_parse_list(0, false);
$result = '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
$i=2;
if(!empty($articles)){
    foreach($articles as $article) {
        $result .= '<tr><td class="row' . $i . '"><a href="index.php?module=articles&catid=' . $article['catid'] . '&id=' . $article['id'] . '"><abbr title="' . $lang['articles']['poster'] . ': ' . $article['author_nick'] . ', ' . $lang['articles']['date'] . ': ' . rcms_format_time('d.m.Y H:i:s', $article['time']) . '">' . $article['title'] . ' (' . $article['comcnt'] . ')</abbr></a></td></tr>';
        $i++;
        if($i>3) $i=2;
    }
}
$result .= '</table>';
$system->showMenuWindow($lang['articles']['latestarts'], $result, 'center');
?>
