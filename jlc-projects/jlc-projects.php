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
define('JLCP_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' ); 
define('JLCP_NAME', "Joe's Portfolio Plugin");
 
/*Files to Include*/
require_once('jlc-project-cpt.php');

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    add_image_size('jlc_project', 1100, 640, true); 
}


function jlc_projects_scripts() {
	wp_enqueue_script( 'picturefill', JLCP_PATH.'js/picturefill.js', array());
}

add_action( 'wp_enqueue_scripts', 'jlc_projects_scripts' );

/**Actions, Filters, and Hooks**/


//Replace image with picturefill markup
function jlc_projects_get_featured_image($html, $aid=false){
    $sizes= array('thumbnail', 'medium', 'large', 'jlc_project', 'full'); 
    
	$img= '<span data-picture data-alt="'.get_the_title().'">';
	$ct= 0;
	$aid= (!$aid) ? get_post_thumbnail_id() : $aid;

	foreach($sizes as $size){
		$url= wp_get_attachment_image_src($aid, $size);
		$width= ($ct < sizeof($sizes)-1) ? ($url[1]*0.66) : ($width/0.66)+25;
		$img.= '
			<span data-src="'. $url[0] .'"';
		$img.= ($ct > 0) ? ' data-media="(min-width: '. $width .'px)"></span>' :'></span>';
		$ct++;
	}

	$url= wp_get_attachment_image_src( $aid, $sizes[1]);
    $img.=  '<noscript>
            	<img src="'.$url[0] .'" alt="'.get_the_title().'">
			</noscript>
		</span>';
	return $img;
}

add_filter( 'post_thumbnail_html', 'jlc_projects_get_featured_image');



/**Display Functions and Shortcodes**/

function jlc_projects_get_link($id){
	$url= get_post_custom_values('jlc_projects_link', $pid); 
	return ($url[0] != '') ? $url[0] : false;
}


?>