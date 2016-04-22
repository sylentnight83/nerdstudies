<?php
/**
 * Template: Sidebar.php
 *
 * @package EvoLve
 * @subpackage Template
 */
$sidebar_css = '';
if (class_exists('Woocommerce')) {
    if (is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
        $sidebar_css = 'display:none';
    }
}
?>
<!--BEGIN #secondary .aside-->
<div id="secondary" class="aside <?php evolve_sidebar_class(); ?>"
     <?php
     if (class_exists('Woocommerce')):
         echo 'style="' . $sidebar_css . '"';
     endif;
     ?>>

    <?php
    /* Widgetized Area */
    if (is_single() || is_page() || is_404() || is_search() || is_bbpress()) {

        if (is_bbpress()) {
            if (evolve_get_option('evl_bbpress_global_sidebar', '0') == 1) {
                $sidebar = evolve_get_option('evl_ppbress_sidebar', 'None');
                generated_dynamic_sidebar($sidebar);
            } else {
                generated_dynamic_sidebar();
            }
        } else {
            generated_dynamic_sidebar();
        }
    } elseif (is_archive() || is_author()) {
        $blog_archive_sidebar = evolve_get_option('evl_blog_archive_sidebar', 'None');
        if ($blog_archive_sidebar != '0' && function_exists('dynamic_sidebar')) {
            generated_dynamic_sidebar($blog_archive_sidebar);
        }
    } elseif (is_home()) {
        $name = get_post_meta(get_option('page_for_posts'), 'sbg_selected_sidebar_replacement', true);
        if ($name) {
            generated_dynamic_sidebar($name[0]);
        } else {
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')):
            endif;
        }
    }
    elseif (is_front_page()) {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')):
        endif;
    }
    ?>
</div><!--END #secondary .aside-->