<form method="post" action="">
    <input type="hidden" name="add_minichat_message" value="1">
    <?php if(!LOGGED_IN && $tpldata['allow_guests_enter_name']) {?>
        <input type="text" name="mcnick" style="width: 80%; text-align:center;" value="<?=$lang['users']['guest']?>"><br>
    <?php }?>
    <textarea rows="3" name="mctext" style="width: 90%;"></textarea><br>
    <input type="submit" value="<?=$lang['general']['submit']?>">
</form>