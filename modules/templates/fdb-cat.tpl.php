<?php end($tpldata['files']); $lastfile = current($tpldata['files']); reset($tpldata['files']); ?>
<table border="0" cellpadding="1" cellspacing="1" width="100%" class="grayborder">
<tr><th align="center" colspan="2"><?=$tpldata['name']?></th></tr><tr>
<tr>
    <td align="justify" valign="top" class="row2" width="100%" colspan="2">
        <?=@$tpldata['desc']?>
    </td>
</tr>
<tr>
    <td align="center" valign="middle" class="row2">
   		<?=$lang['files']['cfiles'] . count($tpldata['files'])?>
   		<?php if(count($tpldata['files'])){?>
   		<br><?=$lang['files']['lastfile']?>: <?=rcms_format_time('d F Y H:i:s', $lastfile['date'])?>
   		<?php }?>
   	</td>
   	<td align="center" valign="center" class="row3" width="20%">
   	    <a href="<?=$tpldata['link']?>"><?=$lang['files']['browsecat']?></a>
   	</td>
</tr>
</table>