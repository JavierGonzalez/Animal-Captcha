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

$ac_maker_active = false;  // Set "true" for active this script and set "false" for secure configuration of production.
// And for edit set write permisions to "animal-captcha/source/animals/".

// *** END CONFIG ***


if (($ac_maker_active == true) OR (isset($ac_dir))) {

if (isset($ac_dir)) { // requested from wp backend
	$in_wp = true;
	$ac_dir_img = '/wp-content/plugins/animal-captcha/source/animal/';
} else { // direct request
	$in_wp = false;
	$ac_dir = 'animal/';
	$ac_dir_img = $ac_dir; 
}


echo '<h1><a href="'.($in_wp?'../wp-admin/plugins.php?page=animal-captcha-maker':'animal-captcha-maker.php').'">Animal Captcha Maker</a></h1>

<style type="text/css">
.texta { width:150px; height:119px; }
</style>';

if (!is_writable($ac_dir)) { echo '<ul><li style="color:red;"><b>Set write permissions to "<em>source/animal/</em>" directory for edit.</b></li></ul>'; }


$txt_accion = '';
if (!isset($_REQUEST['a'])) { $_REQUEST['a'] = false; } // delete notice error
switch ($_REQUEST['a']) { // a = make action
	case 'mod_name':
		chdir($ac_dir);
		$dir = opendir('.');
		while (($file = readdir($dir)) !== false) {
			if ((strpos($file,$_POST['name'].'_') !== false) OR (strpos($file,$_POST['name'].'.') !== false)) {
				$file_new = ereg_replace("[^a-z-]", "", strtolower(str_replace('--', '-', eregi_replace("[\n|\r|\n\r]", '-', $_POST['name_new']))));
				if ($file_new != '') { 
					$file_new = str_replace($_POST['name'], $file_new, $file);
					rename($file, $file_new);
					$txt_accion .= '<b>File change:</b> '.$file.' --&gt; '.$file_new.'<br />';
				}
			}
		}
		closedir($dir);
		chdir('../');
		break;

	case 'add_image':
		
		echo '<blockquote>
<h2>Add new image</h2>
<form action="'.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker':'animal-captcha-maker.php').'" method="POST">
<input type="hidden" name="a" value="pre_process_image" />
<p><b>1. Select animal name:</b><br />
<select name="animal_select">
<option value="new">Create new ---&gt;</option>';

		chdir($ac_dir);
		$dir = opendir('.');
		while (($file = readdir($dir)) !== false) {
			$ext = explode('.', $file);
			if (($ext[1] == 'jpg') && (is_file($file))) {
				$animal = explode('_', $ext[0]); $animal = $animal[0];
				$animals_array[$animal]++;
			} 
		}
		closedir($dir);
		chdir('../');

		foreach ($animals_array AS $animal => $num) {
			echo '<option value="'.$animal.'"'.($_GET['animal']==$animal?'selected="selected"':'').'>('.$num.') '.$animal.'</option>';
		}

		echo '
</select> <b>or</b> create new animal: <input type="text" size="30" name="animal_text" value="" /> Only letters [a-z].</p>

<p><b>2. Select image:</b> &nbsp; <a href="http://www.google.es/images?as_q=+&hl=es&btnG=Buscar+con+Google&as_epq=&as_oq=&as_eq=&as_sitesearch=&safe=images&as_st=y&tbs=isch:1,isz:lt,islt:qsvga,iur:f">Search here</a> in Google Images (creative commons)<br />
IMG URL: <input type="text" size="100" name="animal_url" value="http://" /> (only .jpg)</p>

<p><input type="submit" value="Crop image" style="font-weight:bold;" /></p>
</form>
</blockquote>'; 
		
		exit;
		break;

		case 'pre_process_image':
			if ($_POST['animal_url'] != 'http://') {
				if ($_POST['animal_select'] == 'new') { $animal_name = str_replace(' ', '-', trim(strtolower($_POST['animal_text']))); } else { $animal_name = $_POST['animal_select']; }
				
				$data = @file_get_contents($_POST['animal_url']);
				if ($data) {
					$n = 1;
					while ($n != false) {
						$final_name_root = ($in_wp?$ac_dir:$ac_dir_img).$animal_name.($n==1?'':'_'.$n).'.jpg';
						$final_name = $ac_dir_img.$animal_name.($n==1?'':'_'.$n).'.jpg';
						if (!file_exists($final_name_root)) { $n = false; }
						$n++;
					}
					$file = @fopen($final_name_root, "w+");
					@fputs($file, $data);
					@fclose($file);
				}

				echo '

<link href="'.($in_wp?'/wp-content/plugins/animal-captcha/source/lib':'lib').'/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script src="'.($in_wp?'/wp-content/plugins/animal-captcha/source/lib':'lib').'/jquery.min.js"></script>
<script src="'.($in_wp?'/wp-content/plugins/animal-captcha/source/lib':'lib').'/jquery.Jcrop.js"></script>
<script language="Javascript">

$(function(){ 
	$("#animal-captcha-img").Jcrop({ 
		bgColor: "yellow",
		onChange: updateCoords,
		onSelect: updateCoords,
		aspectRatio: 1
	});
});


function updateCoords(c){ 
	$("#x").attr("value", c.x);
	$("#y").attr("value", c.y);
	$("#w").attr("value", c.w);
	$("#h").attr("value", c.h);
};
</script>

</blockquote>	
<h2>Crop image</h2>		
<form action="'.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker':'animal-captcha-maker.php').'" method="POST" style="display:inline;">
<input type="hidden" name="a" value="process_img" />
<input type="hidden" name="img_url" value="'.$final_name_root.'" />

<img src="'.$final_name.'?rand='.rand(10000,99999).'" style="max-width:800px;" id="animal-captcha-img" /><br />

<input type="submit" value="Make animal" style="font-weight:bold;font-size:20px;" />  
<input type="text" size="3" name="x" id="x" value="" align="right" />x 
<input type="text" size="3" name="y" id="y" value="" align="right" />y 
- Width <input type="text" size="3" name="w" id="w" value="" align="right" />px 
Height <input type="text" size="3" name="h" id="h" value="" align="right" />px<br />
</form> <button onclick="window.location.href=\''.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker&':'animal-captcha-maker.php?').'a=borrar&imagen='.$final_name_root.'\';" style="color:red;display:inline;">Delete</button><br />
<em>Some images are cropped mistaken for a strange bug. In future versions will fix the problem.</em>
</blockquote>
';
			}
			exit;
			break;

		case 'process_img':
			$src = $_POST['img_url'];

			list($width_orig, $height_orig) = getimagesize($src);
			
			if (!$_POST['h']) {
				$_POST['x'] = 0;
				$_POST['y'] = 0;
				$_POST['w'] = $width_orig;
				$_POST['h'] = $height_orig;
			}
			$height_new = 120;
			$width_new = 120;
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor($width_new, $height_new);
			imagecopyresampled($dst_r, $img_r, 0,0, $_POST['x'],$_POST['y'], $width_new,$height_new, $_POST['w'],$_POST['h']);
			@imagejpeg($dst_r, $src, 80);
			$txt_accion = '<em>Image created: '.$src.'</em> <button onclick="window.location.href=\''.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker&':'animal-captcha-maker.php?').'a=borrar&imagen='.$src.'\';" style="color:red;display:inline;">Undo</button>';
			break;


		case 'borrar':
			@unlink($_GET['imagen']);
			break;
}






$width = 120;
$jpg_quality = 75;

// gen images list
chdir($ac_dir);
$dir = opendir('.');
while (($file = readdir($dir)) !== false) {
	$ext = explode('.', $file);
	if ((isset($ext[1])) && ($ext[1] == 'jpg') && (is_file($file))) {
		$animal = explode('_', $ext[0]); $animal = $animal[0];
		$animals_array[$animal][$file] = true;
	} 
}
closedir($dir);
chdir('../');


//var_dump($animals_array);

echo '<p><em>'.$txt_accion.'</em></p>

<h2 style="display:inline;">List of images:</h2>
<span>&nbsp; Total: <b>'.(count($animals_array, COUNT_RECURSIVE) - count($animals_array)).'</b> animals  (<b>'.count($animals_array).'</b> differents). &nbsp; 
<button onclick="window.location.href=\''.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker&':'animal-captcha-maker.php?').'a=add_image\';" style="font-weight:bold;">Create new</button> 
(<a href="'.($in_wp?'/wp-content/plugins/animal-captcha/source/example.php':'example.php').'"><b>Try test</b></a>) 
(<a href="http://gonzo.teoriza.com/animal-captcha">Send opinion or problem</a>)
</span>
<table border="0" cellpadding="0" cellspacing="1">';
foreach ($animals_array AS $animal => $none1) {
	echo '<form accion="'.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker':'animal-captcha-maker.php').'" method="POST"><input type="hidden" name="a" value="mod_name" /><input type="hidden" name="name" value="'.$animal.'" /><tr><td align="right">';
	$num_animals = 0;
	foreach ($animals_array[$animal] AS $animals => $none2) {
		echo '<img src="'.$ac_dir_img.$animals.'" width="120" height="120" /> ';
		$num_animals++;
	}
	$num_names = explode('-', $animal);
	$num_names = count($num_names);
	echo '</td><td valign="top"><textarea name="name_new" class="texta">'.str_replace('-', "\n", $animal).'</textarea></td>
<td valign="top" style="color:#AAA;"><input type="submit" value="Edit" /></form> <button onclick="window.location.href=\''.($in_wp?'/wp-admin/plugins.php?page=animal-captcha-maker&':'animal-captcha-maker.php?').'a=add_image&animal='.$animal.'\';" style="font-weight:bold;">Add</button><br />
<b>'.$num_animals.'</b> images<br />
<b>'.$num_names.'</b> names</td></tr>';
}
echo '</table>';

} else { echo 'Access error: set active "true" in "source/animal-captcha-maker.php" file.'; }
?>