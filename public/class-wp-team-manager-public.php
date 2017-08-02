<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.dynamicweblab.com/
 * @since      1.0.0
 *
 * @package    Wp_Team_Manager
 * @subpackage Wp_Team_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Team_Manager
 * @subpackage Wp_Team_Manager/public
 * @author     Maidul <info@dynamicweblab.com>
 */
class Wp_Team_Manager_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( 'team_manager', array($this, 'shortcode') );
		add_filter('widget_text', 'do_shortcode' );

	}

	/**
	 * Team manager short code [team_manager]
	 *
	 * @since    1.0.0
	 */
	
	public function shortcode($atts)
	{
		
	   extract( shortcode_atts( array(
	      'team_groups' => '',
	      'orderby' => 'menu_order',
	      'layout' => '',
	      'image_layout' => 'rounded',
	      'image_size' => 'thumbnail',
	      'post__in'   => '',
	    ), $atts ) );

		global $_wp_additional_image_sizes;
		
	    // get social settings
	    $social_size = get_option('tm_social_size');
	    // get link new window settings
	    $tm_link_new_window = get_option('tm_link_new_window');
	    // get link new window settings
	    $single_team_member_view = get_option('single_team_member_view');    
	    // get custom template
	    $tm_custom_template = get_option('tm_custom_template');

	    //If there is no tm_social_size then load default
	    if (!$social_size) {
	      $social_size=16;
	    }
	    
	    //If there is no tm_custom_template then load default

	    if (!$tm_custom_template) {

	      $tm_custom_template='<div class="%layout%">
	    <div class="team-member-info">
	    %image%
	     %sociallinks%
	    </div><div class="team-member-des">
	    <h2 class="team-title">%title%</h2>
	    <h4 class="team-position">%jobtitle%</h4>
	    %content%
	    %otherinfo%
	    </div>
	    </div>';
	      
	    }
	    	$asc_desc = 'DESC';

	    	$posts_per_page = -1;
	    
	    	
	    	if($tm_link_new_window=='True'){
			
				$link_window = 'target="_blank"';
			
			}else{
				
				$link_window = '';
				
			}	


		    if ( $atts['orderby'] == 'title' || $atts['orderby'] == 'menu_order' ) {

		      $asc_desc = 'ASC';

		    }

		    
		    if($atts['limit'] >= 1) { 

		    $posts_per_page = $atts['limit'];

		    } 

		    $layout = isset($atts['layout']) ? $atts['layout'] : 'list';
		    $image_layout = isset($atts['image_layout']) ? $atts['image_layout'] : ''; 
		    $image_size = isset($atts['image_size']) ? $atts['image_size'] : '';   

		    $args = array( 
		             'post_type' => 'team_manager',
		             'team_groups'=> $atts['category'] ,  
		             'posts_per_page'=> $posts_per_page, 
		             'orderby' => $atts['orderby'], 
		             'order' => $asc_desc
		             ); 

		           if(!empty($atts['exclude'])) {	

		           $postnotarray = explode(',', $atts['exclude']);

		           if(!empty($postnotarray)) {

		            $args['post__not_in'] = $postnotarray;

		            }

		          }

		          if(!empty($atts['post__in'])) {

		           $postarray = explode(',', $atts['post__in']);

		           if(!empty($postarray)) {

		            $args['post__in'] = $postarray;

		            }

		          }    

		    $tm_loop = new WP_Query( $args );      

		    // The Loop
		    if ( $tm_loop->have_posts() ) { 
		      $output = '';    
		      $output .= '<div class="team-list">';
		      while ( $tm_loop->have_posts() ) {
		        $tm_loop->the_post();

		        $post_id = get_the_ID();
		        $title = get_the_title();
		        $content = get_the_content();
		        $content = apply_filters('the_content', $content);
		        $content = str_replace(']]>', ']]&gt;', $content);        

		        if (is_array($_wp_additional_image_sizes) && array_key_exists($image_size, $_wp_additional_image_sizes)){
		          
		          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );   
		        
		        }else{
		          
		          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );   
		        
		        }          
		        
		        $width = $image[1];

		        $details_start = '<a href="'.get_permalink().'">';
		        $details_end = '</a>';

		        if (!empty($single_team_member_view)) {

		          $details_start=$details_end='';

		        }


		        if (isset($image[0])) {
		          
		          $image = "$details_start<img class='team-picture ".$image_layout."' src='".$image[0]."' width='".$width."' title='".$title."' />$details_end";
		        
		        }else{
		          
		          $image = "$details_start<img class='team-picture ".$image_layout."' src='".plugins_url( 'img/demo.gif',__FILE__)."' width='150' title='".$title."' />$details_end";
		        
		        }

		        $job_title = get_post_meta($post_id,'tm_jtitle',true);
		        $telephone = get_post_meta($post_id,'tm_telephone',true);
		        $location = get_post_meta($post_id,'tm_location',true);
		        $web_url = get_post_meta($post_id,'tm_web_url',true);
		        $vcard = get_post_meta($post_id,'tm_vcard',true);
		        $facebook = get_post_meta($post_id,'tm_flink',true);
		        $twitter = get_post_meta($post_id,'tm_tlink',true);
		        $linkedIn = get_post_meta($post_id,'tm_llink',true);
		        $googleplus = get_post_meta($post_id,'tm_gplink',true);
		        $dribbble = get_post_meta($post_id,'tm_dribbble',true);
		        $youtube = get_post_meta($post_id,'tm_ylink',true);
		        $vimeo = get_post_meta($post_id,'tm_vlink',true);
		        $instagram = get_post_meta($post_id,'tm_instagram',true);
		        $emailid = get_post_meta($post_id,'tm_emailid',true);
		          

		        $sociallinks = '<ul class="team-member-socials size-'.$social_size.'">';
		        if (!empty($facebook)) {
		          $sociallinks .= '<li><a class="facebook-'.$social_size.'" href="' . $facebook. '" '.$link_window.' title="Facebook">Facebook</a></li>';
		        }
		        if (!empty($twitter)) {
		          $sociallinks .= '<li><a class="twitter-'.$social_size.'" href="' . $twitter. '" '.$link_window.' title="Twitter">Twitter</a></li>';
		        }
		        if (!empty($linkedIn)) {
		          $sociallinks .= '<li><a class="linkedIn-'.$social_size.'" href="' . $linkedIn. '" '.$link_window.' title="LinkedIn">LinkedIn</a></li>';
		        }
		        if (!empty($googleplus)) {
		          $sociallinks .= '<li><a class="googleplus-'.$social_size.'" href="' . $googleplus. '" '.$link_window.' title="Google Plus">Google Plus</a></li>';
		        }
		        if (!empty($instagram)) {
		          $sociallinks .= '<li><a class="instagram-'.$social_size.'" href="' . $instagram. '" '.$link_window.' title="Instagram">Instagram</a></li>';
		        }		        
		        if (!empty($dribbble)) {
		          $sociallinks .= '<li><a class="dribbble-'.$social_size.'" href="' . $dribbble. '" '.$link_window.' title="Dribbble">Dribbble</a></li>';
		        }        
		        if (!empty($youtube)) {
		          $sociallinks .= '<li><a class="youtube-'.$social_size.'" href="' . $youtube. '" '.$link_window.' title="Youtube">Youtube</a></li>';
		        }
		        if (!empty($vimeo)) {
		          $sociallinks .= '<li><a class="vimeo-'.$social_size.'" href="' . $vimeo. '" '.$link_window.' title="Vimeo">Vimeo</a></li>';
		        }		        
		        if (!empty($emailid)) {
		          $sociallinks .= '<li><a class="emailid-'.$social_size.'" href="mailto:' . $emailid. '" title="Email">Email</a></li>';
		        }                                                        
		        $sociallinks .= '</ul>';


		        $otherinfo = '<ul class="team-member-other-info">';
		        if (!empty($telephone)) {
		          $otherinfo .= '<li><span> '.__('Tel:','wp-team-manager').' </span><a href="tel://'.$telephone.'">'.$telephone.'</a></li>';
		        }
		        if (!empty($location)) {
		          $otherinfo .= '<li><span> '.__('Location:','wp-team-manager').' </span>'.$location.'</li>';
		        }
		        if (!empty($web_url)) {
		          $otherinfo .= '<li><span> '.__('Website:','wp-team-manager').' </span><a href="'.$web_url.'" target="_blank">Link</a></li>';
		        }
		        if (!empty($vcard)) {
		          $otherinfo .= '<li><span> '.__('Vcard:','wp-team-manager').' </span><a href="'.$vcard.'" >Download</a></li>';
		        }                                               
		        $otherinfo .= '</ul>';


		        $find = array('/%layout%/i','/%title%/i', '/%content%/i', '/%image%/i','/%jobtitle%/i','/%otherinfo%/i','/%sociallinks%/i');
		        
		        $replace = array($layout,$title, $content,$image,$job_title,$otherinfo,$sociallinks);
		        
		        $output .= preg_replace($find, $replace, $tm_custom_template);

		      }
		        $output .= '</div>';

		    } else {
		      // no posts found
		    }
		    /* Restore original Post Data */
		    wp_reset_postdata();

		    return $output;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tm-style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-team-manager-public.js', array( 'jquery' ), $this->version, false );

	}

}
