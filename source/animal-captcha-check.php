<?php 
/*
### ANIMAL CAPTCHA 1.6.2
Author: GONZO (Javier Gonzalez Gonzalez) gonzomail@gmail.com
url: http://gonzo.teoriza.com/animal-captcha
Blogs Teoriza (www.Teoriza.com)
2011/05/01
###
*/
function animal_captcha_check($try) {
	if (!isset($_SESSION)) { session_start(); }
	if (isset($_SESSION['animalcaptcha'])) {
		//if (mb_detect_encoding($try, 'UTF-8') != 'UTF-8') { $try = utf8_encode($try); }
		$try = trim(strip_tags($try));
		$try = ereg_replace("[באגדהְֱֲֳִ]", "a", $try);
		$try = ereg_replace("[יטךכָֹÊֻ]", "e", $try);
		$try = ereg_replace("[םלמןּֽ־ֿ]", "i", $try);
		$try = ereg_replace("[ףעפץצ׃ׂװױײ]", "o", $try);
		$try = ereg_replace("[תשûüÚÙÛÜ]", "u", $try);
		$try = ereg_replace("[חַ]", "c", $try);
		$try = ereg_replace("[סׁ]", "n", $try);
		$try = ereg_replace("[]", "z", $try);
		$try = strtr($try, "¥µְֱֲֳִֵֶַָֹÊֻּֽ־ֿ׀ׁׂ׃װױײ״ÙÚÛÜÝßאבגדהוזחטיךכלםמןנסעףפץצרשתûü‎ÿ", "sozsozyyuaaaaaaaceeeeiiiidnoooooouuuuysaaaaaaaceeeeiiiionoooooouuuuyy");
		$delete = array('’', '²', '¡', '÷', '×', '“', '”', '„', '"', '\'', '.', ',', '_', ':',';','.', '´','!','¿','?','[',']','{','}','(',')','/','%','&','$','@');
		$try = str_replace($delete, "", $try);
		$try = utf8_encode(strtolower($try));
		$trys = explode(" ", $try);
		$animals = explode('|', $_SESSION['animalcaptcha']);
		$result = true;
		$e = 0;
		foreach($animals AS $one_animal) {	
			$animals_resp = explode('-', $one_animal);
			if (substr($trys[$e],-1, 1) == 's') { $trys[$e] = substr($trys[$e], 0, strlen($trys[$e])-1); }
			if (!in_array($trys[$e], $animals_resp)) { $result = false; }
			$e++;
		}

		unset($_SESSION['animalcaptcha']);
		return $result;
	}
}
?>