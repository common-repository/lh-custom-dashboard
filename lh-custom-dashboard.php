<?php
/**
 * Plugin Name: LH Custom Dashboard
 * Plugin URI: https://lhero.org/portfolio/lh-custom-dashboard/
 * Description: Configurable customisation of your wp dashboard
 * Version: 1.25
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com
 * Text Domain: lh_custom_dashboard
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if (!class_exists('LH_custom_dashboard_plugin')) {

class LH_custom_dashboard_plugin {


private static $instance;

static function return_plugin_namespace(){

    return 'lh_custom_dashboard';

    }
    
static function return_opt_name(){

    return 'lh_custom_dashboard-options';

    }
    
static function return_site_opt_name(){

    return 'lh_custom_dashboard-site_options';

    }
    
static function return_admin_footer_text_field_name(){
    
return 'lh_custom_dashboard-admin_footer_text';    
    
}

static function return_update_footer_text_field_name(){
    
return 'lh_custom_dashboard-update_footer_text'; 
    
}
    
    
static function return_file_name(){

return plugin_basename( __FILE__ );

}

static function return_favicon_field_name(){

return 'lh_custom_dashboard-favicon';

}

static function is_this_plugin_network_activated($path){

if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if ( is_plugin_active_for_network( $path ) ) {
    // Plugin is activated

return true;

} else  {


return false;


}

}

private function return_icon() {
    
    $options = get_option(self::return_opt_name());
    
if (isset($options[self::return_favicon_field_name()]) and wp_get_attachment_url($options[self::return_favicon_field_name()])){

return wp_get_attachment_url($options[self::return_favicon_field_name()]).'#gsd';

} elseif (get_site_icon_url('32')){

return get_site_icon_url('32');


} else {

return false;


}
}

private function return_site_icon() {
    
    $site_options = get_site_option(self::return_site_opt_name());
    
if (isset($site_options[self::return_favicon_field_name()]) && wp_get_attachment_url($site_options[self::return_favicon_field_name()])){
return wp_get_attachment_url($site_options[self::return_favicon_field_name()]);

} else {

return false;


}
}




public function network_plugin_menu() {


add_submenu_page('settings.php', 'Custom Dashboard', 'Custom Dashboard', 'manage_options', self::return_file_name(), array($this,"network_plugin_options"));

}

public function plugin_menu() {
add_options_page('LH Custom Dashboard Options', 'Custom Dashboard', 'manage_options', self::return_file_name(), array($this,"plugin_options"));
}


public function plugin_options() {

$options = get_option(self::return_opt_name());

if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}



 // See if the user has posted us some information
    // If they did, the nonce will be set

	if( isset($_POST[ self::return_plugin_namespace()."-backend_nonce" ]) && wp_verify_nonce($_POST[ self::return_plugin_namespace()."-backend_nonce" ], self::return_plugin_namespace()."-backend_nonce" )) {

if ($_POST[ self::return_favicon_field_name()."-url" ] != ""){

if (get_post_status( sanitize_text_field($_POST[ self::return_favicon_field_name() ]) ) != FALSE ) {

$options[self::return_favicon_field_name()] = sanitize_text_field($_POST[ self::return_favicon_field_name() ]);

}

}


// Read their posted value

if ($_POST[ self::return_admin_footer_text_field_name()] != ""){
$options[self::return_admin_footer_text_field_name()] = sanitize_text_field($_POST[ self::return_admin_footer_text_field_name() ]);
}

if ($_POST[ self::return_update_footer_text_field_name() ] != ""){
$options[self::return_update_footer_text_field_name()] = sanitize_text_field($_POST[ self::return_update_footer_text_field_name ()]);
}

if (update_option( self::return_opt_name(), $options )){



$options = get_option(self::return_opt_name());

        // Put an settings updated message on the screen



?>
<div class="updated"><p><strong><?php _e('Options saved', self::return_plugin_namespace() ); ?></strong></p></div>
<?php

}

    } 

// Now display the settings editing screen


    // Now display the settings editing screen

include ('partials/options-general.php');
    

}

public function network_plugin_options() {
    
    $site_options = get_site_option(self::return_site_opt_name());

if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}


 // See if the user has posted us some information
    // If they did, the nonce will be set

	if( isset($_POST[ self::return_plugin_namespace()."-backend_nonce" ]) && wp_verify_nonce($_POST[ self::return_plugin_namespace()."-backend_nonce" ], self::return_plugin_namespace()."-backend_nonce" )) {

if (isset($_POST[ self::return_favicon_field_name()."-url" ]) && ($_POST[ self::return_favicon_field_name()."-url" ] != "")){

if (get_post_status( sanitize_text_field($_POST[ self::return_favicon_field_name() ]) ) != FALSE ) {

$options[self::return_favicon_field_name()] = sanitize_text_field($_POST[ self::return_favicon_field_name() ]);

}

}


// Read their posted value

if ($_POST[ self::return_admin_footer_text_field_name() ] != ""){
$options[self::return_admin_footer_text_field_name()] = sanitize_text_field($_POST[ self::return_admin_footer_text_field_name() ]);
}

if ($_POST[ self::return_update_footer_text_field_name() ] != ""){
$options[self::return_update_footer_text_field_name()] = sanitize_text_field($_POST[ self::return_update_footer_text_field_name() ]);
}

if (update_site_option( self::return_site_opt_name(), $options )){



$site_options = get_site_option(self::return_site_opt_name());

        // Put an settings updated message on the screen



?>
<div class="updated"><p><strong><?php _e('Options saved', self::return_plugin_namespace() ); ?></strong></p></div>
<?php

}

    } 


// Now display the settings editing screen

include ('partials/settings.php');

	

}

// Prepare the media uploader
public function add_admin_scripts(){

if (isset($_GET['page']) && $_GET['page'] == self::return_file_name()) {
	// must be running 3.5+ to use color pickers and image upload
	wp_enqueue_media();


wp_register_script('lh-custom-dashboard-admin', plugins_url( '/scripts/uploader.js', __FILE__ ), array('jquery','media-upload','thickbox'),'1.1');
wp_enqueue_script('lh-custom-dashboard-admin');

}
}




public function override_left_admin_footer_text_output($er_left) {
    
    $site_options = get_site_option(self::return_site_opt_name());
    
    $options = get_option(self::return_opt_name());

if ( is_network_admin() and isset($site_options[self::return_admin_footer_text_field_name()]) ) {

return $site_options[self::return_admin_footer_text_field_name()];

} elseif (isset($options[self::return_admin_footer_text_field_name()])) {

return $options[self::return_admin_footer_text_field_name()];


} else {
  
  
 return false; 
  
}

}

public function override_right_admin_footer_text_output($er_right) {
    
    $site_options = get_site_option(self::return_site_opt_name());
    
    $options = get_option(self::return_opt_name());


if ( is_network_admin() && isset($site_options[self::return_update_footer_text_field_name()]) ) {


return $site_options[self::return_update_footer_text_field_name()];

} elseif (isset($options[self::return_update_footer_text_field_name()])){
            
return $options[self::return_update_footer_text_field_name()];

} else {
 
 return false; 
  
}


}

function hide_update_notice_to_all_but_admin_users() {
    if (!current_user_can('update_core')) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}

function override_dashboard_adminbar_icon(){


        echo " \n\n <style type=\"text/css\">#wp-admin-bar-wp-logo { display:none; } #wpadminbar #wp-admin-bar-site-name > .ab-item:before { content: normal;}</style> \n\n";

if ($this->return_icon()){

if ( is_network_admin() ) {


        echo '<script type="text/javascript"> jQuery(document).ready(function(){ ';
        echo  'jQuery("#wp-admin-bar-root-default").prepend(" <li id=\"wlcms_admin_logo\"> <span style=\"float:left;height:28px;line-height:28px;vertical-align:middle;text-align:center;width:28px\"><img src=\"'.$this->return_site_icon().'\" width=\"16\" height=\"16\" alt=\"Login\" style=\"height:16px;width:16px;vertical-align:middle\" /> </span> </li> "); ';
		echo '  }); ';
        echo '</script> ';




} else {

        echo '<script type="text/javascript"> jQuery(document).ready(function(){ ';
        echo  'jQuery("#wp-admin-bar-root-default").prepend(" <li id=\"wlcms_admin_logo\"> <span style=\"float:left;height:28px;line-height:28px;vertical-align:middle;text-align:center;width:28px\"><img src=\"'.$this->return_icon().'\" width=\"16\" height=\"16\" alt=\"Login\" style=\"height:16px;width:16px;vertical-align:middle\" /> </span> </li> "); ';
		echo '  }); ';
        echo '</script> ';


echo '<link rel="icon" href="'.$this->return_icon().'" />';

}



}

  
}

// add a settings link next to deactive / edit
public function add_settings_link( $links, $file ) {

	if( $file == self::return_file_name() ){
		$links[] = '<a href="'. admin_url( 'options-general.php?page=' ).self::return_file_name().'">Settings</a>';
	}
	return $links;
}


// add a settings link next to deactive / edit
public function add_network_settings_link( $links, $file ) {

	if ( $file == self::return_file_name()){

$links[] = '<a href="'.  network_admin_url( 'settings.php?page=' ).self::return_file_name().'">Settings</a>';


}

return $links;
}


public function add_site_icon_sizes($sizes) {
    $sizes[] = 16;
    $sizes[] = 32;

    return $sizes;
}


public function remove_metatags($meta_tags) {
    
    
    if ( is_network_admin() ) {
 $return = array();
 
 foreach( $meta_tags as $meta_tag ) {
     
     if (strpos($meta_tag, 'icon') !== false) {
         
     } else {
         
      $return[] = $meta_tag;  
         
     }
     
     }
     
     return $return;
     
    } else {
        
        
     return $meta_tags;   
        
    }
}


public function maybe_add_icon_link(){
    
    if ( is_network_admin() ) {
        
        echo "<link rel=\"icon\" href=\"".$this->return_site_icon()."\" />\n";
        
    }
    
    
    
}



    /**
	 * Add Favicon from each blog to Multisite Menu of "My Sites".
	 *
	 * 
	 */
	public function set_admin_bar_blog_icon() {

		// Only usable if the user is logged in and use the admin bar.
		if ( ! is_user_logged_in() || ! is_admin_bar_showing() ) {
			return;
		}

		$user_id    = get_current_user_id();
		$user_blogs = get_blogs_of_user( $user_id );

		$output = '';
		foreach ( (array) $user_blogs as $blog ) {
			$custom_icon = false;

			// Validate, that we use nly int value.
			$blog_id    = (int) $blog->userblog_id;

			// Check if the user has manually added a site icon in WP (since WP 4.3).
		

				switch_to_blog( $blog_id );
				$custom_icon = $this->return_icon();
				restore_current_blog();
	

			if ( false !== $custom_icon ) {
				$output .= '#wpadminbar .quicklinks li#wp-admin-bar-blog-' . $blog_id
				. ' .blavatar { font-size: 0 !important; }';
				$output .= '#wp-admin-bar-blog-' . $blog_id
				. ' div.blavatar { background: url( "' . $custom_icon
				. '" ) left bottom/16px no-repeat !important; background-size: 16px !important; margin: 0 2px 0 -2px; }' . "\n";
			}
		}

		if ( '' !== $output ) {
			/**
			 * Use the filter hook to change style.
			 *
			 * @type string
			 */
			echo apply_filters(
				self::return_plugin_namespace().'_add_admin_bar_favicon',
				"\n" . '<style>' . $output . '</style>' . "\n"
			);
		}
	}
	
	public function get_blog_id( $column_name, $blog_id ) {
		
		if ( 'object_id' === $column_name )
			echo (int) $blog_id;
		
		return $column_name;
	}
	

	
	// Add in a column header
	public function show_blog_id( $columns ) {
		
		$columns['object_id'] = __('Site ID');
		
		return $columns;
	}
	


public function plugin_init(){
    
    
    add_filter('admin_footer_text', array($this,"override_left_admin_footer_text_output"),11); //left side
add_filter('update_footer', array($this,"override_right_admin_footer_text_output"),11); //right side
add_action( 'admin_head', array($this,"hide_update_notice_to_all_but_admin_users"));
add_action('admin_menu', array($this,"plugin_menu"));
add_action('admin_enqueue_scripts', array($this,"add_admin_scripts"));
add_action('wp_before_admin_bar_render', array($this,"override_dashboard_adminbar_icon"));
add_filter('plugin_action_links', array($this,"add_settings_link"), 10, 2);

add_filter('site_icon_image_sizes', array($this,"add_site_icon_sizes"), 10, 1);


//remove redundant theme meta tags
add_filter('site_icon_meta_tags', array($this,"remove_metatags"));

//maybe add the link icon meta data
add_action( 'admin_head', array($this,"maybe_add_icon_link"));


if ( self::is_this_plugin_network_activated("lh-custom-dashboard/lh-custom-dashboard.php") ) {
add_action('network_admin_menu', array($this,"network_plugin_menu"));
add_filter('network_admin_plugin_action_links_'.plugin_basename( __FILE__ ), array($this,"add_network_settings_link"), 10, 2);


//add a favicon in the sites dropdown
add_action( 'admin_head', array($this,"set_admin_bar_blog_icon"));
add_action( 'wp_head', array($this,"set_admin_bar_blog_icon"));

		// add blog id
add_filter( 'wpmu_blogs_columns', array( $this, 'show_blog_id' ) );
add_action( 'manage_sites_custom_column', array( $this, 'get_blog_id' ), 10, 2 );

} 


    

    
    
}

    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }

public function __construct() {

    	 //run our hooks on plugins loaded to as we may need checks       
    add_action( 'plugins_loaded', array($this,'plugin_init'));



}

}

$lh_custom_dashboard = LH_custom_dashboard_plugin::get_instance();

}


?>