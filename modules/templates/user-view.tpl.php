<?php $user = &$tpldata['userdata']?>
<table cellspacing="1" cellpadding="2" border="0" class="blackborder" width="100%">
<tr>
    <th><?=$lang['users']['username']?></td>
    <td class="row3"><?=@$user['username']?></td>
</tr>
<tr>
    <th><?=$lang['users']['nickname']?></td>
    <td class="row3"><?=@$user['nickname']?></td>
</tr>
<tr>
    <th><?=$lang['users']['email']?></td>
    <td class="row3"><?=(!@$user['hideemail']) ? @$user['email'] : $lang['users']['emailhidden']?></td>
</tr>
<?php foreach ($tpldata['fields'] as $field_id => $field_name) { ?>
<tr>
    <th><?=$field_name?></td>
    <td class="row3"><?=rcms_parse_text(@$user[$field_id], false, false, false, false)?></td>
</tr>
<?php } ?>
</table>