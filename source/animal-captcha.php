<?php
/*
### ANIMAL CAPTCHA 1.6.2
Author: GONZO (Javier Gonzalez Gonzalez) gonzomail@gmail.com
url: http://gonzo.teoriza.com/animal-captcha
Blogs Teoriza (www.Teoriza.com)
2011/05/01
###
*/

// *** CONFIG ***

$ac_dir 		= 'animal/';	// images directory of animals or things
$width 			= 120;
$height 		= 120;
$jpg_quality 	= 78; 			// final jpg quality (90 hight, 60 low), recomended: 72
$ac_num 		= 4;			// number of animals/objects (1 insecure, 2 default, 3 very secure)
$bg_trans 		= rand(20,28);	// transparency of background image, recomended: rand(28,32)
$rand_resize 	= 16;			// Random background margin to move and stretch



// *** CORE ***

// gen images list
chdir($ac_dir);
$dir = opendir('.');
while (($file = readdir($dir))!==false) {
	$ext = explode('.', $file);
	if (isset($ext[1]) AND $ext[1]=='jpg' AND is_file($file)) 
		$files[] = $file; 
}
closedir($dir);
chdir('../');


// load N animals images
$img_final = imagecreatetruecolor($width*$ac_num, $height);
$ac_rand = array_rand($files, $ac_num+1);


for ($i=1;$i<=$ac_num;$i++) {
	// select primary animal image
	$an = explode('.', $files[$ac_rand[$i]]);
	$an = $an[0]; 

	//if ($_GET['animal']) { $an = $_GET['animal']; } // DEBUG

	$a_name = explode('_', $an);
	
	if (isset($ac_result)) 
		$ac_result .= '|';
	
	$ac_result .= $a_name[0];
	$img = imagecreatefromjpeg($ac_dir.$an.'.jpg');

	// Random horizontal flip
	if (rand(0,1) == 0) {
		$temp = imagecreatetruecolor($width, $height);
		imagecopy($temp, $img, 0, 0, 0, 0, $width, $height);
		for ($x=0 ; $x<$width ; $x++)
			imagecopy($img, $temp, $width-$x-1, 0, $x, 0, 1, $height);
		imagecopy($temp, $img, 0, 0, 0, 0, $width, $height);
		imagedestroy($temp);
	}
	
	if ($i == 1) 
		$rm_x = rand('-'.$rand_resize, 0); 
	else 
		$rm_x = 0; 
	$rm_y = rand('-'.$rand_resize, 0);
	imagecopyresized($img_final, $img, ($width*($i-1)+$rm_x), $rm_y, 0, 0, ($width-$rm_x)+rand(0, $rand_resize), ($height-$rm_y)+rand(0, $rand_resize), $width, $height);
	imagedestroy($img);
}


// random background image
$ac_bg = $files[$ac_rand[0]];
$img_bg_size = imagecreatetruecolor($width*$ac_num, $height);
$img_bg = imagecreatefromjpeg($ac_dir.$ac_bg);
$img_bg = imagerotate($img_bg, (90*rand(1,3)), -1); // invert random background animal
imagecopyresized($img_bg_size, $img_bg, 0, 0, 0, 0, $width*$ac_num, $height, $width, $height);
imagedestroy($img_bg);
imagefilter($img_bg_size, IMG_FILTER_GRAYSCALE);
imagecopymerge($img_final, $img_bg_size, 0, 0, 0, 0, $width*$ac_num, $height, $bg_trans);
imagedestroy($img_bg_size);


// set session result
if (!isset($_SESSION)) { session_start(); }
$_SESSION['animalcaptcha'] = $ac_result;


// print image and destroy
header('Content-type: image/jpeg');
imagejpeg($img_final, NULL, $jpg_quality);
imagedestroy($img_final);
?>