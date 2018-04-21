<?php get_header(); ?>
<?php do_action( 'genesis_home' ); ?>
<div id="home-wrap">
    <?php if( genesis_get_option('zp_welcome_enable', ZP_SETTINGS_FIELD) == true ): ?>
 
   			<div class="intro "><?php echo do_shortcode( genesis_get_option('zp_welcome_message', ZP_SETTINGS_FIELD) );?></div> 
	<?php endif; 
	
/*
Home Page Configuration
*/	
$url = zp_retrieve_primary_nav_items();
$i = 0;
while($i != count($url)){
	
	if( zp_validate_menu_and_sidebar( $url[$i]) )
		
		zp_display_home_page($url[$i]);
	
	$i++;
}	
?>
</div>
<?php get_footer(); ?>