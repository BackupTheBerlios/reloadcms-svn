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
if (isset($_POST['deletebackupility'])) {
    $d = opendir(BACKUP_PATH);
    while($f = readdir($d)){
        if(is_file(BACKUP_PATH . $f)) rcms_delete_files(BACKUP_PATH . $f);
    }
    closedir($d);
}

if (!empty($_POST['backupit'])) {
    $bkupfilename='./backups/backup_'.date('H-i-s_d.m.Y').'.tar.gz';
    $bkp = new gzip_file($bkupfilename);
    $bkp->set_options(array('basedir'=>RCMS_ROOT_PATH, 'overwrite'=>1, 'level'=>9));
    $bkp->add_files('config');
    $bkp->add_files('content');
    $bkp->create_archive();
    $frm =new InputForm ("", "post", $lang['admincp']['general']['backup']['getit']);
    $frm->addbreak($lang['admincp']['general']['backup']['done']);
    $frm->hidden('getit', basename($bkupfilename));
    $frm->show();
}

if (!empty($_POST['getit'])) {
    ob_end_clean();
    header('Content-Type: x-gzip');
    header("Content-disposition: attachment; filename=$_POST[getit]");
    readfile(BACKUP_PATH . $_POST['getit']);
    exit;
}

// Interface generation
$frm =new InputForm ("", "post", $lang['admincp']['general']['backup']['doit']);
$frm->addbreak($lang['admincp']['general']['backup']['full']);
$frm->hidden('backupit', '1');
$frm->addrow($lang['admincp']['general']['backup']['desc'], $frm->checkbox("deleteold", '1', $lang['admincp']['general']['backup']['delold']), 'top');
$frm->show();
?>
