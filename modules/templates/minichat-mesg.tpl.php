<div class='row3'><?=user_create_link($tpldata['author_username'], $tpldata['author_nickname'])?></div>
<div class='row2'><?=$tpldata['text']?></div>
<div class='row3'>
    <?=rcms_format_time('d F Y H:i:s', $tpldata['time'], $system->user['tz'])?>
<?php if($system->checkForRight('MC-C')){?>
    <form method="post" action="">
        <input type="hidden" name="mcdelete" value="<?=$tpldata['id']?>">
        <input type="submit" name="" value="<?=$lang['general']['delete']?>">
    </form>
<?php }?>
</div>
<br>