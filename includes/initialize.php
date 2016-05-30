<?php 

// define the core paths
// define them as absolute paths to make sure that require_once work as expected

// DIRECTORY_SEPARATOR is a PHP pre_defined constant.
// (\(back slash) for Windows, /(forward slash) for Unix)

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR );

// we are talking here about an absolute file system path that's important , its the file system not the web server path.
// this is for PHP to locate the files that files it needs.
defined('SITE_ROOT') ? null :
// define('SITE_ROOT','C:'.DS.'wamp'.DS.'www'.DS.'photo_gallery' );
   define('SITE_ROOT',DS.'Users'.DS.'chaeib'.DS.'Sites'.DS.'photo_gallery' );
// here its the path to the library
defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS.'includes' );





// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS."functions.php");

// load core objects
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."pagination.php");
require_once(LIB_PATH.DS."phpmailer".DS."class.phpmailer.php");
require_once(LIB_PATH.DS."phpmailer".DS."class.smtp.php");
require_once(LIB_PATH.DS."phpmailer".DS."language".DS."phpmailer.lang-ca.php");


// load database_related classes
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photograph.php");
require_once(LIB_PATH.DS."comment.php");
// order is very important
?>