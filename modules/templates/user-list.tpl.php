<?php
if(!empty($system->config['perpage'])) {
    $pages = ceil(count($tpldata)/$system->config['perpage']);
    if(!empty($_GET['page']) && ((int) $_GET['page']) > 0) $page = ((int) $_GET['page'])-1; else $page = 0;
    $start = $page * $system->config['perpage'];
    $total = $system->config['perpage'];
} else {
    $pages = 1;
    $page = 0;
    $start = 0;
    $total = count($tpldata);
}
?>
<div align="right"><?=rcms_pagination(count($tpldata), $system->config['perpage'], $page+1, '?module=user.list')?></div>
<table cellspacing="1" cellpadding="2" border="0" class="blackborder" width="100%">
<tr>
    <th width="33%"><?=$lang['users']['username']?></td>
    <th width="33%"><?=$lang['users']['nickname']?></td>
    <th width="33%"><?=$lang['users']['email']?></td>
</tr>
<?php
$i=1; for ($c = $start; $c < $total+$start; $c++){ $user = &$tpldata[$c]; if(!empty($user)) {?>
<tr>
    <td class="row<?=$i?>"><a href="?module=user.list&user=<?=@$user['username']?>"><?=@$user['username']?></a></td>
    <td class="row<?=$i?>"><?=@$user['nickname']?></td>
    <td class="row<?=$i?>"><?=(!@$user['hideemail']) ? @$user['email'] : $lang['users']['emailhidden']?></td>
</tr>
<?php $i++; if($i>3) $i=1; }}?>
</table>
<div align="left"><?=rcms_pagination(count($tpldata), $system->config['perpage'], $page+1, '?module=user.list')?></div>
