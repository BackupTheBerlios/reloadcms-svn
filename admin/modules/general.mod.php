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
if(@is_array($_POST['modules'])){
    write_ini_file($_POST['modules'], CONFIG_PATH . 'modules.ini');
}

/******************************************************************************
* Interface                                                                   *
******************************************************************************/
$prior = parse_ini_file(CONFIG_PATH . 'modules.ini');
$total = rcms_scandir(MODULES_PATH);
$MODULES = array();
$unused = array();
for($i=0; $i<count($total); $i++){
    if(is_dir(MODULES_PATH . $total[$i]) && !in_array($total[$i], $prior)){
        $mtitle = $total[$i];
        if(is_file(MODULES_PATH . $total[$i] . '/module.php')) $mtitle = $mtitle . ' [M]';
        $disabled[$total[$i]] = $mtitle;
    }  
}
for($i=0; $i<count($prior); $i++){
    if(is_dir(MODULES_PATH . $prior[$i])){
        $mtitle = $prior[$i];
        if(is_file(MODULES_PATH . $prior[$i] . '/module.php')) $mtitle = $mtitle . ' [M]';
        $enabled[$prior[$i]] = $mtitle;
    }  
}
?>
<script language="javascript" src="<?=ADMIN_PATH?>slmv.js"></script>
<form name="form1" onsubmit="on_submit_prepare(document.form1.elements['modules[]'], null)" action="" method="POST">
<table cellpadding="2" cellspacing="0" border="0" align="center" width="40%">
<tr>
    <th><?=$lang['admincp']['general']['modules']['enabled']?></th>
    <th></th>
    <th><?=$lang['admincp']['general']['modules']['disabled']?></th>
</tr>
<tr>
    <td valign="top" align="center" class='row1'>
        <select name="modules[]" size="10" style="width:150" multiple>
            <?php foreach ($enabled as $mod=>$modtitle) echo '<option value="' . $mod . '">' . $modtitle . '</option>';?>
        </select><br>
        <input type="button" name="up" value="<?=$lang['general']['up']?>" onclick="select_move_up_selected_el(document.form1.elements['modules[]'])">
        <input type="button" name="down" value="<?=$lang['general']['down']?>" onclick="select_move_down_selected_el(document.form1.elements['modules[]'])">
    </td>
    <td valign="middle" class='row1'>
        <input type="button" name="add" value="&lt;" onclick="add_to_select_from_another(document.form1.elements['disabled'], document.form1.elements['modules[]'])">
        <br><br>
        <input type="button" name="rm" value="&gt;" onclick="add_to_select_from_another(document.form1.elements['modules[]'], document.form1.elements['disabled'])">
    </td>
    <td valign="top" align="center" class='row1'>
        <select name="disabled" size="10" style="width:150">
            <?php foreach ($disabled as $mod=>$modtitle) echo '<option value="' . $mod . '">' . $modtitle . '</option>';?>
        </select><br>
    </td>
</tr>
<tr>
    <td colspan="5" align="center" class='row2'><?=$lang['general']['modules']['desc']?></td>
</tr>
<tr>
    <td colspan="5" align="center" class='row2'><input type="submit" name="" value="<?=$lang['general']['submit']?>"></td>
</tr>
</table>
</form>