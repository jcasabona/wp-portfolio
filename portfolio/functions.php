<?php
define( 'TEMPPATH', get_bloginfo('stylesheet_directory'));
define( 'IMAGES', TEMPPATH. "/images"); 

if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
}


register_sidebar( array (
	'name' => __( 'Sidebar', 'main-sidebar' ),
	'id' => 'primary-widget-area',
	'description' => __( 'The primary widget area', 'wpbp' ),
	'before_widget' => '<div class="widget">',
	'after_widget' => "</div>",
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array (
	'name' => __( 'Home', 'secondary-sidebar' ),
	'id' => 'home-widget-area',
	'description' => __( 'The home widget area', 'wpbp' ),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array (
	'name' => __( 'Footer', 'footer-sidebar' ),
	'id' => 'footer-widget-area',
	'description' => __( 'The footer widget area', 'wpbp' ),
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

//require_once('Select_Nav_Walker.php');


function jlc_get_attachements($pid){
	$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $pid ); 
	$attachments = get_posts( $args );
	if ($attachments) {
		foreach ( $attachments as $post ) {
			setup_postdata($post);
			the_attachment_link($post->ID, false, false, true);
		}
	}
}

function jlc_page_url() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


function pra_print_post_nav(){
?>
		<div class="navigation group">
			<div class="alignleft"><?php next_posts_link('&laquo; Next') ?></div>
			<div class="alignright"><?php previous_posts_link('Previous &raquo;') ?></div>
		</div>
<?php

}

function pra_print_not_found(){
?>
		<h3 class="center">No posts found. Try a different search?</h3>
		<?php get_search_form(); ?>
<?php
}

function pra_scripts() {
	global $is_IE;
	if( $is_IE ) {
		wp_enqueue_script( 'respondjs', TEMPPATH.'/js/respond.min.js', array());
		wp_enqueue_script('html5shiv', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array());
	}
	
	wp_enqueue_script( 'picturefill', TEMPPATH.'/js/picturefill.js', array());
	wp_enqueue_script( 'responsivenav', TEMPPATH.'/js/responsive-nav.min.js', array());
	wp_enqueue_script('typekit', '//use.typekit.net/ewl5xaa.js', array());
	
}

add_action( 'wp_enqueue_scripts', 'pra_scripts' );


function pra_responsive_nav(){
	echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
			<script>
				var navigation = responsiveNav("#top-menu", {
					insert: "before"
				});
			</script>';
}

add_action('wp_footer', 'pra_responsive_nav');

//must be called in Loop!
function pra_get_featured_image($aid=''){
    $sizes= get_intermediate_image_sizes();
	$img= '<span data-picture data-alt="'.get_the_title().'">';
	$ct= 0;
	$width= "";
	foreach($sizes as $size){
		$url= wp_get_attachment_image_src( get_post_thumbnail_id(), $size);
		
		
		$img.= '
			<span data-src="'. $url[0] .'"';
		$img.= ($ct > 0) ? ' data-media="(min-width: '. $width .'px)"></span>' :'></span>';
		
		$width= ($url[1] < 600) ? $url[1]+200 : $url[1]; //get next width up
		$ct++;
	}
	$url= wp_get_attachment_image_src( get_post_thumbnail_id(), $sizes[1]);
    $img.=  '<noscript>
            	<img src="'.$url[0] .'" alt="'.get_the_title().'">
			</noscript>
		</span>';
	return $img;
}

add_filter( 'post_thumbnail_html', 'pra_get_featured_image');

function pra_get_attachment_id_from_src ($src) {
  global $wpdb;
  $reg = "/-[0-9]+x[0-9]+?.(jpg|jpeg|png|gif)$/i";
  $src1 = preg_replace($reg,'',$src);
  if($src1 != $src){
      $ext = pathinfo($src, PATHINFO_EXTENSION);
      $src = $src1 . '.' .$ext;
  }
  $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$src'";
  $id = $wpdb->get_var($query);
  return $id;
}

?>