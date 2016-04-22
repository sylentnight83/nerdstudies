<?php 
// Single Portfolio
get_header(); ?>
<?php
global $smof_data;
if (get_post_meta($post->ID, 'pyre_width', true) == 'half') {
    $portfolio_width = 'half col-md-12';
} else {
    $portfolio_width = 'full col-md-12';
}
?>
<?php
$content_css = isset($content_css) ? $content_css : '';
$sidebar_css = isset($sidebar_css) ? $sidebar_css : '';
$class = '';
$sidebar_exists = true;
$sidebar_check = get_post_meta($post->ID, 'pyre_sidebar', true);
if (get_post_meta($post->ID, 'pyre_sidebar', true) == 'no' || empty($sidebar_check) || !isset($sidebar_check)) {
    $content_css = 'width:100%';
    $sidebar_css = 'display:none';
    $sidebar_exists = false;
} elseif (get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
    $content_css = 'float:right; width: 66%; padding-right: 2%; padding-left: 2%;';
    $sidebar_css = 'float:left; width: 30%;';
    $class = 'with-sidebar';
} elseif (get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
    $content_css = 'float:left; width: 66%; padding-right: 2%; padding-left: 2%;';
    $sidebar_css = 'float:left; width: 30%;';
    $class = 'with-sidebar';
} elseif (get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default') {
    $content_css = 'float:left; width: 66%; padding-right: 2%; padding-left: 2%;';
    $sidebar_css = 'float:left; width: 30%;';
    $class = 'with-sidebar';
}
?>

<div id="content" class="portfolio-<?php echo $portfolio_width; ?> <?php echo $class; ?>" style="<?php echo $content_css; ?>">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
    <?php query_posts($query_string . '&paged=' . $paged); ?>
    <?php
    $nav_categories = '';
    if (isset($_GET['portfolioID'])) {
        $portfolioID = array($_GET['portfolioID']);
    } else {
        $portfolioID = '';
    }
    if (isset($_GET['categoryID'])) {
        $categoryID = $_GET['categoryID'];
    } else {
        $categoryID = '';
    }
    $page_categories = get_post_meta($portfolioID, 'pyre_portfolio_category', true);
    if ($page_categories && is_array($page_categories) && $page_categories[0] !== '0') {
        $nav_categories = implode(',', $page_categories);
    }
    if ($categoryID) {
        $nav_categories = $categoryID;
    }
    ?>

    <?php
    // Portfolio Navigation 
	$evl_portfolio_disable_pagination = evolve_get_option('evl_portfolio_disable_pagination', '0');	
	?>
    <?php if (!$evl_portfolio_disable_pagination): ?>
        <div class="single-navigation clearfix">
            <?php
            if ($portfolioID || $categoryID) {
                $previous_post_link = t4p_previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'evolve'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
            } else {
                $previous_post_link = t4p_previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'evolve'), 'return' => 'href'));
            }
            ?>
            <?php
            if ($previous_post_link):
                if ($portfolioID || $categoryID) {
                    if ($portfolioID) {
                        $previous_post_link = t4p_addUrlParameter($previous_post_link, 'portfolioID', $portfolioID);
                    } else {
                        $previous_post_link = t4p_addUrlParameter($previous_post_link, 'categoryID', $categoryID);
                    }
                }
                ?>
                <a href="<?php echo $previous_post_link; ?>" class="prev" rel="prev"><?php _e('Previous', 'evolve'); ?></a>
            <?php endif; ?>
            <?php
            if ($portfolioID || $categoryID) {
                $next_post_link = t4p_next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'evolve'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
            } else {
                $next_post_link = t4p_next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'evolve'), 'return' => 'href'));
            }
            ?>
            <?php
            if ($next_post_link):
                if ($portfolioID || $categoryID) {
                    if ($portfolioID) {
                        $next_post_link = t4p_addUrlParameter($next_post_link, 'portfolioID', $portfolioID);
                    } else {
                        $next_post_link = t4p_addUrlParameter($next_post_link, 'categoryID', $categoryID);
                    }
                }
                ?>
                <a href="<?php echo $next_post_link; ?>" class="next" rel="next"><?php _e('Next', 'evolve'); ?></a>
            <?php endif; ?>
        </div>
        <?php // End Portfolio Navigation ?>

    <?php endif; ?>
    <?php if (have_posts()): the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            $full_image = '';
			$evl_portfolio_featured_image_video = evolve_get_option('evl_portfolio_featured_image_video', '1');
	
            if (!post_password_required($post->ID)): // 1
                if( $evl_portfolio_featured_image_video ): // 2                 
                ?>
                <div class="t4p-flexslider flexslider post-slideshow">
                    <ul class="slides">
                        <?php if (get_post_meta($post->ID, 'pyre_video', true)): ?>
                            <li>
                                <div class="full-video">
                                    <?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
                                </div>
                            </li>
                        <?php endif; ?> 
                        <?php if (has_post_thumbnail() && get_post_meta($post->ID, 'pyre_show_first_featured_image', true) != 'yes'): ?>                       
                            <?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                            <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                            <?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
                            <li>
							<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
                                          
                            </li>
                        <?php endif; ?>                        
                    </ul>
                </div>
                <?php endif; // 3 ?>
                <?php //endif; // 2 portfolio single image theme option check ?>
            <?php endif; // 1 password check ?> 
            <?php
            $project_info_style = '';
            $project_desc_style = '';
            $project_desc_title_style = '';
            if (get_post_meta($post->ID, 'pyre_project_details', true) == 'no') {
                $project_info_style = 'display:none;';
            }
            if ($portfolio_width == 'full' && get_post_meta($post->ID, 'pyre_project_details', true) == 'no') {
                $project_desc_style = 'width:100%;';
            }
            if (get_post_meta($post->ID, 'pyre_project_desc_title', true) == 'no') {
                $project_desc_title_style = 'display:none;';
            }
            ?>
            <div class="project-content">
                <span class="entry-title" ><?php the_title(); ?></span>
                <span class="vcard" style="display: none;"><span class="fn"><?php the_author_posts_link(); ?></span></span>
                <span class="updated" style="display: none;"><?php the_modified_time('c'); ?></span>      
                <div class="project-description post-content" style="<?php echo $project_desc_style; ?>">
                    <?php if (!post_password_required($post->ID)): ?>        
                        <div class="title"><h2><?php echo __('Job Description', 'evolve') ?></h2><div class="title-sep-container"><div class="title-sep"></div></div></div>
                    <?php endif; ?>          
                    <?php the_content(); ?>
                </div>
                <?php if (!post_password_required($post->ID)): ?>        
                    <div class="project-info" style="<?php echo $project_info_style; ?>">
                        <div class="title"><h4><?php echo __('Project Details', 'evolve') ?></h4><div class="title-sep-container"><div class="title-sep"></div></div></div><div class="clearfix"></div>
                        <?php if (get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', '')): ?>          
                            <div class="project-info-box">
                                <h4><?php echo __('Skills', 'evolve') ?>:</h4>
                                <div class="project-terms">
                                    <?php echo get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', ''); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (get_the_term_list($post->ID, 'portfolio_category', '', '<br />', '')): ?>
                            <div class="project-info-box">
                                <h4><?php echo __('Categories', 'evolve') ?>:</h4>
                                <div class="project-terms">
                                    <?php echo get_the_term_list($post->ID, 'portfolio_category', '', '<br />', ''); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (get_the_term_list($post->ID, 'portfolio_tags', '', '<br />', '')): ?>
                            <div class="project-info-box">
                                <h4><?php echo __('Tags', 'evolve') ?>:</h4>
                                <div class="project-terms">
                                    <?php echo get_the_term_list($post->ID, 'portfolio_tags', '', '<br />', ''); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (get_post_meta($post->ID, 'pyre_project_url', true) && get_post_meta($post->ID, 'pyre_project_url_text', true)): ?>
                            <div class="project-info-box">
                                <span><a class="read-more btn t4p-button-default" href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_project_url_text', true); ?></a></span>
                            </div>
                        <?php endif; ?>
                        <?php if (get_post_meta($post->ID, 'pyre_copy_url', true) && get_post_meta($post->ID, 'pyre_copy_url_text', true)): ?>
                            <div class="project-info-box">
                                <h4><?php echo __('Copyright', 'evolve'); ?>:</h4>
                                <span><a href="<?php echo get_post_meta($post->ID, 'pyre_copy_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_copy_url_text', true); ?></a></span>
                            </div>
                        <?php endif; ?>
                        <?php 						
						$evl_portfolio_author = evolve_get_option('evl_portfolio_author', '0');
						if ($evl_portfolio_author): 
							?>
                            <div class="project-info-box vcard">
                                <h4><?php echo __('By', 'evolve'); ?>:</h4><span class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>        
            </div>
            <div class="portfolio-sep"></div>
            <?php if (!post_password_required($post->ID)): ?> 
                <?php				
				$evl_portfolio_sharing_box = evolve_get_option('evl_portfolio_sharing_box', '1');
                if ($evl_portfolio_sharing_box):
				
				//Coming Soon 
				?>
									
                <?php endif; ?>
                <?php
                $evl_portfolio_related_posts_number = evolve_get_option('evl_portfolio_related_posts_number', '5');
				$evl_portfolio_related_posts = evolve_get_option('evl_portfolio_related_posts', '1');
                ?>
                <?php
                if (($evl_portfolio_related_posts && get_post_meta($post->ID, 'pyre_related_posts', true) != 'no' ) ||
                        (!$evl_portfolio_related_posts && get_post_meta($post->ID, 'pyre_related_posts', true) == 'yes' )):
                    ?>
                    <?php $projects = get_related_projects($post->ID, $evl_portfolio_related_posts_number); ?>
                    <?php if ($projects->have_posts()): ?>
                        <div class="related-posts related-projects">
                            <div class="t4p-title title"><h2 class="title-heading-left"><?php echo __('Related Work', 'evolve'); ?></h2><div class="title-sep-container"><div class="title-sep"></div></div></div><div class="clearfix"></div>
                            <div id="carousel" class="es-carousel-wrapper t4p-carousel-large">
                                <div class="es-carousel">
                                    <ul>
                                        <?php while ($projects->have_posts()): $projects->the_post(); ?>
                                            <?php if (has_post_thumbnail()): ?>
                                                <li>
                                                    <div class="image" aria-haspopup="true">
                                                        <?php
                                                        $evl_portfolio_rollover = evolve_get_option('evl_portfolio_rollover', '1');
                                                        if ($evl_portfolio_rollover == 0):
                                                            ?>
                                                          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('related-img'); ?></a>
                                                        <?php else: ?>
                                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('related-img'); ?></a>
                                                        <?php endif; ?>
                                                        <?php
                                                        if (get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'link') {
                                                            $link_icon_css = 'display:inline-block;';
                                                            $zoom_icon_css = 'display:none;';
                                                        } elseif (get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'zoom') {
                                                            $link_icon_css = 'display:none;';
                                                            $zoom_icon_css = 'display:inline-block;';
                                                        } elseif (get_post_meta($post->ID, 'pyre_image_rollover_icons', true) == 'no') {
                                                            $link_icon_css = 'display:none;';
                                                            $zoom_icon_css = 'display:none;';
                                                        } else {
                                                            $link_icon_css = 'display:inline-block;';
                                                            $zoom_icon_css = 'display:inline-block;';
                                                        }

                                                        $icon_url_check = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true);
                                                        if (!empty($icon_url_check)) {
                                                            $icon_permalink = get_post_meta($post->ID, 'pyre_link_icon_url', true);
                                                        } else {
                                                            $icon_permalink = get_permalink($post->ID);
                                                        }
                                                        ?>
                                                        <div class="image-extras">
                                                            <div class="image-extras-content">
                                                                <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                                                                <a style="<?php echo $link_icon_css; ?>" class="icon link-icon" href="<?php echo $icon_permalink; ?>">Permalink</a>
                                                                <?php
                                                                if (get_post_meta($post->ID, 'pyre_video_url', true)) {
                                                                    $full_image[0] = get_post_meta($post->ID, 'pyre_video_url', true);
                                                                }
                                                                ?>
                                                                <a style="<?php echo $zoom_icon_css; ?>" class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[galleryrelated]">Gallery</a>
                                                                <br /><h3><a href="<?php echo $icon_permalink; ?>"><?php the_title(); ?></a></h3>                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            endif;
                                        endwhile;
                                        ?>
                                    </ul>
                                </div>
                                <div class="es-nav"><span class="es-nav-prev"></span><span class="es-nav-next"></span></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
				<?php 
				$evl_portfolio_comments = evolve_get_option('evl_portfolio_comments', '0');
				?>
                <?php if ($evl_portfolio_comments): ?>
                    <?php
                    wp_reset_query();
                    comments_template('', true);
                    ?>
                <?php endif; ?>
            <?php endif; ?>      
        </div>
    <?php endif; ?>      
</div>
<?php if ($sidebar_exists == true): ?>  
    <?php wp_reset_query(); ?>  
    <div id="sidebar" style="<?php echo $sidebar_css; ?>"><?php generated_dynamic_sidebar(); ?></div>
<?php endif; ?>  
<?php get_footer(); ?>