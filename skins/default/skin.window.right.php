<?php if(!empty($title)) {?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td><img src="<?=CUR_SKIN_PATH?>images/window_left.png" alt=""></td>
    <th background="<?=CUR_SKIN_PATH?>images/window_bg.png" width="100%" class="winheader" align="right">&nbsp;<?=$title?>&nbsp;</th>
    <td background="<?=CUR_SKIN_PATH?>images/window_bg.png"><img src="<?=CUR_SKIN_PATH?>images/bullet.png" alt=""></td>
    <td><img src="<?=CUR_SKIN_PATH?>images/window_right.png" alt=""></td>
</tr>
</table>
<?php }?>
<table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr>
    <td align="<?=$align?>" valign="top" class="window">
        <?=$content?>
    </td>
</tr>
</table>
<br />
