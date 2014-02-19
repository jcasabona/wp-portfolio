add_action('init', 'jlc_portfolio_register');  
  
function jlc_portfolio_register() {  
    $args = array(  
        'label' => __('Portfolio'),  
        'singular_label' => __('Project'),  
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => true,    
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail') ,
        'rewrite' => array('slug' => 'portfolio', 'with_front' => false)
       );  
  
    register_post_type( 'portfolio' , $args );  
    register_taxonomy("jlc-project-type", array("portfolio"), array("hierarchical" => true, "label" => "Project Type", "singular_label" => "Project Type", "rewrite" => true));

}  

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	add_image_size('jlc_project', 1400, 600, true); 
	
	//require ( ABSPATH . 'wp-admin/includes/image.php' );
	
	function regenerate_all_attachment_sizes() {
    $args = array( 'post_type' => 'attachment', 'numberposts' => 5, 'post_status' => null, 'post_parent' => null, 'post_mime_type' => 'image' ); 
    $attachments = get_posts( $args );
    if ($attachments) {
        foreach ( $attachments as $post ) {
            $file = get_attached_file( $post->ID );
            wp_update_attachment_metadata( $post->ID, wp_generate_attachment_metadata( $post->ID, $file ) );
        }
    }     
    
    
}

//add_action('init', 'regenerate_all_attachment_sizes');  
	
}



add_action("admin_init", "jlc_portfolio_admin_init");  
add_action('save_post', 'jlc_save_project_link');  

function jlc_portfolio_admin_init(){  
    add_meta_box("jlc-project-meta", "Project Options", "jlc_project_options", "portfolio", "side", "low");  
}  
  

function jlc_project_options(){  
        global $post;  
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);  
        $link = $custom["projLink"][0];  
?>  
    <label>Link:</label><input name="projLink" value="<?php echo $link; ?>" />  
<?php  
    }  
  
function jlc_save_project_link(){  
    global $post;  
    
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ 
		return $post_id;
	}else{
    	update_post_meta($post->ID, "projLink", $_POST["projLink"]); 
    } 
}  


add_filter("manage_edit-portfolio_columns", "jlc_portfolio_edit_columns");  
add_action("manage_posts_custom_column",  "jlc_portfolio_custom_columns");  
  
function jlc_portfolio_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => "Project",  
            "description" => "Description",  
            "link" => "Link",  
            "type" => "Type of",  
        );  
  
        return $columns;  
}  
  
function jlc_portfolio_custom_columns($column){  
        global $post;  
        switch ($column)  
        {  
            case "description":  
                the_excerpt();  
                break;  
            case "link":  
                $custom = get_post_custom();  
                echo $custom["projLink"][0];  
                break;  
            case "type":  
                echo get_the_term_list($post->ID, 'type', '', ', ','');  
                break;  
        }  
} 

add_action('init', 'jlc_portfolio_rewrite');

function jlc_portfolio_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->add_permastruct('typename', 'typename/%year%/%postname%/', true, 1);
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$', 'index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}
