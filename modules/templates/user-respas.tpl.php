<?php if(!LOGGED_IN) {?>
<table cellpadding="2" cellspacing="1" width="100%">
<form method="post" action="">
<input type="hidden" name="sendnewpas" value="1">
<tr>
    <td class="row1"><?=$lang['users']['username']?></td>
    <td class="row1"><input type="text" name="name" style="width: 90%; text-align:left;"></td>
</tr>
<tr>
    <td class="row1"><?=$lang['users']['email']?></td>
    <td class="row1"><input type="text" name="email" style="width: 90%; text-align:left;"></td>
</tr>
<tr>
    <td class="row2" colspan="2"><input type="submit" value="<?=$lang['users']['sendnew']?>"></td>
</tr>
</form>
</table>
<?php } ?>