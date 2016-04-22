<?php get_header();
$content_class = '';
$evl_portfolio_layout_archive_category = evolve_get_option('evl_portfolio_layout_archive_category', 'Portfolio One Column');
$evl_width_px = evolve_get_option('evl_width_px', '1200');
$evl_portfolio_sidebar = evolve_get_option('evl_portfolio_sidebar', 'None');

if ($evl_portfolio_layout_archive_category == 'Portfolio One Column' && $evl_portfolio_sidebar == '0') {
    $portfolio_layout = 'portfolio portfolio-one portfolio-one-page';
    $sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-page-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-page-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-page-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-page-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-page-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-page-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-page-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-page-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-page-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-page-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-page-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-page-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio One Column Text' && $evl_portfolio_sidebar == '0') {
    $portfolio_layout = 'portfolio portfolio-one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-text-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-text-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-text-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-text-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-text-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-text-800';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-text-1600';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-text-985';
	$sidebar_exists = false;
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar == '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-text-800';
	$sidebar_exists = false;
}

$evl_portfolio_sidebar = evolve_get_option('evl_portfolio_sidebar', 'None');
$evl_portfolio_sidebar_position = evolve_get_option('evl_portfolio_sidebar_position', 'right');

if ($evl_portfolio_sidebar_position == 'left' && $evl_portfolio_sidebar != '0') {
    $content_css = 'display:block;';
	$sidebar_css = 'display:block;';
	$content_class = 'col-md-8 col-md-push-4';
	$sidebar_class = 'col-md-4 col-md-pull-8';
	$sidebar_exists = true;
} elseif ($evl_portfolio_sidebar_position == 'right' && $evl_portfolio_sidebar != '0') {
	$content_css = 'display:block;';
	$sidebar_css = 'display:block;';
	$content_class = 'col-md-8';
	$sidebar_class = 'col-md-4';
	$sidebar_exists = true;
} elseif ($evl_portfolio_sidebar == '0') {
	$content_css = 'width:100%';
	$sidebar_exists = false;
}

if ($evl_portfolio_layout_archive_category == 'Portfolio One Column' && $evl_portfolio_sidebar != '0') {
    $portfolio_layout = 'portfolio portfolio-one portfolio-one-page portfolio-one-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-sidebar-page portfolio-two-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-sidebar-page portfolio-two-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-sidebar-page portfolio-two-sidebar-page-800';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-sidebar-page portfolio-three-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-sidebar-page portfolio-three-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-sidebar-page portfolio-three-sidebar-page-800';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-sidebar-page portfolio-four-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-sidebar-page portfolio-four-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-sidebar-page portfolio-four-sidebar-page-800';

} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-sidebar-page portfolio-grid-mansory-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-sidebar-page portfolio-grid-mansory-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Grid' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-grid-mansory portfolio-grid-mansory-page portfolio-grid-mansory-sidebar-page portfolio-grid-mansory-sidebar-page-800';
	
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio One Column Text' && $evl_portfolio_sidebar != '0') {
    $portfolio_layout = 'portfolio portfolio-one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page portfolio-two-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page portfolio-two-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page portfolio-two-sidebar-page-800';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page portfolio-three-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page portfolio-three-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page portfolio-three-sidebar-page-800';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1200) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 1600) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page portfolio-four-sidebar-page-1600';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 985) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page portfolio-four-sidebar-page-985';
} elseif ($evl_portfolio_layout_archive_category == 'Portfolio Four Column Text' && $evl_portfolio_sidebar != '0' && $evl_width_px == 800) {
    $portfolio_layout = 'portfolio portfolio-four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page portfolio-four-sidebar-page-800';
}

?>
<div id="content" class="portfolio-template <?php echo $portfolio_layout . ' ' . $content_class; ?>" style="<?php echo $content_css; ?>">
    <div class="entry-title"><?php echo single_cat_title('', true); ?></div>


    <?php if (category_description()): ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
            <div class="post-content">
                <?php echo category_description(); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="portfolio-wrapper">
        <?php
        while (have_posts()): the_post();
            if (has_post_thumbnail()):
                ?>
                <?php
                $item_classes = '';
                $item_cats = get_the_terms($post->ID, 'portfolio_category');
                if ($item_cats):
                    foreach ($item_cats as $item_cat) {
                        $item_classes .= $item_cat->slug . ' ';
                    }
                endif;
                ?>
                <div class="portfolio-item <?php echo $item_classes; ?>">
                    <span class="entry-title" style="display: none;"><?php the_title(); ?></span>
                    <span class="vcard" style="display: none;"><span class="fn"><?php the_author_posts_link(); ?></span></span>
                    <span class="updated" style="display:none;"><?php the_modified_time('c'); ?></span>	              
                    <div class="image" aria-haspopup="true">
                        <?php
                                    $evl_portfolio_rollover = evolve_get_option('evl_portfolio_rollover', '1');
                                    if ($evl_portfolio_rollover == 0):
                                        ?>
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                                    <?php else: ?>
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
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
                                <a style="<?php echo $zoom_icon_css; ?>" class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id($post->ID)); ?>"><img style="display:none;" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true); ?>" />Gallery</a>
                                <br /><h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<br /><h4><?php echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''); ?></h4>             							
                            </div>
                        </div>
						<?php endif; ?>
                    </div>
                    <?php if ($evl_portfolio_layout_archive_category == 'Portfolio One Column Text' || $evl_portfolio_layout_archive_category == 'Portfolio Two Column Text' || $evl_portfolio_layout_archive_category == 'Portfolio Three Column Text' || $evl_portfolio_layout_archive_category == 'Portfolio Four Column Text') { ?>
                        <div class="portfolio-content clearfix">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <h4><?php echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''); ?></h4>
                            <div class="post-content">
                                <?php
                                    $excerpt_length = $evl_options['evl_portfolio_excerpt_length'];
                                    $strip_html = $evl_options['evl_portfolio_strip_html'];
                                    ?>
                                    <?php
                                    if ($evl_options['evl_portfolio_excerpt_full_content'] == 'Excerpt') {
                                        $stripped_content = strip_shortcodes(t4p_content($excerpt_length, $strip_html));
                                        echo $stripped_content;
                                    } else {
                                        the_content();
                                    }
                                    ?>
                            </div>
                            
                                <div class="buttons">
										<a href="<?php the_permalink(); ?>" class="<?php echo sprintf('read-more btn btn-default button medium t4p-button button-medium button-default button-%s button-%s', strtolower($smof_data['button_shape']), strtolower($smof_data['button_type'])); ?>"><?php echo __('Learn More', 'evolve'); ?></a>            
                                    <?php if (get_post_meta($post->ID, 'pyre_project_url', true)): ?>
                                        <a href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>" class="<?php echo sprintf('read-more btn btn-default button medium t4p-button button-medium button-default button-%s button-%s', strtolower($evl_options['evl_shortcode_button_shape']), strtolower($evl_options['evl_shortcode_button_type'])); ?>"><?php echo __('View Project', 'evolve'); ?></a>            
                                    <?php endif; ?>
                                </div>
                            
                        </div>
					<?php } ?>               
                </div>
                <?php
            endif;
        endwhile;
        ?>
    </div>
	<div class="text-center">
    <?php t4p_pagination($pages = '', $range = 2); ?>   
	</div>
</div>
<?php if ($sidebar_exists == true): ?>
    <?php wp_reset_query(); ?>  
    <div id="sidebar" style="<?php echo $sidebar_css; ?>" class="<?php echo $sidebar_class; ?>"><?php generated_dynamic_sidebar($evl_portfolio_sidebar); ?></div>
<?php endif; ?>  
<?php get_footer(); ?>