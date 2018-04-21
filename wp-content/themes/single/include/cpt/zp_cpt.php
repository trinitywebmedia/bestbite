<?php 
// ZP Custom Post Types Initialization
 
function zp_custom_post_type() {
    if ( ! class_exists( 'Super_CPT' ) )
        return;
		
/*----------------------------------------------------*/
// Add Slide Custom Post Type
/*---------------------------------------------------*/
 
 	$slide_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => get_stylesheet_directory_uri().'/include/cpt/images/slide.png',
	);
	// register slide post type
	$slide = new Super_Custom_Post_Type( 'slide', 'Slide', 'Slides',  $slide_custom_default );
	$slideshow = new Super_Custom_Taxonomy( 'slideshow' ,'Slideshow', 'Slideshows', 'cat' );
	connect_types_and_taxes( $slide, array( $slideshow ) );
	// Slide meta boxes
	$slide->add_meta_box( array(
		'id' => 'slider-settings',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'video_type_value' => array( 'label' => __( 'Video Type','single'), 'type' => 'select', 'options' => array('youtube' => 'Youtube','vimeo' => 'Vimeo') , 'data-zp_desc' => __( 'Select appropriate video type','single') ),
			'video_id_value' => array( 'label' => __( 'Video ID','single'), 'type' => 'text', 'data-zp_desc' => __( 'Enter video ID. Example: VdvEdMMtNMY','single') ),
			'video_height_value' => array( 'label' => __( 'Video height','single'), 'type' => 'text', 'data-zp_desc' => __( 'Enter video height in px. Example: 300','single') ),
			'slider_link_value' => array( 'label' => __( 'Slide Link','single' ), 'type' => 'text' , 'data-zp_desc' => __( 'Put slide link if needed','single') ),		
		)
	) );	
	$slide->add_meta_box( array(
		'id' => 'slide-order',
		'context' => 'side',
		'fields' => array(
			'slide_number_value' => array( 'type' => 'text', 'data-zp_desc' => __( 'Define slide order. Ex. 1,2,3,4,...','single') ),		
		)
	) );		
	// manage slide columns 
	function zp_add_slide_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'single'),
			'slideshow' => __('Slideshow', 'single'),
			'slide_order' =>__( 'Slide Order', 'single'),
			'date' => __('Date', 'single'),			
		);
	}
	add_filter('manage_slide_posts_columns' , 'zp_add_slide_columns');
	function zp_custom_slide_columns( $column, $post_id ) {
		switch ( $column ) {
		case 'slideshow' :
			$terms = get_the_term_list( $post_id , 'slideshow' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Unable to get author(s)', 'single' );
			break;
	
		case 'slide_order' :
			echo get_post_meta( $post_id , 'slide_number_value' , true ); 
			break;
		}
	}
	add_action( 'manage_posts_custom_column' , 'zp_custom_slide_columns', 10, 2 );
	
	
	
		
/*----------------------------------------------------*/
// Add Portfolio Custom Post Type
/*---------------------------------------------------*/
	$portfolio_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt'),	
		'menu_icon' =>  get_stylesheet_directory_uri().'/include/cpt/images/portfolio.png',
	);
	// register portfolio post type
	$portfolio = new Super_Custom_Post_Type( 'portfolio', 'Portfolio', 'Portfolio',  $portfolio_custom_default );
	$portfolio_category = new Super_Custom_Taxonomy( 'portfolio_category' ,'Portfolio Category', 'Portfolio Categories', 'cat' );
	connect_types_and_taxes( $portfolio, array( $portfolio_category ) );
	// Portfolio meta boxes
	$portfolio->add_meta_box( array(
		'id' => 'portfolio-metaItem',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'zp_portfolio_meta_item_value' => array( 'label' => __( 'Include Portfolio MetaItem','single'), 'type' => 'select', 'options' => array('true' => 'True','false' => 'False'), 'data-zp_desc' => __( 'Select True to include meta on portfolio single page.','single') ),
			'zp_client_label_value' => array( 'label' => __( 'Client Label','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define client label','single') ),
			'zp_client_value' => array( 'label' => __( 'Client Value','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define client Value' ,'single') ),		
				
			'zp_date_label_value' => array( 'label' => __( 'Date Label','single'), 'type' => 'text' , 'data-zp_desc' => __( 'Define date label','single') ),	
			'zp_date_value' => array( 'label' => __( 'Client Label','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define date label' ,'single') ),				
			
			'zp_category_label_value' => array( 'label' => __( 'Category Label','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define category label','single')  ),	
			'zp_category_value' => array( 'label' => __( 'Category Value','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define category value','single')  ),			
			
			'zp_visit_project_label_value' => array( 'label' => __( 'Visit Project Label','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define project label','single')  ),	
			'zp_visit_project_link_value' => array( 'label' => __( 'Visit Project Link','single'), 'type' => 'text', 'data-zp_desc' => __( 'Define project link','single')  ),		
				
		)
	) );
	$portfolio->add_meta_box( array(
		'id' => 'portfolio-images',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'portfolio_images' => array( 'label' => __( 'Upload/Attach an image to this portfolio item. Images attached in here will be shown in the single portfolio page as a slider','single'), 'type' => 'multiple_media' , 'data-zp_desc' => __( 'Attach images to this portfolio item','single' )),														
		)
	) );
	$portfolio->add_meta_box( array(
		'id' => 'portfolio-videos',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'zp_video_url_value' => array( 'label' => __( 'Youtube or Vimeo URL','single'), 'type' => 'text', 'data-zp_desc' => __( 'Place here the video url. Example video url: YOUTUBE: http://www.youtube.com/watch?v=Sv5iEK-IEzw and VIMEO: http://vimeo.com/7585127','neo') ),		
			'zp_video_embed_value' => array( 'label' => __( 'Embed Code','neo'), 'type' => 'textarea' , 'data-zp_desc' => __( 'If you are using anything else other than YouTube or Vimeo, paste the embed code here. This field will override anything from the above.','single' )),	
			'zp_height_value' => array( 'label' => __( 'Video Height','single'), 'type' => 'text', 'data-zp_desc' => __( 'Please input your video height. Example: 300','single') )
												
		)
	) );		
	
	
	// manage portfolio columns 
	function zp_add_portfolio_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'single'),
			'portfolio_category' => __('Portfolio Category', 'single'),
			'author' =>__( 'Author', 'single'),
			'date' => __('Date', 'single'),			
		);
	}
	add_filter('manage_portfolio_posts_columns' , 'zp_add_portfolio_columns');
	function zp_custom_portfolio_columns( $column, $post_id ) {
		switch ( $column ) {
		case 'portfolio_category' :
			$terms = get_the_term_list( $post_id , 'portfolio_category' , '' , ',' , '' );
			if ( is_string( $terms ) )
				echo $terms;
			else
				_e( 'Unable to get author(s)', 'single' );
			break;
		}
	}
	add_action( 'manage_posts_custom_column' , 'zp_custom_portfolio_columns', 10, 2 );
	
/*----------------------------------------------------*/
// Add Page Custom Meta
/*---------------------------------------------------*/
	$page_meta = new Super_Custom_Post_Meta( 'page' );
	$page_meta->add_meta_box( array(
		'id' => 'portfolio-page-settings',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			'column_number_value' => array( 'label' => __('Number of Columns','neo'), 'type' => 'select' , 'options' => array('2' => 'Two Columns','3' => 'Three Columns', '4' => 'Four Columns'), 'data-zp_desc' => __('Choose the portfolio page columns. Applies to Portfolio filter/gallery template', 'neo'			))
		)
	) );	
		
}
add_action( 'after_setup_theme', 'zp_custom_post_type' );
?>