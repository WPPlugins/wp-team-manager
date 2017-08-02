<?php
/**
 * Create settings page for team manager post type
 *
 *
 * @author: Maidul
 * @version: 1.0.0
 */
class TeamManagerSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "team manger"
        add_submenu_page(
            'edit.php?post_type=team_manager',
            'Settings Team Manger', 
            'Team Settings', 
            'manage_options', 
            'team_manager', 
            array( $this, 'create_admin_page' )
        );
        add_submenu_page(
            'edit.php?post_type=team_manager',
            'Shortcode Generator', 
            'Shortcode Generator', 
            'manage_options', 
            'team-manager-shortcode-generator', 
            array( $this, 'create_admin_shortcode_generator' )
        );        
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

        ?>
        <div class="wrap">
            <h2><?php _e('Team Manager settings', 'wp-team-manager'); ?></h2> 
            <?php settings_errors(); ?>      
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'tm-settings-group' );   
                do_settings_sections( 'tm-settings-group' );
            ?>

		    <?php 
		    $tm_social_size = get_option('tm_social_size');
		    $tm_custom_css = get_option('tm_custom_css');
		    $tm_link_new_window = get_option('tm_link_new_window');
		    $single_team_member_view = get_option('single_team_member_view');
		    $tm_custom_template = get_option('tm_custom_template');
		    if (empty($tm_custom_template)) {
		    $tm_custom_template='
		    <div class="%layout%">
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
		     ?>
		    <table class="form-table">
		        <tr valign="top">
		        <th scope="row"><label><?php _e('Social icon size','wp-team-manager'); ?></label></th>
		        <td>
					<select name="tm_social_size" id="tm_social_size">
						<option <?php if($tm_social_size==16){ echo 'selected';} ?> value="16">16 px</option>
						<option <?php if($tm_social_size==32){ echo 'selected';} ?> value="32">32 px</option>  
					</select>
		        </td>
		        </tr>
		        <tr valign="top">
		        <th scope="row"><label><?php _e('Open social links on new window','wp-team-manager'); ?></label></th>
		        <td>
						<input type="checkbox" name="tm_link_new_window" value="True" <?php if($tm_link_new_window=='True'){ echo 'checked';} ?>> Yes
		        </td>
		        </tr>               
		         
		        <tr valign="top">
		        <th scope="row"><label><?php _e('Disable single team member view','wp-team-manager'); ?></label></th>
		        <td>
		        <input type="checkbox" name="single_team_member_view" value="True" <?php if($single_team_member_view=='True'){ echo 'checked';} ?>> Yes
		        </td>
		        </tr> 


		    </table>

		    <!-- Template -->
		    <h3 class="wptm_title"><?php _e('HTML Template', 'wp-team-manager'); ?></h3>
		    <p><?php _e('Edit the HTML template if you want to customize it.', 'wp-team-manager'); ?></p>
		    <p><?php _e('Here is the list of available tags.', 'wp-team-manager'); ?></p>
		    <p><?php _e('<code>%title%</code> , <code>%content%</code> , <code>%image%</code>, <code>%sociallinks%</code>, <code>%jobtitle%</code>, <code>%%otherinfo%%</code>', 'wp-team-manager'); ?></p>
		    <textarea name="tm_custom_template" id="tm_custom_template" class="wp-editor-area" rows="10" cols="80"><?php echo $tm_custom_template; ?></textarea>

		    <!-- Custom CSS -->
		    <h3 class="wptm_title"><?php _e('CSS', 'wp-team-manager'); ?></h3>
		    <p><?php _e('Add custom CSS for Team Manager', 'wp-team-manager'); ?></p>
		    <textarea name="tm_custom_css" id="tm_custom_css" class="wp-editor-area" rows="10" cols="80"><?php echo $tm_custom_css; ?></textarea>  

            <?php submit_button(); ?>
            </form>

        <!-- Support -->
        <div id="wptm_support">
            <h3><?php _e('Support & bug report', 'wp-team-manager'); ?></h3>
            <p><?php printf(__('If you have some idea to improve this plugin or any bug to report, please email me at : <a href="%1$s">%2$s</a>', 'wp-team-manager'), 'mailto:info@dynamicweblab.com?subject=[wp-team-manager]', 'info@dynamicweblab.com'); ?></p>
            <p><?php printf(__('You like this plugin ? Then please provide some support by <a href="%1$s" target="_blank">voting for it</a> and/or says that <a href="%2$s" target="_blank">it works</a> for your WordPress installation on the official WordPress plugins repository.', 'wp-team-manager'), 'http://wordpress.org/plugins/wp-team-manager/', 'http://wordpress.org/plugins/wp-team-manager/'); ?></p>
        </div>

        </div>
        <?php
    }


    /**
     * Options page callback
     */
    public function create_admin_shortcode_generator()
    {
        ?>
    <div class="wrap"><div id="icon-tools" class="icon32"></div>
        <h2><?php _e('Shortcode Generator','wp-team-manager'); ?></h2>
        <div id="shortcode_options_wrapper">
          <form id="tm_short_code">
            <p><label for="cat"><?php _e('Select Team Group:','wp-team-manager'); ?> </label>
              <select name="tm_cat" id="tm_cat">
                          
               <option value="0">All Group</option>
              <?php 
    
               $terms = get_terms("team_groups");
               $count = count($terms);
               if ( $count > 0 ){
                 
                 foreach ( $terms as $term ) {
                    echo "<option value='".$term->slug."'>".$term->name."</option>";
                   }
                 
                 }
            
            ?> 
            </select>              
            </p>
            <p>
                <label for="tm_orderby"><?php _e('Order By:','wp-team-manager'); ?></label>
                <select id="tm_orderby" name="tm_orderby">
                  <option value="menu_order">Default</option>
                  <option value="title">Name</option>
                  <option value="ID">ID</option>
                  <option value="date">Date</option>
                  <option value="modified">Modified</option>
                  <option value="rand">Random</option>
                </select>
              </p>
              <p><label for="tm_limit"><?php _e('Number of entries to display:','wp-team-manager'); ?> </label><input id="tm_limit" type="number" value="0"></p>
               <p><label for="tm_show_id">Show this ids only (Example: 1,2,3): </label><input id="tm_show_id" type="text" value=""></p>
               <p><label for="tm_remove_id">Remove ids from list (Example: 1,5,7): </label><input id="tm_remove_id" type="text" value=""></p>
             <p>
                <label for="tm_layout"><?php _e('Select template:','wp-team-manager'); ?></label>
                <select id="tm_layout" name="tm_layout">
                  <option value="grid">Grid</option>
                  <option value="list">List</option>
                </select>
              </p>
             <p>
                <label for="tm_image_layout"><?php _e('Select image style:','wp-team-manager'); ?></label>
                <select id="tm_image_layout" name="tm_layout">
                  <option value="rounded">Rounded</option>
                  <option value="circle">Circle</option>
                  <option value="boxed">Boxed</option>
                </select>
              </p>
             <p>
                <label for="tm_image_size"><?php _e('Select image size:','wp-team-manager'); ?></label>
                <?php global $_wp_additional_image_sizes; ?>
                <select id="tm_image_size" name="tm_image_size">
                  <option value="thumbnail">thumbnail</option>
                  <?php foreach ($_wp_additional_image_sizes as $size_name => $size_attrs): ?>
                    <option value="<?php echo esc_attr( $size_name ); ?>"><?php echo esc_html( $size_name ) ; ?></option>
                  <?php endforeach; ?>
                </select>
              </p>                          
            </div>
            <div id="shortcode_output_box">[team_manager category='0' orderby='menu_order' limit='0' post__in='' exclude='' layout='grid' image_layout='rounded' image_size='thumbnail']</div>
        </form> 

    </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'tm-settings-group', // Option group
            'tm_social_size' // Option name
        );

        register_setting(
            'tm-settings-group', // Option group
            'tm_link_new_window' // Option name
        );

        register_setting(
            'tm-settings-group', // Option group
            'single_team_member_view' // Option name
        );

        register_setting(
            'tm-settings-group', // Option group
            'tm_custom_css' // Option name
        );                

        register_setting(
            'tm-settings-group', // Option group
            'tm_custom_template' // Option name
        ); 

    }

}

if( is_admin() )
    $teamManagerSettingsPage = new TeamManagerSettingsPage();