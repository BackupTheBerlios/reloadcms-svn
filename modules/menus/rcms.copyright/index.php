<?php
$result='
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
    <th colspan="2"><a href="http://sourceforge.net/projects/reloadcms">' . $lang['copyright']['powered'] . '</a></th>
</tr>
<tr>
    <td class="row3">' . $lang['copyright']['version'] . '</td>
    <td class="row2">' . RCMS_VERSION_BRANCH . '.'  . RCMS_VERSION_SECOND . '-' . RCMS_VERSION_SUFFIX . '</td>
</tr>
<tr>
    <td class="row2">' . $lang['copyright']['devnumber'] . '</td>
    <td class="row3">' . RCMS_VERSION_REPOS . '/'  . RCMS_VERSION_REVIS . '</td>
</tr>
</table>';
$system->showMenuWindow('ReloadCMS', $result);
define('RCMS_COPYRIGHT_SHOWED', true);
?>
