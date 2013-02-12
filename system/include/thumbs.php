<?php 
function createJpegThumb($src,$dest,$name,$desired_width,$desired_height){
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);	
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);	
	imagejpeg($virtual_image,$dest.$name);	
}

function createPngThumb($src,$dest,$name,$desired_width,$desired_height){
	$source_image = imagecreatefrompng($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	imagejpeg($virtual_image,$dest.$name);
}

function createGifThumb($src,$dest,$name,$desired_width,$desired_height){
	$source_image = imagecreatefromgif($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	imagejpeg($virtual_image,$dest.$name);
}
?>