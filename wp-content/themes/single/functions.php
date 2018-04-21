<?php
/**
 * Start the engine
 */
 require_once(get_template_directory().'/lib/init.php');
 
/**
 * Localization
 */
 load_child_theme_textdomain( 'single', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'single' ) );
 
/**
 * Theme Constant
 */
 define( 'CHILD_THEME_NAME', 'Single'  );
 define( 'CHILD_THEME_URL', 'http://demo.zigzagpress.com/single/'  );
 
/**
 * Custom Post Type
 */
 require_once( get_stylesheet_directory() . '/include/cpt/super-cpt.php'  );
 require_once( get_stylesheet_directory() . '/include/cpt/zp_cpt.php'  );

/**
 * Theme Option
 */
 require_once ( get_stylesheet_directory() . '/include/theme_settings.php'  );
 require_once ( get_stylesheet_directory() . '/include/theme_functions.php'  );
 
/**
 * Shortcodes
 */
 require_once( get_stylesheet_directory() . '/include/shortcodes/shortcode.php'  );
 
/**
 * Widgets
 */
 require_once( get_stylesheet_directory()  .'/include/widgets/widget-address.php'  );
 require_once( get_stylesheet_directory()  .'/include/widgets/widget-flickr.php'  );
 require_once( get_stylesheet_directory()  .'/include/widgets/widget-social_icons.php'  );
 
/**
 * Unregister Theme Layout
 */
 unregister_sidebar( 'header-right' );
 genesis_unregister_layout( 'content-sidebar-sidebar' );
 genesis_unregister_layout( 'sidebar-sidebar-content' );
 genesis_unregister_layout( 'sidebar-content' );
 genesis_unregister_layout( 'sidebar-content-sidebar' );
 
/**
 * Remove Secondary Nav
 */
 add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'single' ) ) );
 
/**
 * Register Sidebars
 */
 unregister_sidebar( 'sidebar-alt' );

/**
 * Add HTML5 Markup Structure
 */
 add_theme_support( 'html5' );
 
/**
 * Support Wrap
 */
 add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );
 
/**
 * Theme Stylesheets
 */
 add_action( 'wp_enqueue_scripts', 'zp_print_styles' );
 function zp_print_styles() {
	 wp_register_style( 'pretty_photo_css', get_stylesheet_directory_uri().'/css/prettyPhoto.css' );
	 wp_enqueue_style( 'pretty_photo_css' );
	 wp_register_style( 'flexslider-css', get_stylesheet_directory_uri().'/css/flexslider.css' );
	 wp_enqueue_style( 'flexslider-css' );
	 wp_register_style( 'mobile_css', get_stylesheet_directory_uri().'/css/mobile.css' );
	 wp_enqueue_style( 'mobile_css' );
	 wp_register_style( 'shortcode-css', get_stylesheet_directory_uri( ).'/include/shortcodes/shortcode.css'  );
	 wp_enqueue_style( 'shortcode-css'  );
	 
	  $color = strtolower( genesis_get_option( 'zp_color_scheme' ,  ZP_SETTINGS_FIELD ) );
	 if( $color != 'default' ){
		wp_enqueue_style( 'color_scheme', get_stylesheet_directory_uri( ).'/css/'.$color.'.css'  );	 
	 }
	 
	 wp_enqueue_style( 'custom', get_stylesheet_directory_uri( ).'/custom.css'  );
}

/**
 * Shortcode CSS
 */
 add_action('admin_enqueue_scripts', 'zp_codes_admin_init');
 function zp_codes_admin_init(){
	 global $current_screen;
	 
	 if($current_screen->base=='post'){
		 wp_enqueue_script('jquery');
		 wp_enqueue_script('jquery-ui-dialog');
		 wp_enqueue_script('jquery-ui-core');
		 wp_enqueue_script('jquery-ui-sortable');
		 
		 wp_enqueue_style( 'shortcode_editor_style',get_stylesheet_directory_uri( ).'/include/shortcodes/shortcode_editor_style.css' );
	}
}
/**
 * Theme Scripts
 */
 add_action('wp_enqueue_scripts', 'zp_theme_js');
 function zp_theme_js() {
	 wp_register_script('jquery_easing_js', get_stylesheet_directory_uri() . '/js/jquery-easing.js', array('jquery'), '', true );
	 wp_register_script('jquery_pretty_photo_js', get_stylesheet_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), '3.1.6', true);
	 wp_register_script('jquery_isotope_min_js', get_stylesheet_directory_uri().'/js/jquery.isotope.min.js', array('jquery'), '', true);
	 wp_register_script('jquery.flexslider_js', get_stylesheet_directory_uri().'/js/jquery.flexslider.js', array('jquery'), '', true);
	 wp_register_script('jQuery_ScrollTo_min_js', get_stylesheet_directory_uri() . '/js/jQuery.ScrollTo.min.js', array('jquery'), '', true);
	 wp_register_script('tipTip_js', get_stylesheet_directory_uri().'/js/jquery.tipTip.minified.js', array('jquery'), '', true);
	 wp_register_script('jqueryTools', get_stylesheet_directory_uri() . '/js/jquery.Tools.js',array('jquery'),'1.2.7', true);
	 wp_register_script('jquery_nav_js', get_stylesheet_directory_uri() . '/js/jquery.nav.js',array('jquery'),'2.2.0', true);
	 wp_register_script( 'jquery_carouFredSel', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.carouFredSel.min.js',array( 'jquery' ) , '6.2.1', true );
	 wp_register_script( 'jquery_mousewheel', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.mousewheel.min.js',array( 'jquery' ),'3.0.6' , true );
	 wp_register_script( 'jquery_touchswipe', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.touchSwipe.min.js',array( 'jquery' ), '1.3.3', true );
	 wp_register_script( 'jquery_transit', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.transit.min.js',array( 'jquery' ) , '', true);
	 wp_register_script( 'jquery_throttle', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.ba-throttle-debounce.min.js', array( 'jquery' ), '1.1' , true);
	 wp_register_script( 'jquery_cycle', get_stylesheet_directory_uri(  ) . '/js/jquery.cycle.lite.js',array( 'jquery' ) , '', true);
	 wp_register_script('jquery_custom_js', get_stylesheet_directory_uri().'/js/jquery.custom.js', array('jquery'), '', true );
	 
	 wp_enqueue_script(  'jquery'  );
	 wp_enqueue_script(  'jquery_easing_js'  );
	 wp_enqueue_script(  'jquery_pretty_photo_js'  );
	 wp_enqueue_script(  'jquery_isotope_min_js'  );
	 wp_enqueue_script(  'jquery.flexslider_js'  );
	 wp_enqueue_script(  'jQuery_ScrollTo_min_js'  );
	 wp_enqueue_script(  'jquery_nav_js'  );
	 wp_enqueue_script(  'jquery_custom_js'  );
}

/**
 * Custom CSS
 */
 add_action( 'wp_head', 'zp_custom_styles' );
 function zp_custom_styles( ) {
	 $css_custom = genesis_get_option('zp_css_code', ZP_SETTINGS_FIELD );
	 if( $css_custom ){
		 echo '<style type="text/css">'.$css_custom.'</style>';
	 }
}

/**
 * Favicon
 */
 add_filter('genesis_favicon_url', 'zp_favicon_url');
 function zp_favicon_url() {
	 $favicon_link = genesis_get_option('zp_custom_favicon',ZP_SETTINGS_FIELD );
	 if ( $favicon_link ) {
		 $favicon = $favicon_link;
		 return $favicon;
	}else
		return false;
	}

/**
 * Logo Support
 */
 add_action( 'wp_head', 'zp_custom_logo' );
 function zp_custom_logo() {
	 if (  genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD )  ) { ?>
	 <style type="text/css">
	 	.header-image .site-header .title-area {
			background-image: url( "<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" );
			background-position: center center;
			background-repeat: no-repeat;
			height: <?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?>px;
			width: <?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?>px;
		}</style>
    <?php
	 }
 }
/**
 * Custom/Filter/Reposition Navigation
 */
 remove_action('genesis_after_header', 'genesis_do_nav');
 add_action('genesis_header', 'genesis_do_nav', 14);
 
/**
 * Unregister Secondary Nav
 */
 remove_action('genesis_after_header', 'genesis_do_subnav');
 
/**
 * Custom Post Title
 */
 remove_action( 'genesis_post_content', 'zp_generate_post_image' );
 add_action( 'genesis_before_post_title', 'zp_generate_post_image', 5 );
 function zp_generate_post_image() {
	if ( is_page() || ! genesis_get_option( 'content_archive_thumbnail' ) )
	 	return;
	
	if ( $image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) ) ) {
		printf( '<a href="%s" rel="bookmark"><img class="post-image" src="%s" alt="%s" /></a>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}
}

/**
 * Shortcode Filter
 */
 add_filter('widget_text', 'do_shortcode');

/**
 * Modify "Read More" Text
 */
 add_filter( 'excerpt_more', 'zp_read_more_link' );
 add_filter( 'get_the_content_more_link', 'zp_read_more_link' );
 function zp_read_more_link() {
	 return '&hellip; <a class="more-link" href="' . get_permalink() . '">'.__( 'Read More &rarr; ', 'single' ).'</a>';
}

/**
 * Add Paget Title Div
 */
 add_filter('genesis_before_content_sidebar_wrap','zp_add_div');
 function zp_add_div(){
	 echo '<div class="page_title_wrap">';
}

/**
 * Reposition Breaadcrumbs
 */
 remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );
 
/**
 * Custom Breadcrumbs Arguments
 */
 add_filter( 'genesis_breadcrumb_args', 'zp_breadcrumb_args' );
 function zp_breadcrumb_args( $args ) {
	 $args['sep'] = ' &raquo; ';
	 $args['list_sep'] = ', ';
	 $args['display'] = true;
	 $args['labels']['prefix'] = '';
	 $args['labels']['author'] = __('Archives for ','single ');
	 $args['labels']['category'] =  __('Archives for ','single ');
	 $args['labels']['tag'] =  __('Archives for ','single ');
	 $args['labels']['date'] =  __('Archives for ','single ');
	 $args['labels']['search'] =  __('Archives for ','single ');
	 $args['labels']['tax'] =  __('Archives for ','single ');
	 $args['labels']['post_type'] =  __('Archives for ','single ');
	 $args['labels']['404'] =  __('404 ','single ');
	 
	 return $args;
}

/**
 * Add Page Title
 */
 add_filter('genesis_before_content_sidebar_wrap','zp_page_title');
 function zp_page_title(){
	 global $post;
	 
	 if (is_category()){
		 $category = get_the_category($post->ID);
		 add_action('genesis_post_title', 'genesis_do_post_title');
		 echo '<h1 class="page-title">'.__( 'Archives for ', 'single').$category[0]->name.'</h1>';
	}
	
	if(is_search()){
		echo '<h1 class="page-title">'.__( 'You searched for ', 'single' ). the_search_query() . '</h1>';
	}
	
	if (is_author()){
		$author = get_the_author($post->ID);
		add_action('genesis_entry_header', 'genesis_do_post_title');
		echo '<h1 class="page-title">'.__( 'Archives for ', 'single').$author.'</h1>';
	}
	
	if (is_tag()){
		add_action('genesis_entry_header', 'genesis_do_post_title');
		echo '<h1 class="page-title">'.__( 'Archives for ', 'single').single_tag_title('',FALSE).'</h1>';
	}
	
	if( is_post_type_archive('portfolio') ){
		add_action('genesis_entry_header', 'genesis_do_post_title');
		$post_type_title=post_type_archive_title('',false);
		echo '<h1 class="page-title">'.__( 'Archives for ', 'single').$post_type_title.'</h1>';
	}
	
	if(is_singular( 'portfolio' )){
		add_action('genesis_entry_header', 'genesis_do_post_title');
		echo '<h1 class="page-title">'.the_title('','',FALSE).'</h1>';
	}
	
	if( is_page_template('page_blog.php') ){
		add_action('genesis_entry_header', 'genesis_do_post_title');
		echo '<h1 class="page-title">'.the_title('','',FALSE).'</h1>';
	}
	
	if(is_page() && !is_page_template('page_blog.php')){
		echo '<h1 class="page-title">'.the_title('','',FALSE).'</h1>';
	}
 }

/**
 * Close Page Title Div
 */
 add_filter('genesis_before_content_sidebar_wrap','zp_close_div');
 function zp_close_div(){
	 echo '</div>';
}

/**
 * Remove Page Title
 */
 add_action('get_header', 'zp_remove_page_titles');
 function zp_remove_page_titles() {
	 if (is_page() || is_404()) {
		 remove_action('genesis_entry_header', 'genesis_do_post_title');
	}
}

/**
 * Background Theme Support
 */
$args = array(
	'default-color' => 'FFFFFF'
);
add_theme_support( 'custom-background', $args );

 
/**
 * Background Theme Support
 */
 add_action('genesis_before_header','zp_home_slider');
 function zp_home_slider(){
	 
	 if( genesis_get_option( 'zp_slider_enable', ZP_SETTINGS_FIELD ) == true ){
		 if( genesis_get_option( 'zp_enable_inner_slider', ZP_SETTINGS_FIELD ) == true ){
			require( get_stylesheet_directory().'/include/slider/slider.php');
		 }else{
			 if( is_home() ){
			 	require( get_stylesheet_directory().'/include/slider/slider.php');
			 }
		 }
	 }
 }
/**
 * Add To Top Link
 */
 add_action('genesis_before_footer','zp_add_top_link');
 function zp_add_top_link(){
	 echo '<a href="#top" id="top-link">'.__(' &uarr; Top of Page','single' ).'</a>';
 }
 
/**
 * Add wrapper div before site-footer
 */
 add_action('genesis_before_footer','zp_footer_wrapper_open', 3);
 function zp_footer_wrapper_open(){
	 echo '<div id="contact">';
 }
 
/**
 * Add footer widget support
 */
 add_theme_support( 'genesis-footer-widgets', 1);
 
 add_action('genesis_footer','zp_footer_wrapper_close', 4);
 function zp_footer_wrapper_close(){
	 echo '</div>';
 }

/**
 * Custom Footer Display
 */
 remove_action('genesis_footer', 'genesis_do_footer');
 add_action('genesis_footer', 'zp_do_custom_footer');
 function zp_do_custom_footer() { ?>
 <!-- Start footer menu. -->
 <?php
 	if(is_active_sidebar('bottom')){?>
    	<div class="bottom">
        	<div class="widget">
				<?php dynamic_sidebar('bottom'); ?>
            </div>
        </div>
 <?php } ?>
 <?php
 if( genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD ) != '' ){
	 $footer_text = genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD );
 }else{
	 $footer_text =  '&copy; '.date("Y").' '.get_bloginfo('name').' :: '.get_bloginfo('description');
 }
 ?>
 <div class="creds"><?php echo $footer_text; ?></div>
 <?php }
 
/**
 * Register Widgets
 */
 genesis_register_sidebar( array(
 	'name'=>'About Me',
	'id' => 'about-me',
	'description' => __( 'This is a homepage widget area.', 'single' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h1 class="widgettitle">','after_title'=>'</h1>'
));

genesis_register_sidebar(array(
	'name'=>'Services',
	'id' => 'services',
	'description' => __( 'This is a homepage widget area.', 'single' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h1 class="widgettitle">','after_title'=>'</h1>'
));
genesis_register_sidebar(array(
	'name'=>'Testimonial',
	'id' => 'testimonial',
	'description' => __( 'This is a homepage widget area.', 'single' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h1 class="widgettitle">','after_title'=>'</h1>'
));
genesis_register_sidebar(array(
	'name'=>'Partners',
	'id' => 'partners',
	'description' => __( 'This is a homepage widget area.', 'single' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h1 class="widgettitle">','after_title'=>'</h1>'
));
genesis_register_sidebar(array(
	'name'=>'Bottom',
	'id' => 'bottom',
	'description' => __( 'This is a bottom widget beside site credits.', 'single' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h1 class="widgettitle">','after_title'=>'</h1>'
));

/**
 * For Mobile
 */
 add_action('genesis_meta','zp_for_mobile');
 function zp_for_mobile(){?>
 	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
 }
 
/**
 * Mobile Menu
 */
 add_action('genesis_header','zp_mobile_menu', 13);
 function zp_mobile_menu(){
	 echo '<div id="mobile_menu"><div class="menu_title">4</div></div>';
 }
/**
 * Changing widget title formatting
 */
 add_filter( 'genesis_register_sidebar_defaults', 'zp_register_sidebar_defaults' );
 function zp_register_sidebar_defaults( $defaults ) {
	 $defaults['before_title'] = '<h1 class="widgettitle">';
	 $defaults['after_title'] = "</h1>";
	 return $defaults;
}
/**
 * Apply Home Section background
 */
 add_action( 'wp_head' , 'zp_home_section_background' );
 function zp_home_section_background(){
	 
	 $style = '';
	 
	 if( genesis_get_option( 'zp_portfolio_section_bg', ZP_SETTINGS_FIELD ) != '' ){
		 $style .= '
		 	div#portfolio{
				background-image: url("'.genesis_get_option( 'zp_portfolio_section_bg', ZP_SETTINGS_FIELD ).'");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center top;
				background-size: cover;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-color: transparent;
			}';
	}
	if( genesis_get_option( 'zp_services_section_bg', ZP_SETTINGS_FIELD ) != '' ){
		$style .= '
			div#services{
				background-image: url("'.genesis_get_option( 'zp_services_section_bg', ZP_SETTINGS_FIELD ).'");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center top;
				background-size: cover;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-color: transparent;
			}';
	}
	
	if( genesis_get_option( 'zp_testimonial_section_bg', ZP_SETTINGS_FIELD ) != '' ){
		$style .= '
			div#testimonial{
				background: url("'.genesis_get_option( 'zp_testimonial_section_bg', ZP_SETTINGS_FIELD ).'");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center top;
				background-size: cover;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-color: transparent;
			}';
	}
	
	if( genesis_get_option( 'zp_footer_section_bg', ZP_SETTINGS_FIELD ) != '' ){
		$style .= '
			div#contact{
				background: url("'.genesis_get_option( 'zp_footer_section_bg', ZP_SETTINGS_FIELD ).'");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center top;
				background-size: cover;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-color: transparent;
				position: relative;
			}';
	}
	echo '<style type="text/css">'.$style.'</style>';
}