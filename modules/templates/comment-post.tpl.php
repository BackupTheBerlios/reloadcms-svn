<?=rcms_show_bbcode_panel('document.form1.comtext'); ?>
<form method="post" action="" name="form1">
<input type="hidden" name="catid" value="<?=$_REQUEST['catid']?>">
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
<textarea name="comtext" maxlength="1000" cols="70" rows="7"></textarea><br>
<p align="center"><input type="submit" value="<?=$lang['general']['submit']?>"></p>
</form>