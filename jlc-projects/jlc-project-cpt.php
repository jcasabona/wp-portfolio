<?php

add_action('init', 'jlc_projects_register');  
  
function jlc_projects_register() {  
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

add_action("admin_init", "jlc_projects_admin_init");  


function jlc_projects_admin_init(){  
    add_meta_box("jlc-projects-meta", __("Project Link"), "jlc_projects_options", "portfolio", "side", "low");  
}  
  

function jlc_projects_options(){  
        global $post;  
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);  
        $link = $custom["jlc_projects_link"][0];  
?>  
    <input name="jlc_projects_link" placeholder="http://" value="<?php echo $link; ?>" />  
<?php  
    }  


 add_action('save_post', 'jlc_projects_save');  
  
function jlc_projects_save(){  
    global $post;  
    
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ 
		return $post_id;
	}else{
    	update_post_meta($post->ID, "jlc_projects_link", $_POST["jlc_projects_link"]); 
    } 
}  
  

add_action('init', 'jlc_projects_rewrite');

function jlc_projects_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->add_permastruct('typename', 'typename/%year%/%postname%/', true, 1);
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$', 'index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}
?>
