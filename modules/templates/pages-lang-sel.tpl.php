<?php global $system; ?>
<form method="post" action="">
    <select name="page_lang">
<?php
    foreach ($tpldata as $alang){
        if(is_dir(LANG_PATH . $alang) && is_file(LANG_PATH . $alang . '/langid.txt')) $name = file_get_contents(LANG_PATH . $alang . '/langid.txt');
        else $name = $alang;
        echo '<option value="' . $alang . '"' . (($system->language == $alang) ? ' SELECTED>' : '>') . $name . '</option>';
    }
?>
    </select>
    <input type="submit" name="" value="<?=$lang['general']['submit']?>">
</form>