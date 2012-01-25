<?php
/*
Plugin Name: Animal Captcha
Plugin URI: http://gonzo.teoriza.com/animal-captcha-plugin-para-wordpress
Description: Captcha Animal protects your user registration and comments with a test of identifying two friendly animals (basic level). <a href="http://www.teoriza.com/captcha/example.php">Run test here</a>.
Version: 1.6.2
Author: Javier González González (GONZO)
Author URI: http://gonzo.teoriza.com/
Powered by: Blogs Teoriza http://www.Teoriza.com/
License: GPLv2
*/



function animal_captcha_maker_menu() {
	if (is_super_admin()) { 
		add_submenu_page('plugins.php', 'Animal Captcha Maker', 'Animal Cap. Maker', 'edit_plugins', 'animal-captcha-maker', 'animal_captcha_maker');
	}
}

function animal_captcha_maker() {
	if (is_super_admin())  {
		$ac_dir = dirname(__FILE__).'/source/animal/';
		require('source/animal-captcha-maker.php');
	} else {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
}

function ac_print_form_captcha() {
	global $ac_path, $user_ID;
	if ((AC_CAPCHED) && ((!isset($user_ID)) || (intval($user_ID) == 0))) {
		define('AC_CAPCHED', false);
		if (strpos(WPLANG,'es_') !== false) {
			$question = '&iquest;Qu&eacute; animales ves? &nbsp; <em>(nivel b&aacute;sico, una palabra por animal)</em>'; 
			$animals_try = 'ballena conejo';
		} else { 
			$question = 'What animals do you see? &nbsp; <em>(basic level, in a word for animal)</em>'; 
			$animals_try = 'elephant fly';
		}
		echo '<div id="animal-captcha-form">
<label>'.$question.'<br /><input id="focusanimal" type="text" value="'.$animals_try.'" onclick="this.value=\'\';" name="animal-captcha" autocomplete="off" style="width:234px;margin:0 0 5px 0;" /></label><br />
<img src="/wp-content/plugins/animal-captcha/source/animal-captcha.php" border="0" height="120" id="animal-captcha-img" onclick="this.src=\'/wp-content/plugins/animal-captcha/source/animal-captcha.php?\'+Math.random();" style="cursor:pointer;" /><br />
<div><a href="http://gonzo.teoriza.com/animal-captcha" style="color:#666;text-decoration:none;margin:0 0 0 170px;font-size:10px;">Animal Captcha</a></div>
</div>';
	}
}

function ac_captcha_check_comment($comment) {
	global $user_ID, $_POST;
	require('source/animal-captcha-check.php');
	if (((isset($user_ID)) && (intval($user_ID) > 0)) OR (($comment['comment_type'] != '') AND ($comment['comment_type'] != 'comment')) OR (animal_captcha_check($_POST['animal-captcha']))) { 
		return $comment;
	} else {
		wp_die('<strong>Animal Captcha</strong>: captcha error.');
	}
}


function ac_captcha_check_register($errors) {
	global $_POST;
	require('source/animal-captcha-check.php');
	if (!animal_captcha_check($_POST['animal-captcha'])) {
		$errors->add('captcha_wrong', '<strong>Animal Captcha</strong>: captcha error.');
	}
	return $errors;
}



// In comments
global $wp_version;
if (version_compare($wp_version,'3','>=')) { // wp 3.0 +
	add_action('comment_form_after_fields', 'ac_print_form_captcha', 1);
	add_action('comment_form_logged_in_after', 'ac_print_form_captcha', 1);
}
add_action('comment_form', 'ac_print_form_captcha', 1);
add_filter('preprocess_comment', 'ac_captcha_check_comment', 1);


// In signup MU
$ac_ver = explode('.', $wp_version);
if ($ac_ver[0] > 2) {
	add_action('signup_extra_fields', 'ac_print_form_captcha');
	add_filter('wpmu_validate_user_signup', 'ac_captcha_check_register');
}

// In registration form
add_action('register_form', 'ac_print_form_captcha', 10);
add_filter('registration_errors', 'ac_captcha_check_register', 10);
if ($wpmu) {
	// for buddypress 1.1 only
	add_action('bp_before_registration_submit_buttons', 'ac_print_form_captcha');
	add_action('bp_signup_validate', 'ac_print_form_captcha');
	// for wpmu and (buddypress versions before 1.1)
	add_action('signup_extra_fields', 'ac_print_form_captcha');
	add_filter('wpmu_validate_user_signup', 'ac_captcha_check_register');
}


// Menu admin: Animal Captcha Maker
add_action('admin_menu', 'animal_captcha_maker_menu');

?>
