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
$archive = poll_get_archive();
$archive = array_reverse($archive);
$result = '';
foreach ($archive as $poll){
    $result .= '
    <table cellspacing="1" cellpadding="1" border="0" width="100%">
        <form action="" method="post">
        <tr>
            <th colspan="3">' . $poll['q'] . '</th>
        </tr>';
    foreach ($poll['v'] as $v_id => $v_title){
        $result .= '
        <tr class="row1">
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
    $result .= '
        <tr>
            <th colspan="3" align="center">[' . $lang['poll']['votes'] . ': ' . $poll['t'] .']</th>
        </tr>
        </form>
    </table><hr>';
}
$system->showModuleWindow($lang['poll']['archive'], $result);
$system->config['pagename'] = $lang['poll']['archive'];
?>
