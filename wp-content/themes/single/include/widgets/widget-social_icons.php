<?php
/**
 * Social Icons Widget
 */
 add_action( 'widgets_init', 'zp_socialicon_load_widget' );
 
 /**
  * Widget Registration.
  *
  * Register Simple Social Icons widget.
  *
  */
  function zp_socialicon_load_widget() {
	  register_widget( 'ZP_SocialIcons_Widget' );
  }
  
  class ZP_SocialIcons_Widget extends WP_Widget {
	  
	  /**
	  * Default widget values.
	  *
	  * @var array
	  */
	  
	  protected $defaults;
	  
	  /**
	   * Default widget values.
	   *
	   * @var array
	   */
	   protected $sizes;
	   
	   /**
	    * Default widget values.
		*
		* @var array
		*/
		protected $profiles;
		
		/**
		 * Constructor method.
		 *
		 * Set some global values and create widget.
		 */
		 
		 function __construct() {
			 
			 /**
			  * Default widget option values.
			  */
			  $this->defaults = array(
			  	'title'	 => '',
				'new_window' => 0,
				'alignment'	 => 'alignleft',
				'dribble' => '',
				'behance' => '',
				'facebook'=> '',
				'gplus'	 => '',
				'linkedin' => '',
				'deviantart' => '',
				'twitter' => '',
				'pinterest'	=> '',
				'youtube' => '',
				'vimeo' => '',
				'flickr' => '',
				'tumblr' => '',
				'defaults'=> '',
				'color' => '',
				'hover'	=>''
		);
		
		/**
		 * Icon sizes.
		 */
		 $this->sizes = array( '24', '32');
		 
		 /**
		  * Social profile choices.
		  */
		 
		 $this->profiles = array(
		 	'dribble' => array(
				'label'	  => __( 'Dribble URI', 'single' ),
				'pattern' => '<li class="social-dribble"><a class="hastip" title="dribble" href="%s" %s>D</a></li>',
				'background-color' => array(
					'background-color'=> '#F14280'
				)
			),
			'behance' => array(
				'label'	  => __( 'Behance URI', 'single' ),
				'pattern' => '<li class="social-behance"><a class="hastip" title="behance" href="%s" %s>E</a></li>',
				'background-color' => array(
					'background-color'=> '#319DD4'
				)
			),
			'facebook' => array(
				'label'	  => __( 'Facebook URI', 'single' ),
				'pattern' => '<li class="social-facebook"><a class="hastip" title="facebook" href="%s" %s>F</a></li>',
				'background-color' => array(
					'background-color'=> '#3C5A98'
				)
			),
			
			'gplus' => array(
				'label'	  => __( 'Google+ URI', 'single' ),
				'pattern' => '<li class="social-gplus"><a class="hastip" title="google+" href="%s" %s>G</a></li>',
				'background-color' => array(
					'background-color'=> '#D94A3A'
				)
			),
			'linkedin' => array(
				'label'	  => __( 'Linkedin URI', 'single' ),
				'pattern' => '<li class="social-linkedin"><a class="hastip" title="linkedin" href="%s" %s>I</a></li>',
				'background-color' => array(
					'background-color'=> '#007BB6'
				)
			),
			'deviantart' => array(
				'label'	  => __( 'DeviantART URI', 'single' ),
				'pattern' => '<li class="social-deviantart"><a class="hastip" title="deviantart" href="%s" %s>J</a></li>',
				'background-color' => array(
					'background-color'=> '#9DA79D'
				)
			),
			'twitter' => array(
				'label'	  => __( 'Twitter URI', 'single' ),
				'pattern' => '<li class="social-twitter"><a class="hastip" title="twitter" href="%s" %s>L</a></li>',
				'background-color' => array(
					'background-color'=> '#2DAAE2'
				)
			),
			'vimeo' => array(
				'label'	  => __( 'Vimeo URI', 'single' ),
				'pattern' => '<li class="social-vimeo"><a class="hastip" title="vimeo" href="%s" %s>V</a></li>',
				'background-color' => array(
					'background-color'=> '#52B6EC'
				)
			),
			'pinterest' => array(
				'label'	  => __( 'Pinterest URI', 'single' ),
					'pattern' => '<li class="social-pinterest"><a class="hastip" title="pinterest" href="%s" %s>:</a></li>',
					'background-color' => array(
						'background-color'=> '#D62229'
				)
			),
			'flickr' => array(
				'label'	  => __( 'Flickr URI', 'single' ),
				'pattern' => '<li class="social-flickr"><a class="hastip" title="flickr" href="%s" %s>N</a></li>',
				'background-color' => array(
					'background-color'=> '#0063D6'
				)
			),
			'tumblr' => array(
				'label'	  => __( 'Tumblr URI', 'single' ),
				'pattern' => '<li class="social-tumblr"><a class="hastip" title="tumblr" href="%s" %s>O</a></li>',
				'background-color' => array(
					'background-color'=> '#007BB6'
				)
			),
			'youtube' => array(
				'label'	  => __( 'YouTube URI', 'single' ),
				'pattern' => '<li class="social-youtube"><a class="hastip" title="youtube" href="%s" %s>X</a></li>',
				'background-color' => array(
					'background-color'=> '#C7131A'
				)
			),
		);
		
		$widget_ops = array(
			'classname'	  => 'zp_social_icons',
			'description' => __( 'Displays select social icons.', 'single' ),
		);
		
		$control_ops = array(
			'id_base' => 'zp_social_icons',
			#'width'   => 505,
			#'height'  => 350,
		);
		
		parent::__construct( 'zp_social_icons', __( 'ZP Social Icons', 'single' ), $widget_ops, $control_ops );
		
		/** Load CSS in <head> */
		add_action( 'wp_head', array( $this, 'css' ) );
		
		/** Load script */
		//add_action('get_header', 'child_load_scripts');
	}
	
	/**
	 * Widget Form.
	 *
	 * Outputs the widget form that allows users to control the output of the widget.
	 *
	 */
	function form( $instance ) {
		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
	?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','single' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
    <p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'single' ); ?></label></p>
    <p><label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'single' ); ?>:</label><select id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>"><option value="alignleft" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Left', 'single' ); ?></option><option value="alignright" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Right', 'single' ); ?></option></select></p>
    <hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />
	<?php
    foreach ( (array) $this->profiles as $profile => $data ) {
		printf( '<p><label for="%s">%s:</label>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
		printf( '<input type="text" id="%s" class="widefat" name="%s" value="%s" /></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );
	}
	}
	
	/**
	 * Form validation and sanitization.
	 *
	 * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
	 *
	 */
	
	function update( $newinstance, $oldinstance ) {
		foreach ( $newinstance as $key => $value ) {
			/** Border radius must not be empty, must be a digit */
			if ( 'border_radius' == $key && ( '' == $value || ! ctype_digit( $value ) ) ) {
				$newinstance[$key] = 0;
			}
			
			/** Validate hex code colors */
			elseif ( strpos( $key, '_color' ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				$newinstance[$key] = $oldinstance[$key];
			}
			/** Sanitize Profile URIs */
			elseif ( array_key_exists( $key, (array) $this->profiles ) ) {
				$newinstance[$key] = esc_url( $newinstance[$key] );
			}
	}
	
	return $newinstance;
	}
	
	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 */
	
	function widget( $args, $instance ) {
		extract( $args );
		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		echo $before_widget;
		
		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
		
		$output = '';
		$new_window = $instance['new_window'] ? 'target="_blank"' : '';
		foreach ( (array) $this->profiles as $profile => $data ) {
			if ( ! empty( $instance[$profile] ) )
				$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );
			}
			
			if ( $output )
				printf( '<ul class="%s">%s</ul>', $instance['alignment'], $output );
			
			echo $after_widget;
	}
	
	/**
	 * Custom CSS.
	 *
	 * Outputs custom CSS to control the look of the icons.
	 */
	function css() {
		
		/** Pull widget settings, merge with defaults */
		$all_instances = $this->get_settings();
		$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );
		
		wp_enqueue_script(  'tipTip_js'  );
		
		/** The CSS to output */
		$css = '.zp_social_icons {
			overflow: hidden;
		}
		.zp_social_icons .alignleft, .zp_social_icons .alignright {
			margin: 0; padding: 0;
		}
		.zp_social_icons ul li {
			float: left;
			list-style-type: none !important;
			margin: 0 !important;
			padding: 0 !important;
			border: medium none;
		}
		.zp_social_icons ul li a {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			border-radius: 3px;
			color: #fff !important;
			display: block;
			font-family: "socialicoregular";
			font-size: 30px;
			font-weight: 400;
			height: 50px;
			line-height: 1;
			margin: 3px;
			opacity: 1;
			overflow: hidden;
			padding: 10px 0;
			text-align: center;
			vertical-align: bottom;
			width: 50px;
			transition: all 0s ease 0s;
			text-shadow: none !important;
		}
		.zp_social_icons ul li a:hover {
			color: #fff;
		}
		
		/* tooltip CSS
		-------------------------------------------------------------*/
		#tiptip_holder {
			background: url('.get_stylesheet_directory_uri().'/include/widgets/images/bg-popup.png) no-repeat scroll 12px bottom;
			display: block;
			left: -17px;
			padding: 0 0 20px;
			position: absolute;
			top: 19px;
			z-index: 99999;
		}
		#tiptip_holder.tip_top {
			padding-bottom: 5px;
		}
		
		#tiptip_holder.tip_bottom {
			padding-top: 5px;
		}
		#tiptip_holder.tip_right {
			padding-left: 5px;
		}
		#tiptip_holder.tip_left {
			padding-right: 5px;
		}
		
		#tiptip_content {
			font-size: 11px;
			color: #fff;
			padding: 2px 8px;
			background-color: #46494A;
		}
		
		#tiptip_arrow, #tiptip_arrow_inner {
			position: absolute;
			height: 0;
			width: 0;
		}
		
		#tiptip_holder.tip_top #tiptip_arrow {
			border-top-color: #fff;
			border-top-color: rgba(255, 255, 255, 0.35);
		}
		#tiptip_holder.tip_bottom #tiptip_arrow {
			border-bottom-color: #fff;
			border-bottom-color: rgba(255, 255, 255, 0.35);
		}
		#tiptip_holder.tip_right #tiptip_arrow {
			border-right-color: #fff;
			border-right-color: rgba(255, 255, 255, 0.35);
		}
		
		#tiptip_holder.tip_left #tiptip_arrow {
			border-left-color: #fff;
			border-left-color: rgba(255, 255, 255, 0.35);
		}
		#tiptip_holder.tip_top #tiptip_arrow_inner {
			margin-top: -7px;
			margin-left: -6px;
			border-top-color: rgb(102,102,102);
			border-top-color: rgba(102, 102, 102, 0.92);
		}
		#tiptip_holder.tip_bottom #tiptip_arrow_inner {
			margin-top: -5px;
			margin-left: -6px;
			border-bottom-color: rgb(102,102,102);
			border-bottom-color: rgba(102, 102, 102, 0.92);
		}
		
		#tiptip_holder.tip_right #tiptip_arrow_inner {
			margin-top: -6px;
			margin-left: -5px;
			border-right-color: rgb(102,102,102);
			border-right-color: rgba(102, 102, 102, 0.92);
		}
		
		#tiptip_holder.tip_left #tiptip_arrow_inner {
			margin-top: -6px;
			margin-left: -7px;
			border-left-color: rgb(102,102,102);
			border-left-color: rgba(102, 102, 102, 0.92);
		}
		#tiptip_content:after{
			background: #fff;
		}';
		
		/** Individual Profile button styles */
		foreach ( (array) $this->profiles as $profile => $data ) {
			//	if ( ! $instance[$profile] )
				//continue;
				$css .= '.zp_social_icons ul li.social-' . $profile . ' a {background-color: ' . $data['background-color']['background-color'] . ';	}';
		}
		
		/** Minify a bit */
		$css = str_replace( "\t", '', $css );
		$css = str_replace( array( "\n", "\r" ), ' ', $css );
		
		/** Echo the CSS */
		echo '<style type="text/css" media="screen">' . $css . '</style>';
	}
}