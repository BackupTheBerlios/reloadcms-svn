<?php
statistic_register();
if($stats = statistic_get()){
    $result = '';
    $result .= '
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>';
    if(!empty($stats['online'])){
        $result .= '
    <td align="left" class="row1" width="50%">' . $lang['users']['online'] . '&nbsp;</td>
    <td class="row2" width="50%" align="right">';
    $i = 0;
    foreach ($stats['online'] as $name => $data){
        if($i != 0) $result .= ', ';
        $result .= user_create_link($name, $data['nick']);
        $i++;
    }
        $result .= '.
    </td>
</tr>';
    }
    $result .= '
<tr>
    <td align="left" class="row1">' . $lang['counter']['hitsall'] . '</td><td align="right" class="row2">' . $stats['totalhits'] . '&nbsp;</td>
</tr>
<tr>
    <td align="left" class="row1">' . $lang['counter']['hits'] . '</td><td align="right" class="row2">' . $stats['todayhits'] . '&nbsp;</td>
</tr>
<tr>
    <td align="left" class="row1">' . $lang['counter']['hosts'] . '</td><td align="right" class="row2">' . count($stats['todayhosts']) . '&nbsp;</td>
</tr>
</table>';
    $system->showMenuWindow($lang['counter']['title'], $result, 'center');
}
?>
