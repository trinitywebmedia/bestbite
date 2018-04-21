<?php

/**
 * ZP Theme Settings
 */
 
 // Constant
 define( 'ZP_SETTINGS_FIELD', 'zp-settings' );
 
 
/**
 * Setup default options
 */

/**
 * zpsettings_default_theme_options function.
 */
function zpsettings_default_theme_options() {
	$options = array(
		'zp_welcome_enable' => 1,
		'zp_welcome_message' => __( 'This is the welcome message section','single' ),
		'zp_front_enable' => 1,
		'zp_home_portfolio_items' => 8,
		'zp_home_portfolio_columns' => 4,
		'zp_home_portfolio_title' => __( 'Latest Portfolio','single' ),
		'zp_home_portfolio_desc' => '',
		'zp_home_portfolio_filter' => 1,
		'zp_latest_blog_enable' => 1,
		'zp_latest_blog_title' => __( 'Latest Blog','single' ),
		'zp_latest_blog_desc' => __( 'This is a blog description.','single' ),
		'zp_latest_blog_items' => 6,
		'zp_home_blog_columns' => '3',
		'zp_latest_blog_category' => '',
		'zp_color_scheme' => 'default',
		'zp_css_code' => '',
		'zp_enable_inner_slider' => 1,
		'zp_slider_enable' 	=> 1,
		'zp_slider_height' 	=> 600,
		'zp_animation' 	=> 'slide',
		'zp_slider_speed' 	=> 6000,
		'zp_animation_duration' 	=> 7000,
		'zp_control_nav' 	=> 'true',
		'zp_direction_nav' 	=> 'true',
		'zp_pauseonaction' 	=> 'true',
		'zp_pauseonhover' 	=> 'true',
		'zp_logo' => '',
		'zp_logo_height' => 64,
		'zp_logo_width' => 180,
		'zp_footer_text' 	=> '',
		'zp_portfolio_section_bg' => '',
		'zp_services_section_bg' =>  '',
		'zp_testimonial_section_bg' =>  '',
		'zp_footer_section_bg' =>  ''
	);
	return apply_filters( 'zpsettings_default_theme_options', $options );
}

/**
 * Sanitize any inputs
 */
 add_action( 'genesis_settings_sanitizer_init', 'zpsettings_sanitize_inputs' );
 
 /**
 * zpsettings_sanitize_inputs function.
 *
 */
 function zpsettings_sanitize_inputs() {
	 genesis_add_option_filter( 'one_zero',
	 	ZP_SETTINGS_FIELD,
			array(
				'zp_slider_enable',
				'zp_enable_inner_slider',
				'zp_home_portfolio_filter',
				'zp_latest_blog_enable',
				'zp_front_enable',
				'zp_welcome_enable'
			)
		);
	
	genesis_add_option_filter( 'no_html',
		ZP_SETTINGS_FIELD,
			array(
				'zp_home_portfolio_title',
				'zp_home_portfolio_desc',
				'zp_latest_blog_title',
				'zp_home_portfolio_items',
				'zp_latest_blog_items',
				'zp_slider_height',
				'zp_slider_speed',
				'zp_animation_duration',
				'zp_num_portfolio_items',
				'zp_logo_height',
				'zp_logo_height',
				'zp_logo',
				'zp_home_blog_columns'
			)
	);
	genesis_add_option_filter( 'requires_unfiltered_html',
		ZP_SETTINGS_FIELD,
			array(
				'zp_welcome_message',
				'zp_latest_blog_desc',
				'zp_footer_text',
				'zp_logo_upload'
			)
		);
}

/**
 * Register our settings and add the options to the database
 */

add_action( 'admin_init', 'zpsettings_register_settings' );

/**
 * zpsettings_register_settings function.
 *
 */
function zpsettings_register_settings() {
	register_setting( ZP_SETTINGS_FIELD, ZP_SETTINGS_FIELD );
	add_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
	
	if ( genesis_get_option( 'reset', ZP_SETTINGS_FIELD ) ) {
		update_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
		genesis_admin_redirect( ZP_SETTINGS_FIELD, array( 'reset' => 'true' ) );
		exit;
	}
}

/**
 * Admin notices for when options are saved/reset
 */
 add_action( 'admin_notices', 'zpsettings_theme_settings_notice' );
 
 /**
 * zpsettings_theme_settings_notice function.
 */
 function zpsettings_theme_settings_notice() {
	 if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != ZP_SETTINGS_FIELD )
	 	return;
	if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings reset.', 'single' ) . '</strong></p></div>';
	elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings saved.', 'single' ) . '</strong></p></div>';
 }

/**
 * Register our theme options page
 */
 add_action( 'admin_menu', 'zpsettings_theme_options' );
 
 /**
 * zpsettings_theme_options function.
 */
 function zpsettings_theme_options() {
	 global $_zpsettings_settings_pagehook;
	 $_zpsettings_settings_pagehook = add_submenu_page( 'genesis', 'Single Settings', 'Single Settings', 'edit_theme_options', ZP_SETTINGS_FIELD, 'zpsettings_theme_options_page' );
	 //add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_styles' );
	 add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_scripts' );
	 add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_boxes' );
 }

/**
 * Setup our scripts
 *
 * zpsettings_settings_scripts function.
 * This function enqueues the scripts needed for the ZP Settings settings page.
 */
function zpsettings_settings_scripts() {
	global $_zpsettings_settings_pagehook;
	
	if( is_admin() ){
		wp_register_script( 'zp_image_upload', get_stylesheet_directory_uri() .'/include/upload/image-upload.js', array('jquery','media-upload','thickbox') );
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('zp_image_upload');
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_media( array() );
	}
}

/**
 * Setup our metaboxes
 *
 * zpsettings_settings_boxes function.
 *
 * This function sets up the metaboxes to be populated by their respective callback functions.
 */
function zpsettings_settings_boxes() {
	global $_zpsettings_settings_pagehook;
	
	add_meta_box( 'zpsettings_home_welcome', __( 'Home Welcome Message', 'single' ), 'zpsettings_home_welcome', $_zpsettings_settings_pagehook, 'main', 'high' );
	add_meta_box( 'zpsettings_section_settings', __( 'Section Settings', 'single' ), 'zpsettings_section_settings', $_zpsettings_settings_pagehook, 'main', 'high' );
	add_meta_box( 'zpsettings_home_portfolio', __( 'Home Portfolio Settings', 'single' ), 'zpsettings_home_portfolio', $_zpsettings_settings_pagehook, 'main', 'high' );
	add_meta_box( 'zpsettings_home_blog', __( 'Home Blog Settings', 'single' ), 'zpsettings_home_blog', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_slideshow_settings', __( 'Slideshow Settings', 'single' ), 'zpsettings_slideshow_settings', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_appearance_settings', __( 'Appearance Settings', 'single' ), 'zpsettings_appearance_settings', $_zpsettings_settings_pagehook, 'main' ,'high');
	add_meta_box( 'zpsettings_footer_settings', __( 'Footer Settings', 'single' ), 'zpsettings_footer_settings', $_zpsettings_settings_pagehook, 'main','high' );
}

/**
 * Add our custom post metabox for social sharing
 *
 * zpsettings_home_settings function.
 *
 * Callback function for the ZP Settings Social Sharing metabox.
 *
 */
function zpsettings_home_welcome(){?>
<p><input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_enable]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_enable]" value="1" <?php checked( 1, genesis_get_option( 'zp_welcome_enable', ZP_SETTINGS_FIELD ) ); ?> /><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_enable]"><?php _e( 'Check to enable welcome message.', 'single' ); ?></label></p><p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_message]"><?php _e( 'Welcome Message', 'single' ); ?><br><textarea class="widefat" rows="3" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_message]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_welcome_message]"><?php echo genesis_get_option( 'zp_welcome_message', ZP_SETTINGS_FIELD ); ?></textarea></label></p><?php
}

function zpsettings_section_settings(){?>
<h4><?php _e( 'Portfolio Section ', 'single' );?></h4>
<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_section_bg]"><?php _e( 'Upload Image.', 'single' ); ?></label>
<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_section_bg]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_portfolio_section_bg]" value="<?php echo  genesis_get_option( 'zp_portfolio_section_bg', ZP_SETTINGS_FIELD ); ?>" />    
<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Image', 'single' ); ?>" /> 
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Image', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_portfolio_section_bg', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>


<hr class="div">
<h4>
  <?php _e( 'Services Section ', 'single' );?>
</h4>
<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_services_section_bg]"><?php _e( 'Upload Image.', 'single' ); ?></label>
<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_services_section_bg]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_services_section_bg]" value="<?php echo  genesis_get_option( 'zp_services_section_bg', ZP_SETTINGS_FIELD ); ?>" />    
<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Image', 'single' ); ?>" /> 
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Image', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_services_section_bg', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>
<hr class="div">
<h4>
  <?php _e( 'Testimonial Section ', 'single' );?>
</h4>
<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_testimonial_section_bg]"><?php _e( 'Upload Image.', 'single' ); ?></label>
<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_testimonial_section_bg]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_testimonial_section_bg]" value="<?php echo  genesis_get_option( 'zp_testimonial_section_bg', ZP_SETTINGS_FIELD ); ?>" />    
<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Image', 'single' ); ?>" /> 
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Image', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_testimonial_section_bg', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>

<hr class="div">
<h4>
  <?php _e( 'Footer Section ', 'single' );?>
</h4>
<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_section_bg]"><?php _e( 'Upload Image.', 'single' ); ?></label>
<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_section_bg]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_section_bg]" value="<?php echo  genesis_get_option( 'zp_footer_section_bg', ZP_SETTINGS_FIELD ); ?>" />    
<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_image_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Image', 'single' ); ?>" /> 
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Image', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_footer_section_bg', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>
<hr class="div">
<?php
}

 

function zpsettings_home_portfolio() { ?>
<p>
  <input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_front_enable]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_front_enable]" value="1" <?php checked( 1, genesis_get_option( 'zp_front_enable', ZP_SETTINGS_FIELD ) ); ?> />
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_front_enable]">
    <?php _e( 'Check to enable Portfolio on the home page.', 'single' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_title]">
    <?php _e( 'Home Portfolio Title','single' )?>
  </label>
  <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_home_portfolio_title', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_title]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_title]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_columns]">
    <?php _e( 'Portfolio Columns:','single' );?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_columns]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_portfolio_columns]">
    <option value="2" <?php selected( genesis_get_option( 'zp_home_portfolio_columns', ZP_SETTINGS_FIELD ), '2' ); ?>>Two Columns</option>
    <option  value="3" <?php selected( genesis_get_option( 'zp_home_portfolio_columns', ZP_SETTINGS_FIELD ), '3' ); ?>>Three Columns</option>
    <option  value="4" <?php selected( genesis_get_option( 'zp_home_portfolio_columns', ZP_SETTINGS_FIELD ), '4' ); ?>>Four Columns</option>
  </select>
</p>
<p><span class="description">
  <?php _e( 'This settings applies to the home page portfolio section.','single' ) ?>
  </span></p>
<?php }
 

function zpsettings_home_blog() { ?>
<p>
  <input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_enable]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_enable]" value="1" <?php checked( 1, genesis_get_option( 'zp_latest_blog_enable', ZP_SETTINGS_FIELD ) ); ?> />
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_enable]">
    <?php _e( 'Check to enable homepage latest blog section..', 'single' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_title]">
    <?php _e( 'Latest Blog Title', 'single' ); ?>
  </label>
  <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_latest_blog_title', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_title]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_title]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_items]">
    <?php _e( 'Number of Latest Blog', 'single' ); ?>
  </label>
  <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_latest_blog_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_items]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_category]">
    <?php _e( 'Select Blog Category', 'single' ); ?>
  </label>
  <select name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_category]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_latest_blog_category]">
    <option value="">
    <?php _e( 'Default', 'genesis' ); ?>
    </option>
    <?php

				$of_categories_obj = get_categories('hide_empty=0');

				foreach ($of_categories_obj as $of_cat) {

                    ?>
    <option value="<?php echo $of_cat->slug; ?>" <?php selected( genesis_get_option( 'zp_latest_blog_category', ZP_SETTINGS_FIELD ), $of_cat->slug ); ?> > <?php echo $of_cat->name; ?></option>
    <?php

                }

            ?>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_blog_columns]">
    <?php _e( 'Home Blog Columns:','single' );?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_blog_columns]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_blog_columns]">
    <option value="2" <?php selected( genesis_get_option( 'zp_home_blog_columns', ZP_SETTINGS_FIELD ), '2' ); ?>>Two Columns</option>
    <option  value="3" <?php selected( genesis_get_option( 'zp_home_blog_columns', ZP_SETTINGS_FIELD ), '3' ); ?>>Three Columns</option>
    <option  value="4" <?php selected( genesis_get_option( 'zp_home_blog_columns', ZP_SETTINGS_FIELD ), '4' ); ?>>Four Columns</option>
  </select>
</p>
<p><span class="description">
  <?php _e( 'This settings applies to the home page blog section.','single' ); ?>
  </span></p>
<?php }

function zpsettings_slideshow_settings() { ?>
<p>
  <input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_enable_inner_slider]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_enable_inner_slider]" value="1" <?php checked( 1, genesis_get_option( 'zp_enable_inner_slider', ZP_SETTINGS_FIELD ) ); ?> />
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_enable_inner_slider]">
    <?php _e( 'Enable slider in inner pages?!', 'single' ); ?>
  </label>
</p>
<p>
  <input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]" value="1" <?php checked( 1, genesis_get_option( 'zp_slider_enable', ZP_SETTINGS_FIELD ) ); ?> />
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]">
    <?php _e( 'Check to enable slider.', 'single' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]">
    <?php _e( 'Select HomePage Slideshow', 'single' ); ?>
  </label>
  <select name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]">
    <?php

                $of_categories_obj = get_terms('slideshow');

                foreach ($of_categories_obj as $of_cat) {

                    ?>
    <option value="<?php echo $of_cat->slug; ?>" <?php selected( genesis_get_option( 'zp_home_slideshow', ZP_SETTINGS_FIELD ), $of_cat->slug ); ?> > <?php echo $of_cat->name; ?></option>
    <?php

                }

            ?>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_innerpage_slideshow]">
    <?php _e( 'Select Innerpage Slideshow', 'single' ); ?>
  </label>
  <select name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_innerpage_slideshow]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_innerpage_slideshow]">
    <?php

                $of_categories_obj = get_terms('slideshow');

                foreach ($of_categories_obj as $of_cat) {

                    ?>
    <option value="<?php echo $of_cat->slug; ?>" <?php selected( genesis_get_option( 'zp_innerpage_slideshow', ZP_SETTINGS_FIELD ), $of_cat->slug ); ?> > <?php echo $of_cat->name; ?></option>
    <?php

                }

            ?>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_height]">
    <?php _e( 'Slider Height (in pixel)', 'single' ); ?>
  </label>
  <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_slider_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_height]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation]">
    <?php _e( 'Select slider animation:','single' );?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation]">
    <option value="fade" <?php selected( genesis_get_option( 'zp_animation', ZP_SETTINGS_FIELD ), 'fade' ); ?>>Fade</option>
    <option  value="slide" <?php selected( genesis_get_option( 'zp_animation', ZP_SETTINGS_FIELD ), 'slide' ); ?>>Slide</option>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]">
    <?php _e( 'Set the speed of slideshow cycling in milliseconds.', 'single' ); ?>
  </label>
  <input type="text" size="20" value="<?php echo genesis_get_option( 'zp_slider_speed', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]">
    <?php _e( 'Set the speed of animation in milliseconds.', 'single' ); ?>
  </label>
  <input type="text" size="20" value="<?php echo genesis_get_option( 'zp_animation_duration', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]">
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_control_nav]">
    <?php _e( 'Control Navigation.','single'); ?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_control_nav]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_control_nav]">
    <option value="true" <?php selected( genesis_get_option( 'zp_control_nav', ZP_SETTINGS_FIELD ), 'true' ); ?>>True</option>
    <option  value="false" <?php selected( genesis_get_option( 'zp_control_nav', ZP_SETTINGS_FIELD ), 'false' ); ?>>False</option>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_direction_nav]">
    <?php _e( 'Direction Navigation.','single'); ?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_direction_nav]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_direction_nav]">
    <option value="true" <?php selected( genesis_get_option( 'zp_direction_nav', ZP_SETTINGS_FIELD ), 'true' ); ?>>True</option>
    <option  value="false" <?php selected( genesis_get_option( 'zp_direction_nav', ZP_SETTINGS_FIELD ), 'false' ); ?>>False</option>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonaction]">
    <?php _e( 'Pause on Action.','single'); ?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonaction]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonaction]">
    <option value="true" <?php selected( genesis_get_option( 'zp_pauseonaction', ZP_SETTINGS_FIELD ), 'true' ); ?>>True</option>
    <option  value="false" <?php selected( genesis_get_option( 'zp_pauseonaction', ZP_SETTINGS_FIELD ), 'false' ); ?>>False</option>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonhover]">
    <?php _e( 'Pause on Hover.','single'); ?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonhover]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_pauseonhover]">
    <option value="true" <?php selected( genesis_get_option( 'zp_pauseonhover', ZP_SETTINGS_FIELD ), 'true' ); ?>>True</option>
    <option  value="false" <?php selected( genesis_get_option( 'zp_pauseonhover', ZP_SETTINGS_FIELD ), 'false' ); ?>>False</option>
  </select>
</p>
<?php }
function zpsettings_appearance_settings() { ?>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]">
    <?php _e( 'Select color scheme.','single'); ?>
  </label>
  <select id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_color_scheme]">
    <option value="default" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'default' ); ?>>Default</option>
    <option  value="dark" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'dark' ); ?>>dark</option>
    <option  value="blue" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'blue' ); ?>>blue</option>
    <option  value="brown" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'brown' ); ?>>brown</option>
    <option  value="green" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'green' ); ?>>green</option>
    <option  value="light_blue" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'light_blue' ); ?>>light_blue</option>
    <option  value="magenta" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'magenta' ); ?>>magenta</option>
    <option  value="orange" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'orange' ); ?>>orange</option>
    <option  value="pink" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'pink' ); ?>>pink</option>
    <option  value="red" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'red' ); ?>>red</option>
    <option  value="yellow" <?php selected( genesis_get_option( 'zp_color_scheme', ZP_SETTINGS_FIELD ), 'yellow' ); ?>>yellow</option>
  </select>
</p>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]">
    <?php _e( 'Custom CSS Code.', 'single' ); ?>
    <br>
    <textarea class="widefat" rows="3" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]"><?php echo genesis_get_option( 'zp_css_code', ZP_SETTINGS_FIELD ); ?></textarea>
  </label>
</p>
<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]"><?php _e( 'Upload Custom Logo.', 'single' ); ?></label>
<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" value="<?php echo  genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />    
<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Logo', 'single' ); ?>" /> 
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Logo', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>

<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]"><?php _e( 'Custom Logo Width in pixel. e.g. 200', 'single' ); ?></label>

<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]">

</p> 

<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]"><?php _e( 'Custom Logo Height in pixel. e.g. 200', 'single' ); ?></label>

<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]">

</p>       

<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]"><?php _e( 'Upload Custom Favicon.', 'single' ); ?></label>  

<input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" value="<?php echo  genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />

<input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Favicon', 'single' ); ?>" />
<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Favicon', 'single' ); ?>" /> 
<span class="upload_preview" style="display: block;">
	<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />
</span>
</p>
<p><span class="description">
  <?php _e( 'This is the appearance settings.','single' ); ?>
  </span></p>
<?php } 
function zpsettings_footer_settings() { ?>
<p>
  <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]">
    <?php _e( 'Footer Text', 'single' ); ?>
    <br>
    <textarea class="widefat" rows="3" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]"><?php echo genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD ); ?></textarea>
    <br>
    <small><strong>
    <?php _e( 'Enter your site copyright here.', 'single' ); ?>
    </strong></small> </label>
</p>
<?php }

/**
 * Replace the 'Insert into Post Button inside Thickbox
 *
 */
 function zp_replace_thickbox_text($translated_text, $text ) {
	 if ( 'Insert into Post' == $text ) {
		 $referer = strpos( wp_get_referer(), ZP_SETTINGS_FIELD );
		
		if ( $referer != '' ) {
			return __('Insert Image!', 'single' );
		}
	 }
	 return $translated_text;
}

/**
 * Hook to filter Insert into Post Button in thickbox
 */
 function zp_change_insert_button_text() {
	 add_filter( 'gettext', 'zp_replace_thickbox_text' , 1, 2 );
 }
 
 add_action( 'admin_init', 'zp_change_insert_button_text' );
 
/**
 * Set the screen layout to one column
 */
 add_filter( 'screen_layout_columns', 'zpsettings_settings_layout_columns', 10, 2 );
 
/**
 * zpsettings_settings_layout_columns function.
 *
 * This function sets the column layout to one for the ZP Settings settings page.
 *
 */
 function zpsettings_settings_layout_columns( $columns, $screen ) {
	 global $_zpsettings_settings_pagehook;
	 if ( $screen == $_zpsettings_settings_pagehook ) {
		 $columns[$_zpsettings_settings_pagehook] = 2;
	}
	return $columns;
}

/*
 * Build our theme options page
 *
 * zpsettings_theme_options_page function.
 *
 * This function displays the content for the ZP Settings settings page, builds the forms and outputs the metaboxes.
 *
 */
function zpsettings_theme_options_page() { 
	global $_zpsettings_settings_pagehook, $screen_layout_columns;

	$screen = get_current_screen();

	$width = "width: 100%;";

	$hide2 = $hide3 = " display: none;";
	?>
<div id="zpsettings" class="wrap genesis-metaboxes">
  <form method="post" action="options.php">
    <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
    <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
    <?php settings_fields( ZP_SETTINGS_FIELD ); ?>
    <h2 style="width: 100%; margin-bottom: 10px;"><?php _e( 'Single Settings', 'single' ); ?>
            	<span style="float: right; text-align: center;"><input type="submit" class="button-primary genesis-h2-button" value="<?php _e( 'Save Settings', 'single' ) ?>" style="vertical-align: top;" />
                <input type="submit" class="button genesis-h2-button" name="<?php echo ZP_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'single' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'single' ) ); ?>');" /></span>
			</h2>
    <div class="metabox-holder">
      <div class="postbox-container" style="<?php echo $width; ?>">
        <?php do_meta_boxes( $_zpsettings_settings_pagehook, 'main', null ); ?>
      </div>
    </div>
    <div class="bottom-buttons">
                <input type="submit" class="button-primary genesis-h2-button" value="<?php _e( 'Save Settings', 'single' ) ?>" />
                 <input type="submit" class="button genesis-h2-button" name="<?php echo ZP_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'single' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'single' ) ); ?>');" />
             </div>
  </form>
</div>
<script type="text/javascript">

		//<![CDATA[

		jQuery(document).ready( function($) {

			// close postboxes that should be closed

			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');

			// postboxes setup

			postboxes.add_postbox_toggles('<?php echo $_zpsettings_settings_pagehook; ?>');

		});

		//]]>

	</script>
<?php }
