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
function is_pict($element){
    return preg_match('/.*\.(jpg|gif|png|bmp|JPG|GIF|BMP|PNG)$/', $element);
} 
function show_small_image($id){
    global $system;
    $images = rcms_scandir(GALLERY_PATH);
    $gal='';
    for ($i=0; $i<count($images); $i++) { 
        if (is_pict($images[$i])) {
            if ($id==$i){
                $stat = getimagesize(GALLERY_PATH . $images[$id]);
                $w = $stat[0]; $h = $stat[1];
                if($w > 150){
                    $x = $w / 150;
                    $h = $h / $x;
                    $w = 150;
                } elseif ($h > 150){
                    $x = $h / 150;
                    $w = $w / $x;
                    $h = 150;
                }
                $gal .= '<a href="?module=gallery"><img src="' . GALLERY_PATH . $images[$id] . '" width="' . $w . '" height="' . $h . '" border=0></a>';
                $system->showMenuWindow('', $gal, 'center'); 
            }
        }
    }
}
$images = rcms_scandir(GALLERY_PATH); 
$imgcount = count($images) - 1;
$random_image=rand(0, $imgcount);
show_small_image($random_image);
?>