<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>                                                             
    <title><?rcms_show_element('title')?></title>
    <?rcms_show_element('meta')?>
    <link rel="stylesheet" href="<?=CUR_SKIN_PATH?>/style.css" type="text/css">
</head>
<body>
<?rcms_show_element('header')?>
<table width="100%" cellpadding="2" cellspacing="1" border="0">
<tr>
    <th colspan="3" align="center"><?rcms_show_element('title')?></th>
</tr>
<tr>
    <td colspan="3">
        <table width="100%" cellpadding="3" cellspacing="1" border="0" class="blackborder">
        <tr>
            <?rcms_show_element('navigation', '<td class="row3" align="center" onmouseover="this.className=\'row2\'" onmouseout="this.className=\'row3\'"><a href="{link}">{title}</a></td>')?>
        </tr>
        </table>
    </td>
</tr>
<tr>
	<td align="center" valign="top" width="200">
		<?rcms_show_element('menu_point', 'left@window.left')?>
	</td>
	<td align="center" valign="top">
        <?rcms_show_element('menu_point', 'up_center@window.center')?>
        <?rcms_show_element('main_point', $module . '@window.center')?>
        <?rcms_show_element('menu_point', 'down_center@window.center')?>
	</td>
	<td align="center" valign="top" width="200">
		<?rcms_show_element('menu_point', 'right@window.right')?>
	</td>
</tr>
</table>
<small><center><?rcms_show_element('copyright')?></center></small>
</body>
</html>