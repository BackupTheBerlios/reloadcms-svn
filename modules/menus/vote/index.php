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
if (!empty($system->results['vote'])) $system->showModuleWindow('', $lang['results']['polls'][$system->results['vote']], 'center');
if($poll = poll_get()){
    $voted = poll_is_voted($_SERVER['REMOTE_ADDR']);
    $result = '
    <table cellspacing="1" cellpadding="1" border="0" width="100%">
        <form action="" method="post">
        <tr>
            <th colspan="3">' . $poll['q'] . '</th>
        </tr>';
    foreach ($poll['v'] as $v_id => $v_title){
        $result .= '
        <tr class="row1">
            <td>' . ((!$voted) ? '<input type="radio" name="poll_vote" value="' . $v_id . '">' : '') . '</td>
            <td align="left" width="100%">' . $v_title . '</td>
            <td align="right">' . $poll['c'][$v_id] . '</td>
        </tr>
        <tr>
            <td colspan="3">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td class="row3" width="' . ($poll['p'][$v_id]+1) . '%" nowrap>&nbsp;</td>
                    <td class="row2">&nbsp;</td>
                </tr>
                </table>
            </td>
        </tr>';
    }
    $result .= ((!$voted) ? '<tr>
            <td colspan="3" class="row1" align="center"><input type="submit" name="" value="' . $lang['general']['submit'] . '"></td>
        </tr>' : '') . '
        <tr>
            <th colspan="3" align="center">[' . $lang['poll']['votes'] . ': ' . $poll['t'] .'] [<a href="?module=poll.archive">' . $lang['poll']['archive'] . '</a>]</th>
        </tr>
        </form>
    </table>';
    $system->showMenuWindow($lang['poll']['title'], $result);
}
?>