<table border="0" celladding="1" cellspacing="1" width="100%">
<?php foreach ($tpldata as $id => $comment){?>
<tr>
    <th width="100%" align="left" valign="middle"><?=$lang['articles']['poster']?> <?=user_create_link($comment['author_user'], $comment['author_nick'])?></td>
    <th align="left" valign="center" nowrap="nowrap"><?=rcms_format_time('H:i:s d.m.Y', $comment['time'])?></td>
    <?php if($system->checkForRight('A-MA')) { ?>
    <th nowrap="nowrap"><form method="post" action=""><input type="hidden" name="cdelete" value="<?=$id?>"><input type="submit" name="" value="<?=$lang['articles']['delete']?>"></form></td>
    <?php }?>
</tr>
<tr>
    <td colspan="3" style="text-align:justify" valign="top"><?=$comment["text"]?></td>
</tr>
<?php }?>
</table>
<br>