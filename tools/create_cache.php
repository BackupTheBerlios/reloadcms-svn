<?php
define('RCMS_ROOT_PATH', '../');
include(RCMS_ROOT_PATH . 'common.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <link rel="stylesheet" href="./style.css" type="text/css">
</head>
<body>
<table cellspacing="1" cellpadding="3" border="0" width="100%">
<tr>
    <th colspan="3">ReloadCMS 1.0.X create users cache</th>
</tr>
<?php
$users = user_get_list('*');
if(!is_file(DATA_PATH . 'users.cache.dat')) $cache = array(); else {
    $cache = @unserialize(@file(DATA_PATH . 'users.cache.dat'));
}
foreach ($users as $userdata){
    $cache['nicks'][$userdata['username']] = $userdata['nickname'];
    $cache['mails'][$userdata['username']] = $userdata['email'];
    echo '
<tr>
    <td width="100%" class="row1" style="color: green">' . $userdata['nickname'] . '</td>
    <td class="row2" nowrap>' . $userdata['email'] . '</td>
</tr>';
}
file_write_contents(DATA_PATH . 'users.cache.dat', serialize($cache));
?>
</table>
</body>
</html>