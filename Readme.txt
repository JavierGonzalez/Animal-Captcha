=== Animal Captcha ===
Contributors: Javier González González (GONZO) - gonzomail@gmail.com
Tags: animal captcha, captcha, animal, akismet, spam, security, multisite, wpmu, wordpressmu, buddypress, multilingual, antispam, anti-spam, comments, login, php, code, free, recaptcha, register
Requires at least: 3.0
Tested up to: 3.1.2
Stable tag: 1.6.2
License: GPLv2

Captcha Animal protects your user registration and comments with a test of identifying two friendly animals.


== Description ==

Animal Captcha is a lightweight plugin for Wordpress that adds a captcha 
control on comments and register with a nice picture of an animal than any 
man knows, and yet a robot is unable to identify. It's nice, comfortable and very safe. 
Languages: English, Spanish, German, French and Portuguese. <a href="http://www.teoriza.com/captcha/example.php">Try a test</a>.

Features:
--------
  * Lightweight, it is proven successful in high traffic loads.
  * Supported languages: English, Spanish, German, French and Portuguese.
  * Includes 101 images of 37 animals.
  * Protects comments and user registration.
  * Every generated image is unique with random complex deformation techniques.
  * Multisite compatible (WPMU).
  * Animal Captcha Maker: Tool for creating and modifying animals quickly and easily.
  * Valid HTML.


Why use Captcha Animal?
--------
1. Security: this is the main reason the Internet is
   developments that address some captchas get code
   alphanumeric, with increasing success. However, if I could
   a machine to identify an animal! It is theoretically impossible.

2. Beauty: it's nice to see a picture of an ugly animal
   alphanumeric code.

3. Speed: Users save time because it takes less
   to identify and write an animal to enter a code
   random.

4. Effectiveness: the user gets it right with more likely in
   compared with recent insurance captchas.


Minor disadvantages:
--------
1. Language: Animal Captcha accepts animal names in English, Spanish, 
   German, French and Portuguese simultaneously. It's easy to add more 
   languages, just palabas must be added the names of the files. But
   this is an obvious limitation. In most blogs is more than
   enough to have English and Spanish, but if your blog is
   one of these languages will have to wait for better translation.

2. If your blog requires a high level of security is highly desirable to create a directory
   own animals and unpublished. That is, each image should be replaced by another
   photo of the animal you have chosen and cut your particular way. Of
   Thus security is 100% until proven otherwise (they have
   passed tests for 2 years).


Contact
--------
Oficial page - http://gonzo.teoriza.com/animal-captcha
Oficial Wordpress plugin page - http://gonzo.teoriza.com/animal-captcha
Animal Captcha Test - http://www.teoriza.com/captcha/example.php

Autor:
- Javier González González - gonzomail@gmail.com  - http://gonzo.teoriza.com/

Contributors: 
- NachE (safety test) - nache.nache@gmail.com - http://nache.net/
- Antonio Castro - acastro0841@gmail.com - http://www.ciberdroide.com/



== Frequently Asked Questions ==

1. Is it multilanguage?

	Yes. For now accepts English, Spanish, German, French and Portuguese. But you can easily add your own 
	language by simply changing the file names.

2. What if an animal has several synonym names?

	No problem. We accept several names for the same animal. For example, eagle 
	and hawk are accepted as correct.

3. Is it vulnerable to a simple brute force attack?

	No. We have implemented measures to mitigate the natural vulnerability of the 
	system. There are 37 different animals and by default shows 2 at a time. This 
	means that 1.369 requests should be made to achieve success only by brute force. 
	Configuring the test of 3 animals would take 50.653 requests for a single hit 
	by brute force. Nonetheless, she is preparing a new version with many more animals 
	(perhaps even objects) and display settings for N animals.

	With this you can get an idea of the seriousness with which Animal Captcha is 
	designed on computer security.

4. How much security?

	~~It is very secure in its default configuration. Security experts have tried brute 
	force and identification of patterns without success. Still, as with any captcha, 
	it is anticipated that with enough effort can be broken. If you require a near 100% 
	security, quiet sleep, we recommend creating a directory of their own animals, which 
	is not public.~~
	Now, none.

== Installation ==

Upload the Animal Captcha plugin to your blog and activate it. That is all! Is set by default in the most flexible and effective.

Opcional: set write permisions to "animal-captcha/source/animals/".


== Screenshots ==

1. Screenshot Animal Captcha Maker.
2. Screenshot Animal Captcha Maker croping.
3. Screenshot Animal Captcha test (whith 2 animals).
4. Screenshot Implementation in theme 1.


== Changelog ==

= 1.6.2 =
* Correcting the location of the Captcha code in the forms.
* Default to make it easier to see the animals. If greater security is required to raise the setting.
* Minor corrections.
* Added more animals.
* Accepted the names of animals in plural.
* Optimization. Animal Captcha now works a bit faster.

= 1.6.1 =
* Added support for many accents and special characters. So as to make normal characters, 
  compatible with the file names. This can enable many more languages.

= 1.6.0 =
* Union's two Captcha Animal (core + wp plugin) on a single project. Synchronizing versions. 
  Animal Captcha 1.5 (in source/) + Animal Captcha plugin 0.9.3 = Animal Captcha 1.6.0
* Added 3 new languages. German, French and Portuguese. In addition to English and Spanish. Five languages supported in total.
* Added first version of "Animal Captcha Maker". A very useful script to create and modify images of animals quickly.
* Added 101 images of 37 animals, studied carefully.
* Fixed and added many names thanks to a statistical study of the test sample. Names are added often used in Spanish and English.
* Errors solving them "notice" of php.
* Solve UTF-8 problems.
* Minor optimizations.

= 0.9.3 =
* Initial version with the core "Animal Captcha 1.5".
