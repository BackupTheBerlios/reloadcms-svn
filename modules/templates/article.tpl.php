<table border="0" cellpadding="1" cellspacing="1" width="100%" class="grayborder">
<?php if(!empty($tpldata['showtitle'])) {?>
<tr>
    <th align="center" colspan="3"><?=$tpldata["title"]?></th>
</tr>
<?php }?>
<tr>
    <td align="justify" valign="top" colspan="3" class="row2">
        <?php if(!empty($tpldata['cat_data']['icon'])) {?>
            <img src="<?=$tpldata['cat_data']['iconfull']?>" alt="" align="left">
        <?php }?>
        <?=(!empty($tpldata['showdesc']) || empty($tpldata['text'])) ? $tpldata['desc'] : $tpldata['text']?>
    </td>
</tr>
<tr>
    <td class="row3" align="left" nowrap><?=rcms_format_time('d F Y H:i:s', $tpldata['time'])?></td>
    <td align="center" class="row2" width="100%"><?=$lang['articles']['poster']?> <?=user_create_link($tpldata['author_name'], $tpldata['author_nick'])?> :: <?=$lang['articles']['author']?>: <?=$tpldata['src']?></td>
<?php if(!empty($tpldata['linktext']) && !empty($tpldata['linkurl'])) {?>
   	<td align="left" class="row3" nowrap><a href="<?=$tpldata['linkurl']?>"><?=$tpldata['linktext']?></a></td>
<?php }?>
</tr>
</table><br>