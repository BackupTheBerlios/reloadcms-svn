<table cellspacing="0" cellpadding="2" border="0" width="100%">
<form method="post" action="">
<input type="hidden" name="<?=$tpldata['mode']?>" value="1">
<tr>
    <td width="50%" align="right"><?=$lang['users']['reglogin']?>:</td>
    <td width="50%" align="left"><?php if($tpldata['mode'] != 'profile_form'){?> <input type="text" name="username" value="<?=@$tpldata['values']['username']?>"><?php } else {?><?=@$tpldata['values']['username']?><?php }?></td>
</tr>
<tr>
    <td width="50%" align="right"><?=($tpldata['mode'] == 'profile_form') ? $lang['users']['updpassword'] : $lang['users']['password']?>:</td>
    <td width="50%" align="left"><input type="password" name="password"></td>
</tr>
<tr>
    <td width="50%" align="right"><?=$lang['users']['passwordconfirm']?>:</td>
    <td width="50%" align="left"><input type="password" name="confirmation"></td>
</tr>
<tr>
    <td width="50%" align="right"><?=$lang['users']['regnick']?>:</td>
    <td width="50%" align="left"><input type="text" name="userdata[nickname]" value="<?=@$tpldata['values']['nickname']?>"></td>
</tr>
<tr>
    <td width="50%" align="right"><?=$lang['users']['regemail']?>:</td>
    <td width="50%" align="left"><input type="text" name="email" value="<?=@$tpldata['values']['email']?>"></td>
</tr>
<tr>
    <td width="50%" align="right"><?=$lang['users']['hideemail']?>:</td>
    <td width="50%" align="left"><input type="checkbox" name="userdata[hideemail]" value="1" <?=((!isset($tpldata['values']['hideemail'])) ? 'checked' : (@$tpldata['values']['hideemail']) ? 'checked' : '')?>"></td>
</tr>
<tr>
    <td width="50%" align="right"><?=$lang['users']['timezone']?>:</td>
    <td width="50%" align="left"><?=user_tz_select(@$tpldata['values']['tz'], 'userdata[tz]')?></td>
</tr>
<?php foreach ($tpldata['fields'] as $field_id => $field_name) { ?>
<tr>
    <td width="50%" align="right"><?=$field_name?>:</td>
    <td width="50%" align="left"><input type="text" name="userdata[<?=$field_id?>]"  value="<?=@$tpldata['values'][$field_id]?>"></td>
</tr>
<?php } ?>
<tr>
    <td colspan="2" align="center"><input type="submit" value="<?=$lang['general']['submit']?>"></td>
</tr>
</form>
</table>