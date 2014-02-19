<?php
/*
Plugin Name: Joe's Portfolio Plugin
Plugin URI: https://github.com/jcasabona/wp-portfolio
Description: A simple plugin that creates and display a projects portfolio with WordPress using custom post types!
Author: Joe Casabona
Version: 1.0
Author URI: http://www.casabona.org
*/


/*Some Set-up*/
define('JLC_PATH', WP_PLUGIN_URL . '/' . pplugin_basename( dirname(__FILE__) ) . '/' ); 
define('JLC_NAME', "Joe's Portfolio Plugin");
 
 /*Files to Include*/
 require_once('jlc-project-cpt.php');

?>