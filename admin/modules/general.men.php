<?php
////////////////////////////////////////////////////////////////////////////////
//   Copyright (C) 2004 ReloadCMS Development Team                            //
//   http://reloadcms.sf.net                                                  //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   This product released under GNU General Public License v2                //
////////////////////////////////////////////////////////////////////////////////
if(!empty($_POST['save'])){
    $content = '';
    $i = -1;
    foreach ($_POST['menus'] as $element){
        if(substr($element, 0, 1) == '/') {
            $content .= '[' . substr($element, 1) . "]\n";
            $i = 0;
        } elseif($i !== -1) {
            $content .= $i . '=' . $element . "\n";
            $i++;
        }
    }
    file_write_contents(CONFIG_PATH . 'menus.ini', $content);
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$menus = parse_ini_file(CONFIG_PATH . 'menus.ini', true);
include(SKIN_PATH . $system->skin . '/skin.php');
$current = array();
$usused = array();
foreach ($menus as $column => $coldata){
    if(!empty($skin['menu_point'][$column])){
        $current['/' . $column] = $lang['general']['column'] . ': ' . $skin['menu_point'][$column];
        foreach ($coldata as $menu){
            if(file_exists(MENU_MODULES_PATH . $menu . '/index.php')) $current[$menu] = ' > ' . $menu;
        }
    }
}
foreach ($skin['menu_point'] as $column => $text) if(!isset($current['/' . $column])) $unused['/' . $column] = $lang['general']['column'] . ': ' . $text;
$all_menus = rcms_scandir(MENU_MODULES_PATH);
foreach ($all_menus as $menu) if(!rcms_in_array_recursive(' > ' . $menu, $current)) $unused[$menu] = ' > ' . $menu;
?>
<script language="javascript" src="<?=ADMIN_PATH?>slmv.js"></script>
<form name="form1" onsubmit="on_submit_prepare(document.form1.elements['menus[]'])" action="" method="POST">
<input type="hidden" name="save" value="1">
<table cellpadding="2" cellspacing="1" border="0" align="center" width="60%">
<tr>
    <td valign="top" align="center" class='row1'>
        <select name="menus[]" size="10" style="width:400" multiple>
            <?php foreach ($current as $element => $text) echo '<option value="' . $element . '">' . $text . '</option>';?>
        </select><br>
        <input type="button" name="left_up" value="<?=$lang['general']['up']?>" onclick="select_move_up_selected_el(document.form1.elements['menus[]'])">
        <input type="button" name="left_down" value="<?=$lang['general']['down']?>" onclick="select_move_down_selected_el(document.form1.elements['menus[]'])">
        <input type="button" name="add" value="<?=$lang['general']['insert']?>" onclick="add_to_select_from_another(document.form1.elements['usused'], document.form1.elements['menus[]'])">
        <input type="button" name="remove" value="<?=$lang['general']['remove']?>" onclick="add_to_select_from_another(document.form1.elements['menus[]'], document.form1.elements['usused'])">
    </td>
</tr>
<tr>
    <td valign="top" align="center" class='row1'><?=$lang['admincp']['general']['menus']['unused']?>
        <select name="usused" size="10" style="width:400">
            <?php foreach ($unused as $element => $text) echo '<option value="' . $element . '">' . $text . '</option>';?>
        </select><br>
    </td>
</tr>
<tr>
    <td colspan="5" align="center" class='row2'><?=$lang['general']['menus_management_desc']?></td>
</tr>
<tr>
    <td colspan="5" align="center" class='row2'><input type="submit" name="" value="<?=$lang['general']['submit']?>"></td>
</tr>
</table>
</form>