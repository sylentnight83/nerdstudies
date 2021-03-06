			<?php global $smof_data; ?>
			<?php global $post; ?>

			<?php if($atts['layout'] != 'grid' && $atts['layout'] != 'timeline'): ?>
			<style type="text/css" scoped>
			<?php if(get_post_meta($post->ID, 'pyre_fimg_width', true) && get_post_meta($post->ID, 'pyre_fimg_width', true) != 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow
			{max-width:<?php echo get_post_meta($post->ID, 'pyre_fimg_width', true); ?> !important;}
			<?php endif; ?>

			<?php if(get_post_meta($post->ID, 'pyre_fimg_height', true) && get_post_meta($post->ID, 'pyre_fimg_height', true) != 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img
			{height:<?php echo get_post_meta($post->ID, 'pyre_fimg_height', true); ?> !important;}
			<?php endif; ?>

			<?php if(get_post_meta($post->ID, 'pyre_fimg_width', true) && get_post_meta($post->ID, 'pyre_fimg_width', true) == 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img{
				width:auto;
			}
			<?php endif; ?>

			<?php if(get_post_meta($post->ID, 'pyre_fimg_height', true) && get_post_meta($post->ID, 'pyre_fimg_height', true) == 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img{
				height:auto;
			}
			<?php endif; ?>

			<?php
			if(
				get_post_meta($post->ID, 'pyre_fimg_height', true) && get_post_meta($post->ID, 'pyre_fimg_width', true) &&
				get_post_meta($post->ID, 'pyre_fimg_height', true) != 'auto' && get_post_meta($post->ID, 'pyre_fimg_width', true) != 'auto'
			) { ?>
			@media only screen and (max-width: 479px){
				#post-<?php echo $post->ID; ?> .post-slideshow,
				#post-<?php echo $post->ID; ?> .floated-post-slideshow,
				#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
				#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
				#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
				#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img{
					width:auto !important;
					height:auto !important;
				}
			}
			<?php }
			?>
			</style>
			<?php endif; ?>

			<?php
			if(get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'link') {
				$link_icon_css = 'display:inline-block;';
				$zoom_icon_css = 'display:none;';
			} elseif(get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'zoom') {
				$link_icon_css = 'display:none;';
				$zoom_icon_css = 'display:inline-block;';
			} elseif(get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'no') {
				$link_icon_css = 'display:none;';
				$zoom_icon_css = 'display:none;';
			} else {
				$link_icon_css = 'display:inline-block;';
				$zoom_icon_css = 'display:inline-block;';
			}

			$icon_url_check = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true); if(!empty($icon_url_check)) {
				$permalink = get_post_meta($post->ID, 'pyre_link_icon_url', true);
			} else {
				$permalink = get_permalink($post->ID);
			}
			?>

			<?php
			if(is_page_template('full-width.php') || get_post_meta($post->ID, 'pyre_full_width', true) == 'yes') {
				$size = 'full';
			} else {
				$size = 'blog-large';
			}

			if($atts['layout'] == 'medium' || $atts['layout'] == 'medium alternate') {
				$size = 'blog-medium';
			}

			if(
				get_post_meta($post->ID, 'pyre_fimg_height', true) && get_post_meta($post->ID, 'pyre_fimg_width', true) &&
				get_post_meta($post->ID, 'pyre_fimg_height', true) != 'auto' && get_post_meta($post->ID, 'pyre_fimg_width', true) != 'auto'
			) {
				$size = 'full';
			}

			if(
				get_post_meta($post->ID, 'pyre_fimg_height', true) == 'auto' ||get_post_meta($post->ID, 'pyre_fimg_width', true) == 'auto'
			) {
				$size = 'full';
			}
			
			if($atts['layout'] == 'grid' || $atts['layout'] == 'timeline') {
				$size = 'full';
			}
			?>

			<?php
			if(has_post_thumbnail() ||
			get_post_meta(get_the_ID(), 'pyre_video', true)
			):
			?>
      <?php if($atts['layout'] == 'large' || $atts['layout'] == 'large alternate' || $atts['layout'] == 'grid' || $atts['layout'] == 'timeline'): ?>
			<div class="t4p-flexslider flexslider post-slideshow">
      <?php endif; ?>
			<?php if($atts['layout'] == 'medium' || $atts['layout'] == 'medium alternate'): ?>
			<div class="t4p-flexslider flexslider blog-medium-image floated-post-slideshow">
			<?php endif; ?>      
				<ul class="slides">
					<?php if(get_post_meta(get_the_ID(), 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta(get_the_ID(), 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail()): ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<div class="image" aria-haspopup="true">
								<?php if($smof_data['image_rollover']): ?>
								<?php the_post_thumbnail($size); ?>
								<?php else: ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size); ?></a>
								<?php endif; ?>
								<div class="image-extras">
									<div class="image-extras-content">
										<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
										<a style="<?php echo $link_icon_css; ?>" class="icon link-icon" href="<?php echo $permalink; ?>">Permalink</a>
										<?php
										if(get_post_meta($post->ID, 'pyre_video_url', true)) {
											$full_image[0] = get_post_meta($post->ID, 'pyre_video_url', true);
										}
										?>
										<a style="<?php echo $zoom_icon_css; ?>" class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img style="display:none;" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />Gallery</a>
										<br /><h3><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h3>
										<h4><span class="cats"><?php echo get_the_term_list($post->ID, 'category', '', ', ', ''); ?></span></h4>                    
									</div>
								</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($smof_data['posts_slideshow']): ?>
					<?php
					$i = 2;
					while($i <= $smof_data['posts_slideshow_number']):
					$attachment_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
					if($attachment_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_id, $size); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_id); ?>
					<li>
						<div class="image">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment_data['image_meta']['title']; ?>" /></a>
								<a style="display:none;" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]"  title="<?php echo get_post_field('post_excerpt', $attachment_id); ?>"><img style="display:none;" alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>" /></a>
						</div>
					</li>
					<?php endif; $i++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
      <?php endif; ?>