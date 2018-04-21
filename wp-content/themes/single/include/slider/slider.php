<div id="home_gallery" style="max-height: 600px; height: <?php echo genesis_get_option( 'zp_slider_height' , ZP_SETTINGS_FIELD );?>px;">
<div class="flexslider">
	<ul class="slides">
	<?php
    	//adjust video height
		if( is_home() ){		
			$slideshow = genesis_get_option( 'zp_home_slideshow' , ZP_SETTINGS_FIELD );
		}else{
			$slideshow = genesis_get_option( 'zp_innerpage_slideshow' , ZP_SETTINGS_FIELD );	
		}
		global $post;
		
		$recent = new WP_Query(array('post_type'=> 'slide', 'showposts' => '-1','orderby' => 'meta_value_num', 'meta_key'=>'slide_number_value','order'=>'ASC', 'slideshow' => $slideshow ));
		while($recent->have_posts()) : $recent->the_post();
			$image = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			$captions = get_the_title('',FALSE);
			$type= get_post_meta(get_the_ID(), 'video_type_value', true);
			$video_id= get_post_meta(get_the_ID(), 'video_id_value', true);
			$link = get_post_meta(get_the_ID(), 'slider_link_value', true);
			$description= get_the_content();
			$video_height = get_post_meta(get_the_ID(), 'video_height_value', true );
			
			if($type== "youtube"){?>
            	<li class="slide_video">
                	<iframe  height="<?php echo $video_height;?>" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?wmode=opaque" ></iframe>
                </li>
			<?php }elseif($type == "vimeo"){?>
            	<li class="slide_video">
                	<iframe src="http://player.vimeo.com/video/<?php echo $video_id; ?>?portrait=0&amp;color=ffffff"  height="<?php echo $video_height;?>" ></iframe>
                </li>
			<?php	}else{ ?>
            	<li style="background-image: url(<?php echo $image;?>); height: <?php echo genesis_get_option( 'zp_slider_height' , ZP_SETTINGS_FIELD );?>px; max-height: 600px; background-repeat: no-repeat; background-size: cover; ">
                	<div class="flex-caption"><div class="caption_container"><?php echo $description; ?></div></div>
                </li>
            <?php }
			
		endwhile;
		wp_reset_query(); ?>
      </ul></div>
	  
	  <script type="text/javascript">
	  	var J = jQuery.noConflict();
		J(document).ready(function() {
			J('#home_gallery .flexslider').flexslider({
				animation: "<?php echo genesis_get_option( 'zp_animation' , ZP_SETTINGS_FIELD );?>",
				slideDirection: "horizontal",
				slideshowSpeed: <?php echo genesis_get_option( 'zp_slider_speed' , ZP_SETTINGS_FIELD );?>,
				animationDuration: <?php echo genesis_get_option( 'zp_animation_duration' , ZP_SETTINGS_FIELD );?>,
				directionNav: <?php echo genesis_get_option( 'zp_direction_nav' , ZP_SETTINGS_FIELD );?>,
				controlNav: <?php echo genesis_get_option( 'zp_control_nav' , ZP_SETTINGS_FIELD );?>,
				pauseOnAction: <?php echo genesis_get_option( 'zp_pauseonaction' , ZP_SETTINGS_FIELD );?>,
				pauseOnHover:  <?php echo genesis_get_option( 'zp_pauseonhover' , ZP_SETTINGS_FIELD );?>,
				animationLoop: true,
				video: true
			});
			J('.flexslider').hover(function(){
				J(this).children('ul.flex-direction-nav').css({display: 'block'});
			}, function(){
				J(this).children('ul.flex-direction-nav').css({display: 'none'});
			});
		});
       </script>
</div>