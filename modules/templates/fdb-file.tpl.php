<table border="0" cellpadding="1" cellspacing="1" width="100%" class="grayborder">
<tr><th align="center" colspan="2"><?=$tpldata['name']?></th></tr><tr>
<tr>
    <td align="left" valign="top" class="row3" nowrap><?=$lang['files']['desc']?>: </td>
    <td align="left" valign="top" class="row3" width="100%"><?=@$tpldata['desc']?></td>
</tr>
<tr>
    <td align="left" valign="top" class="row3" nowrap><?=$lang['files']['filesize']?></td>
    <td align="left" valign="top" class="row3" width="100%"><?=$tpldata['size']?></td>
</tr>
<tr>
    <td align="left" valign="top" class="row3" nowrap><?=$lang['files']['author']?></td>
    <td align="left" valign="top" class="row3" width="100%"><?=$tpldata['author']?></td>
</tr>
<tr>
    <td align="left" valign="top" class="row3" nowrap><?=$lang['files']['date']?></td>
    <td align="left" valign="top" class="row3" width="100%"><?=rcms_format_time('d F Y H:i:s', $tpldata['date'])?></td>
</tr>
<tr>
   	<th align="center" colspan="2">
   	    <a href="<?=(basename($tpldata['link']) == $tpldata['link']) ? FILES_PATH . $tpldata['link'] : $tpldata['link']?>" target="_blank"><?=$lang['files']['openlink']?></a>
   	</th>
</tr>
</table>