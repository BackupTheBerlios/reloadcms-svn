<table border="0" cellpadding="1" cellspacing="1" width="100%" class="grayborder">
<tr><th align="center" colspan="2"><?=$tpldata["title"]?></th></tr>
<tr>
    <td align="justify" valign="top" class="row2" width="100%" colspan="2">
        <?php if(!empty($tpldata['icon'])) {?><img src="<?=$tpldata['iconfull']?>" alt="" align="left"><?php }?>
        <?=@$tpldata['description']?>
    </td>
</tr>
<tr>
    <td align="center" valign="middle" class="row2">
   		<?=$lang['articles']['count']?>: <?=$tpldata['articles_clv']?>
   		<?php if($tpldata['articles_clv'] != '0'){?>
   		<br><?=$lang['articles']['last']?>: <?=rcms_format_time('d F Y H:i:s', $tpldata['last_article']['time'])?>
   		<?php }?>
   	</td>
   	<td align="center" valign="center" class="row3" width="20%"><a href="<?=$tpldata['link']?>"><?=$lang['articles']['readcat']?></a></td>
</tr>
</table>