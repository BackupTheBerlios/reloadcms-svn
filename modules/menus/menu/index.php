<?php
if(!defined('HIDE_NAVIGATION') || !HIDE_NAVIGATION)
    $system->showMenuWindow($lang['pages']['title'],rcms_parse_menu(' - <a href="{link}">{title}</a><br>'));
?>