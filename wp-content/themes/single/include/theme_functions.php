<?php

/**
* Theme Functions
*/

// Add new image sizes
add_image_size(  'Square', 100, 100, TRUE  );
add_image_size(  'Blog', 700, 280, TRUE  );

add_image_size(  'home_blog', 359, 200, TRUE  );
add_image_size(  '2col', 560, 400, TRUE  );
add_image_size(  '3col', 345, 230, TRUE  );
add_image_size(  '4col', 245, 165, TRUE  );

/**
 * Portfolio Filter
 */

function zp_portfolio_filter(){
	$output = '';
	
	$output .= '<div id="options" class="clearfix">';
	$output .= '<ul id="portfolio-categories" class="option-set" data-option-key="filter"><li><a href="#" data-option-value="*" class="selected">'.__( 'Show All', 'single').'</a></li>';
	
	$term_args = array(
		'orderby' => 'name',
		'order' => 'ASC',
		'taxonomy' => 'portfolio_category'
	);
	
	$categories = get_categories($term_args);
	foreach($categories as $category) :
		$output .= '<li><a class="active" href="#" data-option-value=".'.$category->slug.'">'.$category->name.'</a></li>';
	endforeach;
	$output .= '</ul></div>';
	return $output;
}

/**
 * Portfolio Single preview
 */
 function zp_portfolio_single_preview(){
	 global $post;
	 
	 $args= array(
		'posts_per_page' =>'-1',
		'post_type' => 'portfolio'
	);
	query_posts($args);
	
	?>
    <div id="close-project"><a href="#index">Close</a></div>
    	<div class="front_list_items">
		<?php
        	$t_link = 0;
			
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				$t_link++;
			?>
			<div class="list-items <?php echo $t_link;?>" style="display: none">
            <div class="portfolio_single_feature">
			<?php
            //get portfolio meta settings
				$portfolio_images = get_post_meta($post->ID, 'portfolio_images', true);
				$video_url = get_post_meta($post->ID, 'zp_video_url_value', true);
				$video_embed = get_post_meta($post->ID, 'zp_video_embed_value', true);
				$video_ht = get_post_meta($post->ID, 'zp_height_value', true);
			?>
            <!--if  Video exist -->
            <?php if($video_url !='' || $video_embed!= ''){ ?>
            <div class="portfolio_single_video">
			<?php
            if(trim($video_embed) == ''){
				if(preg_match('/youtube/', $video_url)){
					if(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches)){
						$output = '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="680" height="'.$video_ht.'" src="http://www.youtube.com/embed/'.$matches[1].'"  ></iframe>';
					}else{
						$output = __('Sorry that seems to be an invalid <strong>YouTube</strong> URL. Please check it again.', 'framework');
					}
				}elseif(preg_match('/vimeo/', $video_url)){
					if(preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $video_url, $matches)){
						$output = '<iframe src="http://player.vimeo.com/video/'.$matches[1].'" width="940" height="'.$video_ht.'" ></iframe>';
					}else {
						$output = __('Sorry that seems to be an invalid <strong>Vimeo</strong> URL. Please check it again. Make sure there is a string of numbers at the end.', 'framework');
					}
				}else {
					$output = __('Sorry that is an invalid YouTube or Vimeo URL.', 'framework');
				}
				
				echo $output;
		}else{
			echo stripslashes(htmlspecialchars_decode($video_embed));
		}?>
        </div>
        <!-- if images exists (slider)-->
        <?php } elseif($portfolio_images != '' ){?> 
                        <div class="portfolio_slider flexslider">
                        <ul class="slides">
							<?php
								$ids = explode(",", $portfolio_images );	
								$i=0;
								while( $i < count( $ids ) ){
									if( $ids[$i] ){
										// get image url
										$url = wp_get_attachment_image_src( $ids[$i] , 'full' );			
										echo '<li><img src="'.$url[0].'" /></li>';
									}
									$i++;
								}
								?>
                        </ul>
                        </div>
                        
                        <script type="text/javascript">
						jQuery.noConflict();
						jQuery(document).ready(function (){						
							jQuery( '.<?php echo $t_link;?>  .portfolio_slider').flexslider({
								animation: "slide",
								slideDirection: "horizontal",
								slideshowSpeed: 6000,
								animationDuration: 7000,
								directionNav: true,
								controlNav: false,
								pauseOnAction: true,
								pauseOnHover: true,
								animationLoop: true
							});
						});
						</script>
       <?php }else {?>
            <div class="portfolio-items">
            	<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" title="<?php the_title(); ?>" data-gal="prettyPhoto[pp_gal]"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" alt="" /></a>
            </div>
		<?php } ?>
       </div>
       <?php
       $full = '';
	   
	   if( get_post_meta( $post->ID, 'zp_portfolio_meta_item_value', true ) == 'true' ){ ?>
       <div class="metaItem">
                <h1 class="page-title"><?php echo the_title('','', FALSE);?></h1>                           
                <div class="authorStuff"><span><?php echo get_post_meta( $post->ID, 'zp_client_label_value', true ); ?></span><?php echo get_post_meta( $post->ID, 'zp_client_value', true ); ?></div>
                <div class="dateStuff"><span><?php echo get_post_meta( $post->ID, 'zp_date_label_value', true ); ?></span><?php echo get_post_meta( $post->ID, 'zp_date_value', true ); ?></div>
                <div class="categoryStuff"><span><?php echo get_post_meta( $post->ID, 'zp_category_label_value', true ); ?></span> <?php echo get_post_meta( $post->ID, 'zp_category_value', true ); ?></div>
                <div class="projectStuff"><a class=" button  medium-btn default" href="<?php echo get_post_meta($post->ID,'zp_visit_project_link_value', true);?>"><?php echo get_post_meta($post->ID,'zp_visit_project_label_value', true);	?></a> </div>
            </div>
<?php 
}else{
	$full = 'style="width:100%;"';		
}?>
<div class="folio-entry" <?php echo  $full; ?>>
                <?php the_content(); ?>
            </div>
</div><!-- end list-items -->
<?php  endwhile; ?>
<?php endif; ?>
</div><!-- end front_list-items -->
<?php
wp_reset_query();
}

/**
 * Portfolio Layout Function
 */
 
function zp_portfolio_template(  $col ){
	global $post, $paged, $wp_query;?>
    <h1 class="widgettitle"><?php echo genesis_get_option( 'zp_home_portfolio_title', ZP_SETTINGS_FIELD );?></h1>
    <p><?php echo genesis_get_option( 'zp_home_portfolio_desc', ZP_SETTINGS_FIELD );?></p>
    <?php
    
	echo zp_portfolio_filter();
	
	zp_portfolio_single_preview();
	if( $col == 3 )	$class = '3col';
	if( $col == 2 )	$class = '2col';
	if( $col == 4 )	$class = '4col';

	$args= array(
		'posts_per_page' =>'-1',
		'post_type' => 'portfolio'
	);
	query_posts($args);
?>
<div id="container" style="height: 680px;">
<div class="portfolio_loader"></div><?php
	$t_link = 0;
	$page= 0;
	$html= '';
	if(have_posts()) {
		while (have_posts()) {
			the_post();
			$t = get_the_title();
			$title_limit=substr($t, 0, 25);
			$permalink=get_permalink();
			$icon='';
			$title='<a href="'.$permalink.'" title="'.get_the_title().'">'.$title_limit.'</a>';
			$readmore='<span class="more-link" href="'.get_permalink().'">[...]</span>';
			if($post->post_content != "" && $post->post_excerpt != ""){
				$excerpt= $post->post_excerpt;
				$description= substr($excerpt, 0, 40);
			}else if($post->post_content != "" && $post->post_excerpt == ""){
				$excerpt= $post->post_content;
				$description= substr($excerpt, 0, 40);
			}else{
				$excerpt= get_the_excerpt();
				$description= substr($excerpt, 0, 40);
			}
			
			$t_link++;
			$page++;
			
			$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , $class ); 
			
			//get the image title
			//$data = explode('/', $thumbnail);
			//$image_title=explode(".jpg", $data[8]);
			
			$icon='gallery-image';
			$openLink='<div class="portfolio_image">';
			$closeLink='</div>';
			$span_icon='<div class="icon" style="display:none;"><h4><a href="#'.$t_link.'" class="item-desc">'.$t.'</a></h4></div>';
			
			$terms=wp_get_post_terms($post->ID, 'portfolio_category');
			$term_string='';
			foreach($terms as $term){
				$term_string.=($term->slug).',';
			}
			$term_string=substr($term_string, 0, strlen($term_string)-1);
			$samp=str_replace(" ","-",$term_string);
			$string = str_replace(","," ",$samp);
			$finale= $string." ".$page;
			
			//generate the final item HTML
			$html.= '<div class="element element-'.$class.' '.$finale.'" data-filter="'.$finale.'">'.$openLink.''.$span_icon.$thumbnail.$closeLink.'</div>';
			}
		}
		echo $html;
	?></div>
<?php
wp_reset_query();
}

/**
 * Portfolio Shortcode Function
 */
 function  zp_portfolio_shortcode(  $columns, $num_items, $type, $filter  ){
	 global $post, $paged;
	 
	 if(  $columns == 2  ){
		 $width=560;
		 $height = 400;
		 $column='2col';
		 $num_post = $num_items;
	}
	if(  $columns == 3  ){
		$width=345;
		$height = 230;
		$column='3col';
		$num_post = $num_items;
	}
	
	if(  $columns == 4  ){
		$width=245;
		$height = 165;
		$column='4col';
		$num_post = $num_items;
	}
	
	$html='';
	$output = '';
	
	$output .= '<div class="portfolio_shortcode">';
	
	if(  $filter  ){
		$output .= '<div id="options" class="clearfix">';
		$output .= '<ul id="portfolio-categories" class="option-set" data-option-key="filter"><li><a href="#" data-option-value="*" class="selected">show all</a></li>';
		
		$term_args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'taxonomy' => 'portfolio_category'
		);
		
		$categories = get_categories( $term_args );
			foreach( $categories as $category ) :
				$tms=str_replace( " ","-",$category->name );
				$output .= '<li><a class="active" href="#" data-option-value=".'.$category->slug.'">'.$category->name.'</a></li>';
				endforeach;
				$output .= '</ul></div>';
		}
		
		// check if it is the taxonomy page
		
		if(  !is_tax(  'portfolio_category'  )  ){
			$paged = get_query_var( 'paged' );
			
			$args= array(
				'posts_per_page' =>$num_post,
				'post_type' => 'portfolio',
				'paged' => $paged,
				'orderby' => 'date',
				'order' => 'DESC'
			);
			query_posts( $args );
		}
		
		$output .= '<div id="container" style="height: auto; width: 100%;">';
		
		if(  have_posts(  )  ) {
			while (  have_posts(  )  ) {
				the_post(  );
					$t = get_the_title(  );
					$permalink = get_permalink(  );
					
					$icon='';

					$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , $column ); 
					
					//get the image title
					
					$openLink='<div class="portfolio_image">';
					$closeLink='</div>';
					
					$type = ( $type == 'portfolio' )? true : false;
					
					if(  $type  ){
						$span_icon='<div class="icon" style="display:none" ><h4><a href="'.$permalink.'" class="item-desc">'.$t.'</a></h4></div>';
					}else{
						$span_icon='<div class="icon" style="display:none" ><h4><a href="'.wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  ).'" data-gal="prettyPhoto[pp_gal]" title="'.$t.'" class="item-desc">'.$t.'</a></h4></div>';
					}
					$terms=wp_get_post_terms( $post->ID, 'portfolio_category' );
					$term_string='';
					foreach( $terms as $term ){
						$term_string.=( $term->slug ).',';
					}
					
					$term_string=substr( $term_string, 0, strlen( $term_string )-1 );
					$samp=str_replace( " ","-",$term_string );
					$string = str_replace( ","," ",$samp );
					$finale= $string." ";
					
					//generate the final item HTML
					
					$html.= '<div class="element element-'.$column.' '.$finale.'" data-filter="'.$finale.'">'.$openLink.''.$span_icon.$thumbnail.$closeLink.'</div>';
			}
				}
			
			$output .= $html;
			$output .= '</div>';
			$output .= '</div>';
			
			wp_reset_query(  );
			return $output;
	}
	
/**
 * Validate if the menu items exist in the sidebars
 */
function zp_validate_menu_and_sidebar( $menu_item ){
	$counter=0;
	$exist='';
	$sidebars = zp_retrieve_sidebar_id();
	
	while( $counter < count($sidebars)){
		if( $menu_item == 'portfolio' || $menu_item == 'latest-blog' ){
			$exist = true;
			break;
		}
		elseif( $menu_item == $sidebars[$counter]){
			$exist = true;
			break;
		}
		$counter++;
	}
	
	if($exist)
		return true;
	else
		return false;
}

/**
 * Retrive all sidebar ID's
 */
 
 function zp_retrieve_sidebar_id(){
	 $i=0;
	 $zp_sidebar_id = array();
	 foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
		 $zp_sidebar_id[$i] = $sidebar['id'];
		 $i++;
	 }
	 return $zp_sidebar_id;
 }

/**
 * Retrive all primary nav items
 */
 function zp_retrieve_primary_nav_items(){
	 $counter = 0;
	 $menu_name = 'primary';
	 
	 if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		 $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		 $menu_items = wp_get_nav_menu_items($menu->term_id);
		 
		 foreach ( (array) $menu_items as $key => $menu_item ) {
			 $title[$counter] = $menu_item->title;
			 $title_url = explode("#", $menu_item->url);
			 if( !empty( $title_url[1]))
			 	$url[$counter]  = $title_url[1];
			else
				$url[$counter]  = '';
				$counter++;
		}
	}
	return $url;
 }

/**
 * Display Home Page Widgets
 */
function zp_display_home_page( $menu_item ){
	global $post;
	
	if( $menu_item == 'portfolio'){?>
    	<div id="portfolio" class="home_widget">
        	<div class="wrap">
            	<?php if((genesis_get_option('zp_front_enable', ZP_SETTINGS_FIELD ) == true ) ){
					$portfolio_col = genesis_get_option( 'zp_home_portfolio_columns', ZP_SETTINGS_FIELD );
				?>
                <div id="portfolio_front" class="home_widget_area">
				<?php zp_portfolio_template( $portfolio_col  ); ?>
                </div><div class="clearfix"></div>
				<?php
     }
	?></div>
    </div><?php
   }elseif($menu_item == 'latest-blog'){?>
               <?php if(genesis_get_option('zp_latest_blog_enable', ZP_SETTINGS_FIELD ) == true):?>
               <div id="latest-blog" class="home_widget latest_blog">
               		<div class="wrap">
                    	<div class="home_widget_area">
                        	<h1 class="widgettitle"><?php echo $title = genesis_get_option('zp_latest_blog_title', ZP_SETTINGS_FIELD ) ? genesis_get_option('zp_latest_blog_title', ZP_SETTINGS_FIELD): "Latest Blogs"; ?></h1>
                    <?php if(genesis_get_option('zp_latest_blog_desc', ZP_SETTINGS_FIELD) == true ){ ?><p><?php echo genesis_get_option('zp_latest_blog_desc', ZP_SETTINGS_FIELD ); ?></p><?php } ?>
                        <div class="latest_blog_container">
                            <ul>
                            <?php
								$counter=0;
                                $blog_number = genesis_get_option('zp_latest_blog_items', ZP_SETTINGS_FIELD ) ? genesis_get_option('zp_latest_blog_items', ZP_SETTINGS_FIELD): "3";
								$blog_cat = genesis_get_option('zp_latest_blog_category' , ZP_SETTINGS_FIELD );
								$blog_columns = genesis_get_option('zp_home_blog_columns' , ZP_SETTINGS_FIELD );
                                $args = array( 'post_type' => 'post', 'posts_per_page'=> $blog_number, 'category_name' => $blog_cat);
                                query_posts($args);

                                if(have_posts()) {
									while (have_posts()) {
										the_post();
										$counter++;
										$description= substr(get_the_excerpt(), 0, 100);
										$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , 'home_blog' ); 
								
								if( $blog_columns == '2'){
									$col = 'one-half';
								}
								if( $blog_columns == '3'){
									$col = 'one-third';
								}
								if( $blog_columns == '4'){
									$col = 'one-fourth';
								}

								$last = ( ($counter % $blog_columns) == 0 )? 'nomargin' : '';
                            ?>
                            <li class="<?php echo $col; ?> columns <?php echo $last; ?>">
                            	<div class="blog_content">
                                	<a href="<?php echo get_permalink();?>">
                                    <span class="blog_hover"></span>
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , 'home_blog' ); ?>
                                    </a>
                                    <h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>                                
                                <p class="entry-meta">
                                	<?php echo do_shortcode('[post_date]');?>
                                	<span class="entry-author"><?php echo __( 'By ', 'single' ) ?>  <?php echo the_author_posts_link(); ?> </span>
                                    <span class="entry-comments-link"><a href="<?php comments_link();?>"><?php comments_number( 'Leave a comment', '1 Comment', '% Comments' );?></a> </span>
                                </p>

                                <p><?php echo $description.'...'; ?></p>
                                    <p class="entry-meta"><?php echo __( 'Filed Under: ', 'single' ) ?> <?php echo get_the_category_list(  $post->ID  ); ?></p>
                                  </div>
                                </li>
                          <?php
                          	}
						}?>
                        </ul>
                        </div>
                        </div>
                        </div>
                        </div>

            <?php endif; wp_reset_query(); ?>
			<?php }else{ ?>
            <div id="<?php echo $menu_item?>" class="home_widget">
            	<div class="wrap">
                <?php if(is_active_sidebar($menu_item)):?>
                	<div class="<?php echo $menu_item; ?> home_widget_area">
                    	<div class="widget">
							<?php dynamic_sidebar($menu_item); ?>
                        </div>
                   </div>
				   <?php endif;?>
             </div>
            </div>
	<?php
    }
}

/**
 * Recent Post Shortcode Function
 */
function zp_post_shortcode( $columns, $blog_items, $blog_cat  ) {
	global $post;
	
	$_values = array();
	
	if(  $columns == 2  ){
		$width=560;
		$height = 400;
		$column='2col';
	}
	
	if(  $columns == 3  ){
		$width=333;
		$height = 200;
		$column='3col';
	}
	if(  $columns == 4  ){
		$width=245;
		$height = 165;
		$column='4col';
	}
	
	$args = array( 'post_type' => 'post', 'posts_per_page'=> $blog_items , 'category_name' => $blog_cat);
	query_posts($args);
	
	$output = '';
	$html='';
	
	$output .= ' <div  class="blog_feature_shortcode">';
	$output .= '<ul class="blog_slides">';
	
	if(have_posts()) {
		while (have_posts()) {
			the_post();
			
			$description = get_the_content_limit( 150, '' );
			$Old     = array( '<p>', '</p>' );
			$description = str_replace( $Old ,'', $description );

			$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , $column ); 
			
			$html .= '<li class="element-'.$column.'">';
			$html .= '<div class="shortcode_blog_feature">';
			$html .= '<div class="shortcode_blog_feature_image">';
			$html .= '<a href="'.get_permalink().'" style="height: '.$height.'px;">'.$thumbnail.'</a>';
			$html .= '</div>';
			$html .= '<div class="shortcode_blog_feature_content"><h3><a href="'. get_permalink().'">'.get_the_title().'</a></h3>';
			$html .= '<div class="shortcode_blog_feature_meta"><span class="shortcode_home_blog_post_meta">'.get_the_date( 'F j, Y' ).'</span>';
			$html .= '<span class="post_box_comments">';
			$html .= '<a href="'. get_comments_link( $post->ID ).'">'.zp_custom_comment_number().'</a>';
			$html .= '</span></div>';
			$html .= '<p>'.$description.'[...]</p>';
		}
		
		$html .= '</div></div></li>';
	}
	wp_reset_query();
	
	$output .= $html;
	$output .= '</ul>';
	$output .= '</div>';
	return $output;
}

/**
 * Return Comment Number
 */

function zp_custom_comment_number(  ){
	global $post;
	
	$num_comments = get_comments_number();
	
	if ( $num_comments == 0 ) {
		$comments = __('No Comments', 'single');
	} elseif ( $num_comments > 1 ) {
		$comments = $num_comments . __(' Comments','single' );
	} else {
		$comments = __('1 Comment','single' );
	}
	return $comments;
}