<table cellpadding="2" cellspacing="1" width="100%">
<form method="post" action="">
<?php if(!LOGGED_IN) {?>
<input type="hidden" name="login_form" value="1">
<tr>
    <td class="row1"><?=$lang['users']['username']?></td>
    <td class="row1"><input type="text" name="username" style="width: 90%; text-align:left;"></td>
</tr>
<tr>
    <td class="row1"><?=$lang['users']['password']?></td>
    <td class="row1"><input type="password" name="password" style="width: 90%; text-align:left;"></td>
</tr>
<tr>
    <td class="row1" colspan="2">
        <input type="checkbox" name="remember" id="remember" value="1">
        <label for="remember"><?=$lang['users']['remember']?></label>
    </td>
</tr>
<tr>
    <td class="row2" colspan="2"><a href="?module=user.respas"><?=$lang['users']['forgotpas']?></a></td>
</tr>
<tr>
    <td class="row2"><input type="submit" value="<?=$lang['users']['login']?>"></td>
    <td class="row2"><a href="?module=user.register"><?=$lang['users']['register']?></a></td>
</tr>
<?php } else {?>
<input type="hidden" name="logout_form" value="1">
<?php if($system->checkForRight('-any-')) { ?>
<tr><td class="row3"><a href="./admin/"><?=$lang['general']['admincp']?></a></td></tr>
<?php }?>
<tr><td class="row2"><a href="?module=user.register"><?=$lang['users']['myprofile']?></a></td></tr>
<tr><td class="row2"><input type="submit" value="<?=$lang['users']['logout']?>"></td></tr>
<?php }?>
</form>
</table>
<hr />

<table cellpadding="2" cellspacing="1" width="100%">
<?php if(!empty($system->config['allowchskin'])){?>
<form method="post" action="">
<tr>
    <td><?=$lang['general']['skin']?>:</td>
    <td><?=user_skin_select(SKIN_PATH, 'user_selected_skin', $system->skin)?></td>
    <td><input type="submit" value="<?=$lang['general']['ok']?>"></td>
</tr>
</form>
<?php }?>
<?php if(!empty($system->config['allowchlang'])){?>
<form method="post" action="">
<tr>
    <td><?=$lang['general']['lang']?>:</td>
    <td><?=user_lang_select(LANG_PATH, 'lang_form', $system->language)?></td>
    <td><input type="submit" value="<?=$lang['general']['ok']?>"></td>
</tr>
</form>
<?php }?>
</table>