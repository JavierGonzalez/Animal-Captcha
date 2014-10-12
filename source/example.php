<?php 
/*
### ANIMAL CAPTCHA 1.6.2
Author: GONZO (Javier Gonzalez Gonzalez) gonzomail@gmail.com
url: http://gonzo.teoriza.com/animal-captcha
Blogs Teoriza (www.Teoriza.com)
2011/05/01
###
*/


//check form send
if (isset($_POST['animal-name'])) {

	require('animal-captcha-check.php'); //Animal Captcha check function, animal_captcha_check(), return true or false

	//check captcha
	if (animal_captcha_check($_POST['animal-name'])) { 
		$html = '<span style="color:blue;"><b>OK.</b> Test passed. You are human!</span>'; 
	} else { 
		$html = '<span style="color:red;"><b>Error.</b> Are you a machine?</span>'; 
	} 
}
?>
<html>
<head>
<title>Animal Captcha - Example test</title>
<meta name="description" content="Example test of Animal Captcha script, by Blogs Teoriza (GONZO, Javier Gonzalez)" /> 
<meta name="robots" content="noodp,index,follow" />
<meta name="author" content="Blogs Teoriza www.teoriza.com" />
<style type="text/css">
body { margin:0; padding:0; font-family:verdana,trebuchet,sans-serif; }
a { color:#0565AB; } a:hover { text-decoration:none; }
p { color:green;font-size:18px; }
input { color:#999;font-weight:bold;font-size:20px;margin:5px; }
</style>
</head>

<body onload="document.getElementById('focusanimal').focus()">
<center>

<h1 style="color:green;">Animal Captcha Test</h1>
<form action="example.php" method="POST">



<img src="animal-captcha.php<?=($_GET['num']?'?ac_num='.$_GET['num']:'')?>" border="0" height="120" id="animalcaptchaimg" onclick="this.src='animal-captcha.php<?=($_GET['num']?'?ac_num='.$_GET['num']:'')?>?'+Math.random();" style="cursor:pointer;" />


<br />

<p><b>What do you see in the picture?<br />
&iquest;Qu&eacute; ves en la imagen?</b><br />
<input id="focusanimal" type="text" value="<?php if (!isset($_POST['animal-name'])) { echo 'conejo elephant'; } ?>" name="animal-name" autocomplete="off" size="20" onclick="this.value='';" /><input type="submit" value="TEST" /><br /><?=$html?></p>



<p style="color:#666;">Names separated by spaces, basic level, for example: <em>tiger whale</em><br />
Nombres separados por espacios, nivel b&aacute;sico, por ejemplo: <em>vaca serpiente</em></p>



</center>
</form>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-59186-28");
pageTracker._trackPageview();
} catch(err) {}
</script>
</body>
</html>