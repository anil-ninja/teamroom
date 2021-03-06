<?php

function resize_image($file, $w, $h, $type, $crop=FALSE) {
	$url = $file;
	if(explode(".",$file)[1] == 'jpg'){
		$file = "/var/www/html/collap_files/" . $file;
		if(file_exists($file)){
			if(!file_exists(explode(".",$file)[0] . "_".$w."x".$h.".jpg")){	
				list($width, $height) = getimagesize($file);
				$r = $width / $height;
				if ($crop) {
					if ($width > $height) {
						$width = ceil($width-($width*abs($r-$w/$h)));
					} 
					else {
						$height = ceil($height-($height*abs($r-$w/$h)));
					}
					$newwidth = $w;
					$newheight = $h;
				} 
				else {
					if ($w/$h > $r) {
						$newwidth = $h*$r;
						$newheight = $h;
					} 
					else {
						$newheight = $w/$r;
						$newwidth = $w;
					}
				}
				$src = imagecreatefromjpeg($file);
				$dst = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				
				imagejpeg($dst, explode(".",$file)[0] . "_".$w."x".$h.".jpg", 100);
				imagedestroy($dst);
			}
			return  explode(".",$url)[0] . "_".$w."x".$h.".jpg";
		}
		else {
			if($type == '1') { return 'fonts/project.jpg' ; }
			else { return 'img/default.gif' ; }
		}
	}
	else {
		return $url ;
	}
}
?>
