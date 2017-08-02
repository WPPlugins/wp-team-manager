<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.dynamicweblab.com/
 * @since      1.0.0
 *
 * @package    Wp_Team_Manager
 * @subpackage Wp_Team_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Team_Manager
 * @subpackage Wp_Team_Manager/admin
 * @author     Maidul <info@dynamicweblab.com>
 */
class Wp_Team_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * register custom post type team manager
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 * @since    1.0.0
	 */
	
	public function register_team_manager()
	{

	    $labels = array( 
	        'name' 				 => __( 'Team', 'wp-team-manager' ),
	        'singular_name' 	 => __( 'Team Member', 'wp-team-manager' ),
	        'add_new'			 => __( 'Add New Member', 'wp-team-manager' ),
	        'add_new_item'  	 => __( 'Add New ', 'wp-team-manager' ),
	        'edit_item'     	 => __( 'Edit Team Member ', 'wp-team-manager' ),
	        'new_item'      	 => __( 'New Team Member', 'wp-team-manager' ),
	        'view_item'          => __( 'View Team Member', 'wp-team-manager' ),
	        'search_items'       => __( 'Search Team Members', 'wp-team-manager' ),
	        'not_found'     	 => __( 'Not found any Team Member', 'wp-team-manager' ),
	        'not_found_in_trash' => __( 'No Team Member found in Trash', 'wp-team-manager' ),
	        'parent_item_colon'  => __( 'Parent Team Member:', 'wp-team-manager' ),
	        'menu_name'          => __( 'Team', 'wp-team-manager' ),
	    );
		
	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,        
	        'supports' => array( 'title', 'thumbnail','editor','page-attributes'),
	        'public' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,       
	        'show_in_nav_menus' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'has_archive' => true,
	        'query_var' => true,
	        'can_export' => true,
	        'rewrite' => true,
	        'capability_type' => 'post',
			'menu_icon' => plugins_url( '/img/icon16.png',__FILE__),
			'rewrite' => array( 'slug' => 'team-details' )

	    );

	    register_post_type( 'team_manager', $args );

	    //register custom category for the team manager

	    $labels = array(
	        'name'                       => __( 'Groups', 'wp-team-manager' ),
	        'singular_name'              => __( 'Group', 'wp-team-manager' ),
	        'search_items'               => __( 'Search Groups', 'wp-team-manager' ),
	        'popular_items'              => __( 'Popular Groups', 'wp-team-manager' ),
	        'all_items'                  => __( 'All Groups', 'wp-team-manager' ),
	        'parent_item'                => null,
	        'parent_item_colon'          => null,
	        'edit_item'                  => __( 'Edit Group', 'wp-team-manager' ),
	        'update_item'                => __( 'Update Group', 'wp-team-manager' ),
	        'add_new_item'               => __( 'Add New Group', 'wp-team-manager' ),
	        'new_item_name'              => __( 'New Group Name', 'wp-team-manager' ),
	        'separate_items_with_commas' => __( 'Separate Groups with commas', 'wp-team-manager' ),
	        'add_or_remove_items'        => __( 'Add or remove Groups', 'wp-team-manager' ),
	        'choose_from_most_used'      => __( 'Choose from the most used Groups', 'wp-team-manager' ),
	        'not_found'                  => __( 'No Groups found.', 'wp-team-manager' ),
	        'menu_name'                  => __( 'Team Groups', 'wp-team-manager' ),
	    );

	    $args = array(
	        'hierarchical'          => true,
	        'labels'                => $labels,
	        'show_ui'               => true,
	        'show_admin_column'     => true,
	        'update_count_callback' => '_update_post_term_count',
	        'query_var'             => true,
	        'rewrite'               => array( 'slug' => 'team_groups' ),
	    );

	    register_taxonomy( 'team_groups', 'team_manager', $args );
	}

	/**
	 * Add custom post meta on team manager post type
     * @author: Rilwis
     * @url: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
	 * @since    1.0.0
	 */	
	public function build_meta_box()
	{

		$prefix = 'tm_';

		$meta_boxes = array();

		$meta_boxes[] = array(
		    'id' => 'team_personal',                         // meta box id, unique per meta box
		    'title' => __('Team Member Information','wp-team-manager'),          // meta box title
		    'pages' => array('team_manager'),  // post types, accept custom post types as well, default is array('post'); optional
		    'context' => 'normal',                      // where the meta box appear: normal (default), advanced, side; optional
		    'priority' => 'high',                       // order of meta box: high (default), low; optional

		    'fields' => array(                          // list of meta fields
		        
		        array(
		            'name' => __('Job Title','wp-team-manager'),                  // field name
		            'desc' => __('Job title of this team member.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'jtitle',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Telephone','wp-team-manager'),                  // field name
		            'desc' => __('Telephone no of this team member.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'telephone',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Location','wp-team-manager'),                // field name
		            'desc' => __('Location of this team member.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'location',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Web URL','wp-team-manager'),                  // field name
		            'desc' => __('Website url of this team member.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'web_url',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),                
		        array(
		            'name' => __('VCARD', 'wp-team-manager'),
		            'desc' => __('Upload your VCARD', 'wp-team-manager'),
		            'id' => $prefix . 'vcard',
		            'type' => 'file'                        // file upload
		        )
		    )
		);

		// first meta box
		$meta_boxes[] = array(
		    'id' => 'team_social',                         // meta box id, unique per meta box
		    'title' => __('Social Profile','wp-team-manager'),          // meta box title
		    'pages' => array('team_manager'),  // post types, accept custom post types as well, default is array('post'); optional
		    'context' => 'normal',                      // where the meta box appear: normal (default), advanced, side; optional
		    'priority' => 'high',                       // order of meta box: high (default), low; optional

		    'fields' => array(                          // list of meta fields
		        
		        array(
		            'name' => __('Facebook','wp-team-manager'),                 // field name
		            'desc' => __('Facebook profile or page link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'flink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Twitter','wp-team-manager'),                  // field name
		            'desc' => __('Twitter profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'tlink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('LinkedIn','wp-team-manager'),                  // field name
		            'desc' => __('LinkedIn profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'llink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Google Plus','wp-team-manager'),                 // field name
		            'desc' => __('Google Plus profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'gplink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Instagram','wp-team-manager'),                 // field name
		            'desc' => __('Instagram link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'instagram',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),		        
		        array(
		            'name' => __('Dribbble','wp-team-manager'),                  // field name
		            'desc' => __('Dribbble profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'dribbble',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),        
		        array(
		            'name' => __('Youtube','wp-team-manager'),                 // field name
		            'desc' => __('Youtube profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'ylink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Vimeo','wp-team-manager'),                  // field name
		            'desc' => __('Vimeo profile link.','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'vlink',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        ),
		        array(
		            'name' => __('Email','wp-team-manager'),                  // field name
		            'desc' => __('Email Id','wp-team-manager'), // field description, optional
		            'id' => $prefix . 'emailid',              // field id, i.e. the meta key
		            'type' => 'text',                       // text box
		            'std' => ''                    // default value, optional
		        )
		    )
		);

		foreach ($meta_boxes as $meta_box) {
    		$wptm_box = new WTM_Meta_Box($meta_box);
		}
	}

	/**
	 * Ajax delete files on the fly. Modified from a function used by "Verve Meta Boxes" plugin 
	 * (http://goo.gl/LzYSq)
	 *
	 * @since    1.0.0
	 */	
	public function rw_delete_file() {
		if (!isset($_POST['data'])) return;
		list($post_id, $key, $attach_id, $src, $nonce) = explode('!', $_POST['data']);
		if (!wp_verify_nonce($nonce, 'rw_ajax_delete_file')) {
			_e('You don\'t have permission to delete this file.');
		}
		wp_delete_attachment($attach_id);
		delete_post_meta($post_id, $key, $src);
		_e('File has been successfully deleted.');
		die();
	}

	/**
	 * Add VCF file type upload support
	 *
	 * @since    1.0.0
	 */	
	public function team_manager_custom_upload_mimes ( $existing_mimes=array() ) {
	    // add your extension to the array
	    $existing_mimes['vcf'] = 'text/x-vcard';
	    return $existing_mimes;
	}	

	/**
	 * Check if the current theme have feature image support.If not then enable the support
	 *
	 * @since 1.0.0
	 * 
	 * 
	 */
	public function tm_add_thumbnail_support() {
	  if(!current_theme_supports('post-thumbnails')) {
	    add_theme_support( 'post-thumbnails', array( 'team_manager' ) );
	  }
	}

	/**
	 * Get feature image from team_manager post type
	 *
	 * @since 1.0
	 *
	 *
	 */
	public function wptm_get_featured_image($post_ID) {
	    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
	    if ($post_thumbnail_id) {
	        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
	        return $post_thumbnail_img[0];
	    }
	}

	/**
	 * Add new feature image column
	 *
	 * @since 1.5
	 *
	 *
	 */
	public function wptm_columns_head($defaults) {
	    $defaults['featured_image'] = __('Featured Image');
	    return $defaults;
	}

	 /**
	 * Show feature image on the admin
	 *
	 * @since 1.5
	 *
	 *
	 */
	public function wptm_columns_content($column_name, $post_ID) {
	    if ($column_name == 'featured_image') {
	        $post_featured_image = $this->wptm_get_featured_image($post_ID);
	        if ($post_featured_image) {
	            echo '<img src="' . $post_featured_image . '" />';
	        }
	    }
	}

	 /**
	 * Show team member id on the admin section
	 *
	 * @since 1.5
	 *
	 *
	 */

	public function team_manager_posts_columns_id($defaults){
	    $defaults['wps_post_id'] = __('ID');
	    return $defaults;
	}

	 /**
	 * Show team member id on the admin section
	 *
	 * @since 1.5
	 *
	 *
	 */	
	public function team_manager_posts_custom_id_columns($column_name, $id){
	  if($column_name === 'wps_post_id'){
	          echo $id;
	    }
	}


	/**
	 * Returns template file
	 * @since 1.6.1
	 */
	 
	public function template_chooser( $template ) {
	 
	    global $wp_query;

	    $post_type = get_query_var('post_type');

	    if( $post_type == 'team_manager' ){

		    // Get the template slug
		    $template_slug = rtrim( $template, '.php' );
		    $template = $template_slug . '.php';
		 
		    // Check if a custom template exists in the theme folder, if not, load the plugin template file
		    
		    $check_theme_file = locate_template( array( 'team_template/' . $template ) ); 

		    if ($check_theme_file) {

		        return $check_theme_file;  
		    
		    }else{

	         return WTM_BASE_DIR . '/public/templates/single-team_manager.php';

		    }

	    }


	    return $template;  

	 
	}

	/**
	 * Add custom css on theme header
	 *
	 * @since 1.0
	 */

	public function add_custom_css()
    {
       echo '<style type="text/css" media="screen">';
       echo get_option('tm_custom_css');
       echo '</style>'; 
    } 
    
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Team_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Team_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tm-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Team_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Team_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-team-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

}
