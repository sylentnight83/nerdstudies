<?php
    /* Theme Setup Functions */

    function evolve_after_setup() {

        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
        add_image_size( 'post-thumbnail', 680, 330, true );
        add_image_size( 'slider-thumbnail', 400, 280, true );
        add_image_size( 'tabs-img', 50, 50, true );
        add_image_size( 'recent-works-thumbnail', 65, 65, true );
        add_image_size( 'blog-large', 669, 272, true );
        add_image_size( 'blog-medium', 320, 202, true );
        add_image_size( 'related-img', 180, 138, true );
        add_image_size( 'portfolio-one', 540, 272, true );
        add_image_size( 'portfolio-two', 460, 295, true );
        add_image_size( 'portfolio-three', 300, 214, true );
        add_image_size( 'portfolio-four', 220, 161, true );
        add_image_size( 'portfolio-full', 940, 400, true );
        add_image_size( 'recent-posts', 660, 405, true );

        add_editor_style( 'editor-style.css' );

        if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :

            /**
             * Filters wp_title to print a neat <title> tag based on what is being viewed.
             *
             * @param string $title Default title text for current view.
             * @param string $sep   Optional separator.
             *
             * @return string The filtered title.
             */
            function evolve_wp_title( $title, $sep ) {
                if ( is_feed() ) {
                    return $title;
                }
                global $page, $paged;

                // Add the blog name
                $title .= get_bloginfo( 'name', 'display' );

                // Add the blog description for the home/front page.
                $site_description = get_bloginfo( 'description', 'display' );
                if ( $site_description && ( is_home() || is_front_page() ) ) {
                    $title .= " $sep $site_description";
                }

                // Add a page number if necessary:
                if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
                    $title .= " $sep " . sprintf( __( 'Page %s', 'evolve' ), max( $paged, $page ) );
                }

                return $title;
            }

            add_filter( 'wp_title', 'evolve_wp_title', 10, 2 );

            /**
             * Title shim for sites older than WordPress 4.1.
             *
             * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
             * @todo Remove this function when WordPress 4.3 is released.
             */
            function evolve_render_title() {
                ?>
                <title><?php wp_title( '-', true, 'right' ); ?></title>
                <?php
            }

            add_action( 'wp_head', 'evolve_render_title' );
        endif;

        $evolve_width_px = evolve_get_option( 'evl_width_px', '1200' );
        $evolve_width_px = apply_filters( 'evolve_header_image_width', $evolve_width_px );
        //define( 'HEADER_IMAGE_WIDTH', apply_filters( 'evolve_header_image_width', $evolve_width_px ) );
        //define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'evolve_header_image_height', 170 ) );
        //define( 'HEADER_TEXTCOLOR', '' );
        //define( 'NO_HEADER_TEXT', true );
        //mod by denzel, allow flexible width and flexible height.
        $args = array(
            'flex-width'  => true,
            'width'       => $evolve_width_px,
            'flex-height' => true,
            'height'      => 200,
            'header-text' => false,
        );
        add_theme_support( 'custom-header', $args );


        // Allow shortcodes in widget text
        add_filter( 'widget_text', 'do_shortcode' );

        // Woocommerce Support
        add_theme_support( 'woocommerce' );
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );

        /**
         * Remove Double Cart Totals
         * =========================
         *
         * @woocommerce
         * @bugfix
         * @jerry
         */
        if ( class_exists( 'Woocommerce' ) ) {
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 ); // Remove Duplicated Cart Totals
            remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 ); // Remove Duplicated Checkout Button
        }

        $evolve_custom_background = evolve_get_option( 'evl_width_layout', 'fixed' );

        if ( $evolve_custom_background == "fixed" ) {
            $defaults = array(
                'default-color' => 'e5e5e5',
                'default-image' => ''
            );
            add_theme_support( 'custom-background', $defaults );
        }

        add_theme_support( 'post-formats', array(
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video'
        ) );

        load_theme_textdomain( 'evolve', get_template_directory() . '/languages' );

        register_nav_menu( 'primary-menu', __( 'Primary Menu', 'evolve' ) );
        register_nav_menu( 'top-menu', __( 'Top Menu', 'evolve' ) );


        $evolve_layout       = evolve_get_option( 'evl_layout', '2cr' );
        $evolve_width_layout = evolve_get_option( 'evl_width_layout', 'fixed' );

        global $content_width;

        if ( $evolve_layout == "2cl" || $evolve_layout == "2cr" ) {
            if ( ! isset( $content_width ) ) {
                $content_width = 610;
            }
        }
        if ( ( $evolve_layout == "3cl" || $evolve_layout == "3cr" ) ||
             ( $evolve_layout == "3cm" )
        ) {
            if ( ! isset( $content_width ) ) {
                $content_width = 506;
            }
        }
        if ( $evolve_layout == "1c" ) {
            if ( ! isset( $content_width ) ) {
                $content_width = 955;
            }
        }
    }

    add_action( 'after_setup_theme', 'evolve_after_setup' );

    /**
     * bbPress Integration
     *
     * @since 1.7.5
     */
    add_filter( 'wp_get_attachment_link', 'evolve_pretty' );

    function evolve_pretty( $content ) {
        //added by denzel, prevent it from affect next image and previous image links in attachment.php!
        if ( ! is_attachment() ) {
            $content = preg_replace( "/<a/", "<a rel=\"prettyPhoto[postimages]\"", $content, 1 );
        }

        return $content;
    }

    function evolve_hex2rgb( $hex ) {
        $hex = str_replace( "#", "", $hex );

        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        $rgb = array( $r, $g, $b );

        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    // checks is WP is at least a certain version (makes sure it has sufficient comparison decimals
    function evolve_is_wp_version( $is_ver ) {
        $wp_ver = explode( '.', get_bloginfo( 'version' ) );
        $is_ver = explode( '.', $is_ver );
        for ( $i = 0; $i; ) {
            if ( ! isset( $wp_ver[ $i ] ) ) {
                array_push( $wp_ver, 0 );
            }
        }

        foreach ( $is_ver as $i => $is_val ) {
            if ( $wp_ver[ $i ] < $is_val ) {
                return false;
            }
        }

        return true;
    }

    $evolve_layout       = evolve_get_option( 'evl_layout', '2cr' );
    $evolve_width_layout = evolve_get_option( 'evl_width_layout', 'fixed' );


    load_theme_textdomain( 'evolve', get_template_directory() . '/languages' );

    /**
     * Functions - Evolve gatekeeper
     * This file defines a few constants variables, loads up the core Evolve file,
     * and finally initialises the main WP Evolve Class.
     *
     * @package    EvoLve
     * @subpackage Functions
     */
    /* Blast you red baron! Initialise WP Evolve */
    get_template_part( 'library/evolve' );
    WPevolve::init();

    get_template_part( 'library/functions/tabs-widget' );

    // Multiple Sidebars
    get_template_part( 'library/plugins/multiple_sidebars' );

    // Portfolio
    get_template_part( 'library/plugins/post-link-plus' );

    /**
     * Layerslider API
     */
    function evolve_layerslider_ready() {
        if ( class_exists( 'LS_Sources' ) ) {
            LS_Sources::addSkins( get_template_directory() . '/library/plugins/ls-skins' );
        }
    }

    add_action( 'layerslider_ready', 'evolve_layerslider_ready' );


    $evolve_flexslider = evolve_get_option( 'evl_flexslider', '1' );

    // Auto plugin activation
    // Reset activated plugins because if pre-installed plugins are already activated in standalone mode, theme will bug out.
    if ( get_option( 'evolve_int_plugins', '0' ) == '0' ) {
        global $wpdb;
        $wpdb->query( "UPDATE " . $wpdb->options . " SET option_value = 'a:0:{}' WHERE option_name = 'active_plugins';" );
        if ( $wpdb->sitemeta ) {
            $wpdb->query( "UPDATE " . $wpdb->sitemeta . " SET meta_value = 'a:0:{}' WHERE meta_key = 'active_plugins';" );
        }
        update_option( 'evolve_int_plugins', '1' );
    }

    add_action( 'admin_head', 'evolve_admin_css' );

    function evolve_admin_css() {
        echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/library/functions/css/admin_shortcodes.css">';
    }

    function evolve_process_tag( $m ) {
        if ( $m[2] == 'dropcap' || $m[2] == 'highlight' || $m[2] == 'tooltip' ) {
            return $m[0];
        }

        // allow [[foo]] syntax for escaping a tag
        if ( $m[1] == '[' && $m[6] == ']' ) {
            return substr( $m[0], 1, - 1 );
        }

        return $m[1] . $m[6];
    }

    /* evolve_truncate */

    function evolve_truncate( $str, $length = 10, $trailing = '..' ) {
        $length -= mb_strlen( $trailing );
        if ( mb_strlen( $str ) > $length ) {
            return mb_substr( $str, 0, $length ) . $trailing;
        } else {
            $res = $str;
        }

        return $res;
    }

    /* evolve_excerpt_max_charlength */

    function evolve_excerpt_max_charlength( $num ) {
        $limit   = $num + 1;
        $excerpt = explode( ' ', get_the_excerpt(), $limit );
        array_pop( $excerpt );
        $excerpt = implode( " ", $excerpt ) . " [...]";
        echo $excerpt;
    }

    /* Get first image */

    function evolve_get_first_image() {
        global $post, $posts;
        $first_img = '';
        $output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
        if ( isset( $matches[1][0] ) ) {
            $first_img = $matches [1][0];

            return $first_img;
        }
    }

    // Tiny URL

    function evolve_tinyurl( $url ) {
        $response = esc_url( wp_remote_retrieve_body( wp_remote_get( 'http://tinyurl.com/api-create.php?url=' . $url ) ) );

        return $response;
    }

    // Similar Posts

    function evolve_similar_posts() {

        $post      = '';
        $orig_post = $post;
        global $post;
        $evolve_similar_posts = evolve_get_option( 'evl_similar_posts', 'disable' );

        if ( $evolve_similar_posts == "category" ) {
            $matchby = get_the_category( $post->ID );
            $matchin = 'category';
        } else {
            $matchby = wp_get_post_tags( $post->ID );
            $matchin = 'tag';
        }

        if ( $matchby ) {
            $matchby_ids = array();
            foreach ( $matchby as $individual_matchby ) {
                $matchby_ids[] = $individual_matchby->term_id;
            }

            $args = array(
                $matchin . '__in'     => $matchby_ids,
                'post__not_in'        => array( $post->ID ),
                'showposts'           => 5, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1
            );

            $my_query = new wp_query( $args );
            if ( $my_query->have_posts() ) {
                echo '<div class="similar-posts"><h5>' . __( 'Similar posts', 'evolve' ) . '</h5><ul>';
                while ( $my_query->have_posts() ) {
                    $my_query->the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'evolve' ); ?> <?php the_title(); ?>">
                            <?php
                                if ( get_the_title() ) {
                                    $title                             = the_title( '', '', false );
                                    $evolve_posts_excerpt_title_length = intval( evolve_get_option( 'evl_posts_excerpt_title_length', '40' ) );
                                    echo evolve_truncate( $title, $evolve_posts_excerpt_title_length, '...' );
                                } else {
                                    echo __( "Untitled", "evolve" );
                                }
                            ?>
                        </a>
                        <?php if ( get_the_content() ) { ?> &mdash;
                            <small><?php echo evolve_excerpt_max_charlength( 60 ); ?></small> <?php } ?>
                    </li>
                    <?php
                }
                echo '</ul></div>';
            }
        }
        $post = $orig_post;
        wp_reset_query();
    }

    // Theme4Press Slider

    function evolve_wooslider( $term ) {
        global $slider_settings;

        $term_details = get_term_by( 'slug', $term, 'slide-page' );

        $slider_settings = get_option( 'taxonomy_' . $term_details->term_id );
        $slider_data     = '';
        $slider_class    = '';

        if ( $slider_settings['slider_width'] == '100%' ) {
            $slider_class .= ' full-width-slider';
        }

        if ( $slider_settings['slider_width'] == '100%' ) {
            $slider_class .= ' fixed-width-slider';
        }

        $args                = array(
            'post_type'        => 'slide',
            'posts_per_page'   => - 1,
            'suppress_filters' => 0
        );
        $args['tax_query'][] = array(
            'taxonomy' => 'slide-page',
            'field'    => 'slug',
            'terms'    => $term
        );
        $query               = new WP_Query( $args );

        //$slider_height = "";
        $slider_height = $slider_settings['slider_height'];

        ?>
        <style type="text/css" scoped>
            .t4p-slider.t4press-flexslider .flex-direction-nav a {
                top: <?php echo ($slider_height / 2) ?>px !important;
                width: 40px;
            }

            .t4p-slider.t4press-flexslider ul {
                margin-bottom: 0px;
            }

            .t4p-slider.t4press-flexslider .flex-control-nav {
                top: <?php echo ($slider_height - 20) ?>px !important;
            }
			@media (max-width: 479px) {
			.t4p-slider.t4press-flexslider .flex-direction-nav a {
				top: 90px !important;
			}
			}
			@media (min-width: 480px) and (max-width: 767px) {
			.t4p-slider.t4press-flexslider .flex-direction-nav a {
				top: 142px !important;
			}
			}
			@media (min-width: 768px) and (max-width: 991px) {
			.t4p-slider.t4press-flexslider .flex-direction-nav a {
				top: 183px !important;
			}
			}			
        </style>

        <?php
        if ( $query->have_posts() ) {
            ?>
            <div class="t4p-slider-container <?php echo $slider_class; ?>-container" style="height:<?php echo $slider_settings['slider_height']; ?>;max-width:<?php echo $slider_settings['slider_width']; ?>;">
                <div class="t4p-slider t4press-flexslider main-flex<?php echo $slider_class; ?>" style="max-width:<?php echo $slider_settings['slider_width']; ?>;" <?php echo $slider_data; ?>>
                    <ul class="slides" style="width:<?php echo $slider_settings['slider_width']; ?>; margin-left: 0px;">
                        <?php
                            while ( $query->have_posts() ): $query->the_post();
                                $metadata = get_metadata( 'post', get_the_ID() );

                                $background_image = '';
                                $background_class = '';

                                $img_width = '';

                                if ( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'image' && has_post_thumbnail() ) {
                                    $image_id         = get_post_thumbnail_id();
                                    $image_url        = wp_get_attachment_image_src( $image_id, 'full', true );
                                    $background_image = 'background-image: url(' . $image_url[0] . ');';
                                    $background_class = 'background-image';
                                    $img_width        = $image_url[1];
                                }

                                $video_attributes   = '';
                                $youtube_attributes = '';
                                $vimeo_attributes   = '';
                                $data_mute          = 'no';
                                $data_loop          = 'no';
                                $data_autoplay      = 'no';

                                if ( isset( $metadata['pyre_mute_video'][0] ) && $metadata['pyre_mute_video'][0] == 'yes' ) {
                                    $video_attributes = 'muted';
                                    $data_mute        = 'yes';
                                }

                                if ( isset( $metadata['pyre_autoplay_video'][0] ) && $metadata['pyre_autoplay_video'][0] == 'yes' ) {
                                    $video_attributes .= ' autoplay';
                                    $youtube_attributes .= '&amp;autoplay=0';
                                    $vimeo_attributes .= '&amp;autoplay=0';
                                    $data_autoplay = 'yes';
                                }

                                if ( isset( $metadata['pyre_loop_video'][0] ) && $metadata['pyre_loop_video'][0] == 'yes' ) {
                                    $video_attributes .= ' loop';
                                    $youtube_attributes .= '&amp;loop=1&amp;playlist=' . $metadata['pyre_youtube_id'][0];
                                    $vimeo_attributes .= '&amp;loop=1';
                                    $data_loop = 'yes';
                                }

                                if ( isset( $metadata['pyre_hide_video_controls'][0] ) && $metadata['pyre_hide_video_controls'][0] == 'no' ) {
                                    $video_attributes .= ' controls';
                                    $youtube_attributes .= '&amp;controls=1';
                                    $video_zindex = 'z-index: 1;';
                                } else {
                                    $youtube_attributes .= '&amp;controls=0';
                                    $video_zindex = 'z-index: -99;';
                                }

                                $heading_color = '';

                                if ( isset( $metadata['pyre_heading_color'][0] ) && $metadata['pyre_heading_color'][0] ) {
                                    $heading_color = 'color:' . $metadata['pyre_heading_color'][0] . ';';
                                }

                                $heading_bg = '';

                                if ( isset( $metadata['pyre_heading_bg'][0] ) && $metadata['pyre_heading_bg'][0] == 'yes' ) {
                                    $heading_bg = 'background-color: rgba(0,0,0, 0.4);';
                                }

                                $caption_color = '';

                                if ( isset( $metadata['pyre_caption_color'][0] ) && $metadata['pyre_caption_color'][0] ) {
                                    $caption_color = 'color:' . $metadata['pyre_caption_color'][0] . ';';
                                }

                                $caption_bg = '';

                                if ( isset( $metadata['pyre_caption_bg'][0] ) && $metadata['pyre_caption_bg'][0] == 'yes' ) {
                                    $caption_bg = 'background-color: rgba(0, 0, 0, 0.4);';
                                }

                                $video_bg_color = '';

                                if ( isset( $metadata['pyre_video_bg_color'][0] ) && $metadata['pyre_video_bg_color'][0] ) {
                                    $video_bg_color_hex = t4p_hex2rgb( $metadata['pyre_video_bg_color'][0] );
                                    $video_bg_color     = 'background-color: rgba(' . $video_bg_color_hex[0] . ', ' . $video_bg_color_hex[1] . ', ' . $video_bg_color_hex[2] . ', 0.4);';
                                }

                                $video = false;

                                if ( isset( $metadata['pyre_type'][0] ) ) {
                                    if ( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' || $metadata['pyre_type'][0] == 'youtube' || $metadata['pyre_type'][0] == 'vimeo' ) {
                                        $video = true;
                                    }
                                }

                                if ( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' ) {
                                    $background_class = 'self-hosted-video-bg';
                                }

                                $heading_font_size = 'font-size:60px;line-height:80px;';
                                if ( isset( $metadata['pyre_heading_font_size'][0] ) && $metadata['pyre_heading_font_size'][0] ) {
                                    $line_height       = $metadata['pyre_heading_font_size'][0] * 1.4;
                                    $heading_font_size = 'font-size:' . $metadata['pyre_heading_font_size'][0] . 'px;line-height:' . $line_height . 'px;';
                                }

                                $caption_font_size = 'font-size: 24px;line-height:38px;';
                                if ( isset( $metadata['pyre_caption_font_size'][0] ) && $metadata['pyre_caption_font_size'][0] ) {
                                    $line_height       = $metadata['pyre_caption_font_size'][0] * 1.4;
                                    $caption_font_size = 'font-size:' . $metadata['pyre_caption_font_size'][0] . 'px;line-height:' . $line_height . 'px;';
                                }
                                ?>
                                <li data-mute="<?php echo $data_mute; ?>" data-loop="<?php echo $data_loop; ?>" data-autoplay="<?php echo $data_autoplay; ?>">

                                    <div class="slide-content-container slide-content-<?php
                                        if ( isset( $metadata['pyre_content_alignment'][0] ) && $metadata['pyre_content_alignment'][0] ) {
                                            echo $metadata['pyre_content_alignment'][0];
                                        }
                                    ?>">
                                        <div class="slide-content">
                                            <?php if ( isset( $metadata['pyre_heading'][0] ) && $metadata['pyre_heading'][0] ): ?>
                                                <div class="heading animated fadeInUp <?php
                                                    if ( $heading_bg ): echo 'with-bg';
                                                    endif;
                                                ?>" data-animationtype="fadeInUp" data-animationduration="1">
                                                    <h2 style="<?php echo $heading_bg; ?><?php echo $heading_color; ?><?php echo $heading_font_size; ?>"><?php echo $metadata['pyre_heading'][0]; ?></h2>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( isset( $metadata['pyre_caption'][0] ) && $metadata['pyre_caption'][0] ): ?>
                                                <div class="caption animated fadeInUp <?php
                                                    if ( $caption_bg ): echo 'with-bg';
                                                    endif;
                                                ?>" data-animationtype="fadeInUp" data-animationduration="1">
                                                    <h3 style="<?php echo $caption_bg; ?><?php echo $caption_color; ?><?php echo $caption_font_size; ?>"><?php echo $metadata['pyre_caption'][0]; ?></h3>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( isset( $metadata['pyre_link_type'][0] ) && $metadata['pyre_link_type'][0] == 'button' ): ?>
                                                <div class="buttons animated fadeInUp" data-animationtype="fadeInUp" data-animationduration="1">
                                                    <?php
                                                        if ( isset( $metadata['pyre_button_1'][0] ) && $metadata['pyre_button_1'][0] ) {
                                                            echo '<div class="t4p-button-1">' . do_shortcode( $metadata['pyre_button_1'][0] ) . '</div>';
                                                        }
                                                        if ( isset( $metadata['pyre_button_2'][0] ) && $metadata['pyre_button_2'][0] ) {
                                                            echo '<div class="t4p-button-2">' . do_shortcode( $metadata['pyre_button_2'][0] ) . '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ( isset( $metadata['pyre_link_type'][0] ) && $metadata['pyre_link_type'][0] == 'full' && isset( $metadata['pyre_slide_link'][0] ) && $metadata['pyre_slide_link'][0] ): ?>
                                        <a href="<?php echo $metadata['pyre_slide_link'][0]; ?>" class="overlay-link"></a>
                                    <?php endif; ?>
                                    <?php if ( isset( $metadata['pyre_preview_image'][0] ) && $metadata['pyre_preview_image'][0] ): ?>
                                        <div class="mobile_video_image" style="background-image: url(<?php echo $metadata['pyre_preview_image'][0]; ?>);"></div>
                                    <?php elseif ( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' ): ?>
                                        <div class="mobile_video_image" style="background-image: url(<?php echo bloginfo( 'template_directory' ); ?>/images/video_preview.jpg);"></div>
                                    <?php endif; ?>
                                    <?php if ( $video_bg_color && $video == true ): ?>
                                        <div class="overlay" style="<?php echo $video_bg_color; ?>"></div>
                                    <?php endif; ?>
                                    <div class="background <?php echo $background_class; ?>" style="<?php echo $background_image; ?>width:<?php echo $slider_settings['slider_width']; ?>;height:<?php echo $slider_settings['slider_height']; ?>;" data-imgwidth="<?php echo $img_width; ?>">
                                        <?php if ( isset( $metadata['pyre_type'][0] ) ): if ( $metadata['pyre_type'][0] == 'self-hosted-video' && ( $metadata['pyre_webm'][0] || $metadata['pyre_mp4'][0] || $metadata['pyre_ogg'][0] ) ): ?>
                                            <video width="1800" height="700" <?php echo $video_attributes; ?> preload="auto">
                                                <?php if ( $metadata['pyre_mp4'][0] ): ?>
                                                    <source src="<?php echo $metadata['pyre_mp4'][0]; ?>" type="video/mp4">
                                                <?php endif; ?>
                                                <?php if ( $metadata['pyre_ogg'][0] ): ?>
                                                    <source src="<?php echo $metadata['pyre_ogg'][0]; ?>" type="video/ogg">
                                                <?php endif; ?>
                                                <?php if ( $metadata['pyre_webm'][0] ): ?>
                                                    <source src="<?php echo $metadata['pyre_webm'][0]; ?>" type="video/webm">
                                                <?php endif; ?>
                                            </video>
                                            <?php
                                        endif;
                                        endif;
                                        ?>
                                        <?php if ( isset( $metadata['pyre_type'][0] ) && isset( $metadata['pyre_youtube_id'][0] ) && $metadata['pyre_type'][0] == 'youtube' && $metadata['pyre_youtube_id'][0] ): ?>
                                            <div style="position: absolute; top: 0; left: 0; <?php echo $video_zindex; ?> width: 100%; height: 100%">
                                                <iframe frameborder="0" height="100%" width="100%" src="http<?php echo ( is_ssl() ) ? 's' : ''; ?>://www.youtube.com/embed/<?php echo $metadata['pyre_youtube_id'][0]; ?>?modestbranding=1&amp;showinfo=0&amp;autohide=1&amp;enablejsapi=1&amp;rel=0<?php echo $youtube_attributes; ?>"></iframe>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( isset( $metadata['pyre_type'][0] ) && isset( $metadata['pyre_vimeo_id'][0] ) && $metadata['pyre_type'][0] == 'vimeo' && $metadata['pyre_vimeo_id'][0] ): ?>
                                            <div style="position: absolute; top: 0; left: 0; <?php echo $video_zindex; ?> width: 100%; height: 100%">
                                                <iframe src="http<?php echo ( is_ssl() ) ? 's' : ''; ?>://player.vimeo.com/video/<?php echo $metadata['pyre_vimeo_id'][0]; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;badge=0&amp;title=0<?php echo $vimeo_attributes; ?>" height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <?php
        }

        wp_reset_query();
        //}
    }

    function evolve_footer_hooks() {

        $lightbox_animation_speed = evolve_get_option( 'evl_lightbox_animation_speed', 'fast' );
        $lightbox_gallery         = evolve_get_option( 'evl_lightbox_gallery', '1' );
        $lightbox_autoplay        = evolve_get_option( 'evl_lightbox_autoplay', '0' );
        $lightbox_slideshow_speed = evolve_get_option( 'evl_lightbox_slideshow_speed', '5000' );
        $lightbox_opacity         = evolve_get_option( 'evl_lightbox_opacity', '0.8' );
        $lightbox_title           = evolve_get_option( 'evl_lightbox_title', '1' );
        $lightbox_desc            = evolve_get_option( 'evl_lightbox_desc', '1' );
        $lightbox_social          = evolve_get_option( 'evl_lightbox_social', '1' );
        $lightbox_post_images     = evolve_get_option( 'evl_lightbox_post_images', '0' );

        $slideshow_autoplay     = evolve_get_option( 'evl_slideshow_autoplay', '1' );
        $slideshow_speed        = evolve_get_option( 'evl_slideshow_speed', '7000' );
        $pagination_video_slide = evolve_get_option( 'evl_pagination_video_slide', '0' );

        $status_vimeo = evolve_get_option( 'evl_status_vimeo', '0' );
        $status_yt    = evolve_get_option( 'evl_status_yt', '0' );

        $testimonials_speed = evolve_get_option( 'evl_testimonials_speed', '4000' );

        $status_gmap = evolve_get_option( 'evl_status_gmap', '1' );
        ?>

        <script type='text/javascript'>

            function insertParam( url, parameterName, parameterValue, atStart ) {
                replaceDuplicates = true;
                if ( url.indexOf( '#' ) > 0 ) {
                    var cl = url.indexOf( '#' );
                    urlhash = url.substring( url.indexOf( '#' ), url.length );
                } else {
                    urlhash = '';
                    cl = url.length;
                }
                sourceUrl = url.substring( 0, cl );
                var urlParts = sourceUrl.split( "?" );
                var newQueryString = "";
                if ( urlParts.length > 1 ) {
                    var parameters = urlParts[1].split( "&" );
                    for ( var i = 0; (i < parameters.length); i++ ) {
                        var parameterParts = parameters[i].split( "=" );
                        if ( !(replaceDuplicates && parameterParts[0] == parameterName) ) {
                            if ( newQueryString == "" ) {
                                newQueryString = "?" + parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
                            }
                            else {
                                newQueryString += "&";
                                newQueryString += parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
                            }
                        }
                    }
                }
                if ( newQueryString == "" )
                    newQueryString = "?";
                if ( atStart ) {
                    newQueryString = '?' + parameterName + "=" + parameterValue + (newQueryString.length > 1 ? '&' + newQueryString.substring( 1 ) : '');
                } else {
                    if ( newQueryString !== "" && newQueryString != '?' )
                        newQueryString += "&";
                    newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
                }
                return urlParts[0] + newQueryString + urlhash;
            }
            ;
            function ytVidId( url ) {
                var p = /^(?:https?:)?(\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                return (url.match( p )) ? RegExp.$1 : false;
                //return (url.match(p)) ? true : false;
            }

            function playVideoAndPauseOthers( slider ) {
                jQuery( slider ).find( 'iframe' ).each(
                    function( i ) {
                        var func = 'stopVideo';
                        this.contentWindow.postMessage( '{"event":"command","func":"' + func + '","args":""}', '*' );
                        if ( jQuery( this ).is( ':visible' ) && jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) == 'yes' ) {
                            this.contentWindow.postMessage(
                                '{"event":"command","func":"' + 'playVideo' + '","args":""}', '*'
                            );
                            if ( jQuery( this ).parents( 'li' ).attr( 'data-mute' ) == 'yes' ) {
                                this.contentWindow.postMessage(
                                    '{"event":"command","func":"' + 'mute' + '","args":""}', '*'
                                );
                            }
                        }
                    }
                );
            }

            /* ------------------ PREV & NEXT BUTTON FOR FLEXSLIDER (YOUTUBE) ------------------ */
            jQuery( '.flex-next, .flex-prev' ).click(
                function() {
                    playVideoAndPauseOthers( jQuery( this ).parents( '.flexslider, .t4ps-slider' ) );
                }
            );
            function onPlayerStateChange( frame, slider ) {
                return function( event ) {
                    if ( event.data == YT.PlayerState.PLAYING ) {
                        jQuery( slider ).flexslider( "pause" );
                    }
                    if ( event.data == YT.PlayerState.PAUSED ) {
                        jQuery( slider ).flexslider( "play" );
                    }
                    if ( event.data == YT.PlayerState.BUFFERING ) {
                        jQuery( slider ).flexslider( "pause" );
                    }
                }
            }


            //
            //
            //
            // YouTube & Vimeo
            //
            //
            //
            jQuery( document ).ready(
                function() {
                    var iframes = jQuery( 'iframe' );
                    jQuery.each(
                        iframes, function( i, v ) {
                            var src = jQuery( this ).attr( 'src' );
                            if ( src ) {
                                <?php if (!$status_vimeo): ?>
                                if ( src.indexOf( 'vimeo' ) >= 1 ) {
                                    jQuery( this ).attr( 'id', 'player_' + (i + 1) );
                                    var new_src = insertParam( src, 'api', '1', false );
                                    var new_src_2 = insertParam( new_src, 'player_id', 'player_' + (i + 1), false );
                                    jQuery( this ).attr( 'src', new_src_2 );
                                }
                                <?php endif; ?>
                                <?php if (!$status_yt): ?>
                                if ( ytVidId( src ) ) {
                                    jQuery( this ).attr( 'id', 'player_' + (i + 1) );
                                    jQuery( this ).parent().wrap( '<span class="play3" />' );
                                    window.yt_vid_exists = true;
                                    var new_src = insertParam( src, 'enablejsapi', '1', false );
                                    jQuery( this ).attr( 'src', new_src );
                                }
                                <?php endif; ?>
                            }
                        }
                    );
                    <?php if (!$status_yt): ?>
                    if ( window.yt_vid_exists == true ) {
                        var tag = document.createElement( 'script' );
                        tag.src = window.location.protocol + "//www.youtube.com/iframe_api";
                        var firstScriptTag = document.getElementsByTagName( 'script' )[0];
                        firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );
                    }
                    <?php endif; ?>
                }
            );
            // Define YT_ready function.
            var YT_ready = (function() {
                var onReady_funcs = [], api_isReady = false;
                /* @param func function     Function to execute on ready
                 * @param func Boolean      If true, all qeued functions are executed
                 * @param b_before Boolean  If true, the func will added to the first
                 position in the queue*/
                return function( func, b_before ) {
                    if ( func === true ) {
                        api_isReady = true;
                        while ( onReady_funcs.length ) {
                            // Removes the first func from the array, and execute func
                            onReady_funcs.shift()();
                        }
                    } else if ( typeof func == "function" ) {
                        if ( api_isReady ) func();
                        else onReady_funcs[b_before ? "unshift" : "push"]( func );
                    }
                }
            })();
            // This function will be called when the API is fully loaded
            function onYouTubePlayerAPIReady() {
                YT_ready( true )
            }


            //
            //
            //
            // FlexSlider
            //
            //
            //    


            jQuery( '.flexslider' ).flexslider(
                {
                    slideshow: <?php
    if ($slideshow_autoplay) {
        echo 'true';
    } else {
        echo 'false';
    }
    ?>,
                    slideshowSpeed: <?php
    if ($slideshow_speed) {
        echo $slideshow_speed;
    } else {
        echo '7000';
    }
    ?>,
                    video: true,
                    pauseOnHover: false,
                    useCSS: false,
                    start: function( slider ) {
                        if ( typeof (slider.slides) !== 'undefined' && slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length !== 0 ) {
                            <?php if ($pagination_video_slide): ?>
                            jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-30px' );
                            <?php else: ?>
                            jQuery( slider ).find( '.flex-control-nav' ).hide();
                            <?php endif; ?>

                            <?php if (!$status_yt): ?>
                            if ( window.yt_vid_exists == true ) {
                                YT_ready(
                                    function() {
                                        new YT.Player(
                                            slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
                                                events: {
                                                    'onStateChange': onPlayerStateChange(
                                                        slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ),
                                                        slider
                                                    )
                                                }
                                            }
                                        );
                                    }
                                );
                            }
                            <?php endif; ?>
                        } else {
                            <?php if ($pagination_video_slide): ?>
                            jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0' );
                            <?php else: ?>
                            jQuery( slider ).find( '.flex-control-nav' ).show();
                            <?php endif; ?>
                        }
                    },
                    before: function( slider ) {
                        if ( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length !== 0 ) {
                            <?php if (!$status_vimeo): ?>$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
                            <?php endif; ?>

                            <?php if (!$status_yt): ?>
                            if ( window.yt_vid_exists == true ) {
                                YT_ready(
                                    function() {
                                        new YT.Player(
                                            slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
                                                events: {
                                                    'onStateChange': onPlayerStateChange(
                                                        slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ),
                                                        slider
                                                    )
                                                }
                                            }
                                        );
                                    }
                                );
                            }
                            <?php endif; ?>

                            /* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
                            playVideoAndPauseOthers( slider );
                        }
                    },
                    after: function( slider ) {
                        if ( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length !== 0 ) {
                            <?php if ($pagination_video_slide): ?>
                            jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-30px' );
                            <?php else: ?>
                            jQuery( slider ).find( '.flex-control-nav' ).hide();
                            <?php endif; ?>

                            <?php if (!$status_yt): ?>
                            if ( window.yt_vid_exists == true ) {
                                YT_ready(
                                    function() {
                                        new YT.Player(
                                            slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
                                                events: {
                                                    'onStateChange': onPlayerStateChange(
                                                        slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ),
                                                        slider
                                                    )
                                                }
                                            }
                                        );
                                    }
                                );
                            }
                            <?php endif; ?>
                        } else {
                            <?php if ($pagination_video_slide): ?>
                            jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
                            <?php else: ?>
                            jQuery( slider ).find( '.flex-control-nav' ).show();
                            <?php endif; ?>
                        }
                    }
                }
            );
            function playVideoAndPauseOthers( slider ) {
                jQuery( slider ).find( 'iframe' ).each(
                    function( i ) {
                        var func = 'stopVideo';
                        this.contentWindow.postMessage( '{"event":"command","func":"' + func + '","args":""}', '*' );
                        if ( jQuery( this ).is( ':visible' ) && jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) == 'yes' ) {
                            this.contentWindow.postMessage(
                                '{"event":"command","func":"' + 'playVideo' + '","args":""}', '*'
                            );
                            if ( jQuery( this ).parents( 'li' ).attr( 'data-mute' ) == 'yes' ) {
                                this.contentWindow.postMessage(
                                    '{"event":"command","func":"' + 'mute' + '","args":""}', '*'
                                );
                            }
                        }
                    }
                );
            }

            /* ------------------ PREV & NEXT BUTTON FOR FLEXSLIDER (YOUTUBE) ------------------ */
            jQuery( '.flex-next, .flex-prev' ).click(
                function() {
                    playVideoAndPauseOthers( jQuery( this ).parents( '.flexslider, .t4ps-slider' ) );
                }
            );
            function onPlayerStateChange( frame, slider ) {
                return function( event ) {
                    if ( event.data == YT.PlayerState.PLAYING ) {
                        jQuery( slider ).flexslider( "pause" );
                    }
                    if ( event.data == YT.PlayerState.PAUSED ) {
                        jQuery( slider ).flexslider( "play" );
                    }
                    if ( event.data == YT.PlayerState.BUFFERING ) {
                        jQuery( slider ).flexslider( "pause" );
                    }
                }
            }


            // prettyPhoto

            if ( jQuery().prettyPhoto ) {
                var ppArgs = {
                    <?php if ($lightbox_animation_speed): ?>
                    animation_speed: '<?php echo strtolower($lightbox_animation_speed); ?>',
                    <?php endif; ?>
                    overlay_gallery: <?php
    if ($lightbox_gallery) {
        echo 'true';
    } else {
        echo 'false';
    }
    ?>,
                    autoplay_slideshow: <?php
    if ($lightbox_autoplay) {
        echo 'true';
    } else {
        echo 'false';
    }
    ?>,
                    <?php if ($lightbox_slideshow_speed): ?>
                    slideshow: <?php echo $lightbox_slideshow_speed; ?>,
                    <?php endif; ?>
                    <?php if ($lightbox_opacity): ?>
                    opacity: <?php echo $lightbox_opacity; ?>,
                    <?php endif; ?>
                    show_title: <?php
    if ($lightbox_title) {
        echo 'true';
    } else {
        echo 'false';
    }
    ?>,
                    show_desc: <?php
    if ($lightbox_desc) {
        echo 'true';
    } else {
        echo 'false';
    }
    ?>,
                    <?php
    if (!$lightbox_social) {
        echo 'social_tools: "",';
    }
    ?>
                };
                var ppArgsRelated = ppArgs;
                jQuery( "a[rel^='prettyPhoto']" ).prettyPhoto( ppArgs );
                <?php if ($lightbox_post_images): ?>
                jQuery( '.single-post .entry-content a[href$=".gif"], .single-post .entry-content a[href$=".jpg"], .single-post .entry-content a[href$=".png"], .single-post .entry-content a[href$=".bmp"]' ).has( 'img' ).prettyPhoto( ppArgs );
                <?php endif; ?>

                jQuery( '.lightbox-enabled a' ).has( 'img' ).prettyPhoto( ppArgs );
                var mediaQuery = 'desk';
                if ( Modernizr.mq( 'only screen and (max-width: 600px)' ) || Modernizr.mq( 'only screen and (max-height: 520px)' ) ) {

                    mediaQuery = 'mobile';
                    jQuery( "a[rel^='prettyPhoto']" ).unbind( 'click' );
                    <?php if ($lightbox_post_images): ?>
                    jQuery( '.single-post .post-content a' ).has( 'img' ).unbind( 'click' );
                    <?php endif; ?>
                    jQuery( '.lightbox-enabled a' ).has( 'img' ).unbind( 'click' );
                }

                // Disables prettyPhoto if screen small
                jQuery( window ).on(
                    'resize', function() {
                        if ( (Modernizr.mq( 'only screen and (max-width: 600px)' ) || Modernizr.mq( 'only screen and (max-height: 520px)' )) && mediaQuery == 'desk' ) {
                            jQuery( "a[rel^='prettyPhoto']" ).unbind( 'click.prettyphoto' );
                            <?php if ($lightbox_post_images): ?>
                            jQuery( '.single-post .post-content a' ).has( 'img' ).unbind( 'click.prettyphoto' );
                            <?php endif; ?>
                            jQuery( '.lightbox-enabled a' ).has( 'img' ).unbind( 'click.prettyphoto' );
                            mediaQuery = 'mobile';
                        } else if ( !Modernizr.mq( 'only screen and (max-width: 600px)' ) && !Modernizr.mq( 'only screen and (max-height: 520px)' ) && mediaQuery == 'mobile' ) {
                            jQuery( "a[rel^='prettyPhoto']" ).prettyPhoto( ppArgs );
                            <?php if ($lightbox_post_images): ?>
                            jQuery( '.single-post .post-content a' ).has( 'img' ).prettyPhoto( ppArgs );
                            <?php endif; ?>
                            jQuery( '.lightbox-enabled a' ).has( 'img' ).prettyPhoto( ppArgs );
                            mediaQuery = 'desk';
                        }
                    }
                );
            }


            // Testimonials

            jQuery( document ).ready(
                function() {
                    function onAfter( curr, next, opts, fwd ) {
                        var $ht = jQuery( this ).height();
                        //set the container's height to that of the current slide
                        jQuery( this ).parent().css( 'height', $ht );
                    }

                    if ( jQuery().cycle ) {
                        jQuery( '.reviews' ).cycle(
                            {
                                fx: 'fade',
                                after: onAfter,
                                <?php if ($testimonials_speed): ?>
                                timeout: <?php echo $testimonials_speed; ?>
                                <?php endif; ?>
                            }
                        );
                    }
                }
            );</script>


        <?php
        if ( is_page_template( 'contact.php' ) ):
            $status_gmap = evolve_get_option( 'evl_status_gmap', '1' );

            if ( $status_gmap ):

                $evolve_gmap_address    = evolve_get_option( 'evl_gmap_address', 'Via dei Fori Imperiali' );
                $evolve_gmap_type       = evolve_get_option( 'evl_gmap_type', 'hybrid' );
                $evolve_map_zoom_level  = evolve_get_option( 'evl_map_zoom_level', '18' );
                $evolve_map_scrollwheel = evolve_get_option( 'evl_map_scrollwheel', '0' );
                $evolve_map_scale       = evolve_get_option( 'evl_map_scale', '0' );
                $evolve_map_zoomcontrol = evolve_get_option( 'evl_map_zoomcontrol', '0' );
                $evolve_map_pin         = evolve_get_option( 'evl_map_pin', '0' );
                $evolve_map_pop         = evolve_get_option( 'evl_map_popup', '0' );
                $evolve_gmap_address    = addslashes( $evolve_gmap_address );
                $addresses              = explode( '|', $evolve_gmap_address );
                $markers                = '';
                if ( $evolve_map_pop == '0' ) {
                    $map_popup = "false";
                } else {
                    $map_popup = "true";
                }
                foreach ( $addresses as $address_string ) {
                    $markers .= "{
			address: '{$address_string}',
			html: {
				content: '{$address_string}',
				popup: {$map_popup}
			}
		},";
                }
                ?>

                <script type='text/javascript'>
                    jQuery( document ).ready(
                        function( $ ) {
                            jQuery( '#gmap' ).goMap(
                                {
                                    address: '<?php echo $addresses[0]; ?>',
                                    maptype: '<?php echo $evolve_gmap_type; ?>',
                                    zoom: <?php echo $evolve_map_zoom_level; ?>,
                                    scrollwheel: <?php if ($evolve_map_scrollwheel): ?>false<?php else: ?>true<?php endif; ?>,
                                    scaleControl: <?php if ($evolve_map_scale): ?>false<?php else: ?>true<?php endif; ?>,
                                    navigationControl: <?php if ($evolve_map_zoomcontrol): ?>false<?php else: ?>true<?php endif; ?>,
                                    <?php if (!$evolve_map_pin): ?>markers: [<?php echo $markers; ?>], <?php endif; ?>
                                }
                            );
                        }
                    );</script>
            <?php endif; ?>
        <?php endif; ?>

        <script type="text/javascript">
            var $jx = jQuery.noConflict();
            $jx( "div.post" ).mouseover(
                function() {
                    $jx( this ).find( "span.edit-post" ).css( 'visibility', 'visible' );
                }
            ).mouseout(
                function() {
                    $jx( this ).find( "span.edit-post" ).css( 'visibility', 'hidden' );
                }
            );
            $jx( "div.type-page" ).mouseover(
                function() {
                    $jx( this ).find( "span.edit-page" ).css( 'visibility', 'visible' );
                }
            ).mouseout(
                function() {
                    $jx( this ).find( "span.edit-page" ).css( 'visibility', 'hidden' );
                }
            );
            $jx( "div.type-attachment" ).mouseover(
                function() {
                    $jx( this ).find( "span.edit-post" ).css( 'visibility', 'visible' );
                }
            ).mouseout(
                function() {
                    $jx( this ).find( "span.edit-post" ).css( 'visibility', 'hidden' );
                }
            );
            $jx( "li.comment" ).mouseover(
                function() {
                    $jx( this ).find( "span.edit-comment" ).css( 'visibility', 'visible' );
                }
            ).mouseout(
                function() {
                    $jx( this ).find( "span.edit-comment" ).css( 'visibility', 'hidden' );
                }
            );</script>

        <?php
        $evolve_sticky_header = evolve_get_option( 'evl_sticky_header', '1' );
        if ( $evolve_sticky_header == "1" ) {
            ?>

            <script type="text/javascript">
                /*----------------------------*/
                /* Sticky Header
                 /*----------------------------*/

                jQuery( window ).on(
                    "scroll", function() {
                        var scrollPos = jQuery( window ).scrollTop();

                        //var headerHeight = jQuery('.menu-header').height() + jQuery('.header-border').height() + jQuery('.new_menu_class').height();
                        var headerHeight = jQuery( '.header-border-sticky' ).height() + jQuery( '.menu-header-sticky' ).height() + jQuery( '.header-sticky-height' ).height() + jQuery( '.header-border-sticky-v3' ).height() + jQuery( '.new-top-menu' ).height();

                        if ( jQuery( window ).scrollTop() > headerHeight ) {
                            is_scrolled = true;
                        } else {
                            is_scrolled = false;
                        }
                        if ( jQuery( '.sticky-header' ).length >= 1 ) {

                            if ( !is_scrolled ) {
                                jQuery( '.sticky-header' ).removeClass( 'sticky' );
                                jQuery( '.sticky-header' ).hide();
                            } else if ( is_scrolled ) {
                                jQuery( '.sticky-header' ).addClass( 'sticky' );
                                jQuery( '.sticky-header' ).fadeIn();

                            }
                            // else if (scrollPos == 0) {
                            // jQuery('.sticky-header').removeClass('sticky');
                            // jQuery('.sticky-header').hide();

                            // }
                        }
                    }
                );

                // jQuery(document).ready(
                // function($) {
                // if (jQuery('.sticky-header').length >= 1) {
                // jQuery(window).scroll(
                // function() {
                // var header = jQuery(document).scrollTop();

                // var headerHeight = jQuery('.menu-header').height() + jQuery('.header').height();
                // if (header > headerHeight) {
                // jQuery('.sticky-header').addClass('sticky');
                // jQuery('.sticky-header').fadeIn();
                // } else {
                // jQuery('.sticky-header').removeClass('sticky');
                // jQuery('.sticky-header').hide();
                // }
                // }
                // );
                // }
                // }
                // );
            </script>

        <?php } ?>


        <?php
        $evolve_animatecss = evolve_get_option( 'evl_animatecss', '1' );

        if ( $evolve_animatecss == "1" ) {
            ?>

            <script type="text/javascript">
                /*----------------------------*/
                /* Animated Buttons
                 /*----------------------------*/

                var $animated = jQuery.noConflict();
                $animated( '.post-more' ).hover(
                    function() {
                        $animated( this ).addClass( 'animate pulse' )
                    },
                    function() {
                        $animated( this ).removeClass( 'animate pulse' )
                    }
                )
                $animated( '.read-more' ).hover(
                    function() {
                        $animated( this ).addClass( 'animate pulse' )
                    },
                    function() {
                        $animated( this ).removeClass( 'animate pulse' )
                    }
                )
                $animated( '#submit' ).hover(
                    function() {
                        $animated( this ).addClass( 'animate pulse' )
                    },
                    function() {
                        $animated( this ).removeClass( 'animate pulse' )
                    }
                )
                $animated( 'input[type="submit"]' ).hover(
                    function() {
                        $animated( this ).addClass( 'animate pulse' )
                    },
                    function() {
                        $animated( this ).removeClass( 'animate pulse' )
                    }
                )
                $animated( '.button' ).hover(
                    function() {
                        $animated( this ).addClass( 'animate pulse' )
                    },
                    function() {
                        $animated( this ).removeClass( 'animate pulse' )
                    }
                )

            </script>

        <?php } ?>


        <?php
        $evolve_carousel_slider = evolve_get_option( 'evl_carousel_slider', '1' );

        if ( $evolve_carousel_slider == "1" ):

            $evolve_carousel_speed = evolve_get_option( 'evl_carousel_speed', '3500' );
            if ( empty( $evolve_carousel_speed ) ): $evolve_carousel_speed = '3500';
            endif;
            ?>

            <script type="text/javascript">
                /*----------------*/
                /* AnythingSlider
                 /*----------------*/
                var $s = jQuery.noConflict();
                $s(
                    function() {
                        $s( '#slides' )
                            .anythingSlider( {autoPlay: true, delay: <?php echo $evolve_carousel_speed; ?>,} )
                    }
                )
            </script>

        <?php endif; ?>


        <?php
        $evolve_bootstrap_speed = evolve_get_option( 'evl_bootstrap_speed', '7000' );
        if ( empty( $evolve_bootstrap_speed ) ): $evolve_bootstrap_speed = '7000';
        endif;

        $evolve_parallax_slider = evolve_get_option( 'evl_parallax_slider_support', '1' );

        if ( $evolve_parallax_slider == "1" ):

            $evolve_parallax_speed = evolve_get_option( 'evl_parallax_speed', '4000' );
            if ( empty( $evolve_parallax_speed ) ): $evolve_parallax_speed = '4000';
            endif;
            ?>
            <script type="text/javascript">
                /*----------------*/
                /* Parallax Slider
                 /*----------------*/

                var $par = jQuery.noConflict();
                $par( '#da-slider' ).cslider(
                    {
                        autoplay: true,
                        bgincrement: 450,
                        interval: <?php echo $evolve_parallax_speed; ?>
                    }
                );</script>

        <?php endif; ?>

        <script type="text/javascript">
            /*----------------------*/
            /* Bootstrap Slider
             /*---------------------*/

            var $carousel = jQuery.noConflict();
            $carousel( '#myCarousel' ).carousel(
                {
                    interval: 7000
                }
            )

            $carousel( '#carousel-nav a' ).click(
                function( q ) {
                    q.preventDefault();
                    targetSlide = $carousel( this ).attr( 'data-to' ) - 1;
                    $carousel( '#myCarousel' ).carousel( targetSlide );
                    $carousel( this ).addClass( 'active' ).siblings().removeClass( 'active' );
                }
            );
            $carousel( '#bootstrap-slider' ).carousel(
                {
                    interval: <?php echo $evolve_bootstrap_speed; ?>
                }
            )

            $carousel( '#carousel-nav a' ).click(
                function( q ) {
                    q.preventDefault();
                    targetSlide = $carousel( this ).attr( 'data-to' ) - 1;
                    $carousel( '#bootstrap-slider' ).carousel( targetSlide );
                    $carousel( this ).addClass( 'active' ).siblings().removeClass( 'active' );
                }
            );
            // $('#carousel-rel a').click(function(q){
            //         console.log('Clicked');
            //         targetSlide = (parseInt($('#carousel-rel a.active').data('to')) + 1) % 3;
            //         console.log('targetSlide');
            //         $('#carousel-rel a[data-to='+ targetSlide +']').addClass('active').siblings().removeClass('active');
            //     });
        </script>


        <?php
    }

    function evolve_hexDarker( $hex, $factor = 30 ) {
        $new_hex = '';

        $base['R'] = hexdec( $hex{0} . $hex{1} );
        $base['G'] = hexdec( $hex{2} . $hex{3} );
        $base['B'] = hexdec( $hex{4} . $hex{5} );

        foreach ( $base as $k => $v ) {
            $amount      = $v / 100;
            $amount      = round( $amount * $factor );
            $new_decimal = $v - $amount;

            $new_hex_component = dechex( $new_decimal );
            if ( strlen( $new_hex_component ) < 2 ) {
                $new_hex_component = "0" . $new_hex_component;
            }
            $new_hex .= $new_hex_component;
        }

        return $new_hex;
    }

    function evolve_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    add_action( 'wp_enqueue_scripts', 'evolve_enqueue_comment_reply' );

    // Share This Buttons

    function evolve_sharethis() {
		global $post;
		$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		if(empty($image_url)){
			$image_url = get_template_directory_uri().'/library/media/images/no-thumbnail.jpg';
		}		
        ?>
        <div class="share-this">
            <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Twitter', 'evolve' ); ?>" target="_blank" href="http://twitter.com/intent/tweet?status=<?php the_title(); ?>+&raquo;+<?php echo esc_url( evolve_tinyurl( get_permalink() ) ); ?>"><i class="t4p-icon-social-twitter"></i></a>
            <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Facebook', 'evolve' ); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"><i class="t4p-icon-social-facebook"></i></a>
            <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Google Plus', 'evolve' ); ?>" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="t4p-icon-social-google-plus"></i></a>
			<a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Pinterest', 'evolve' ); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $image_url; ?>&description=<?php the_title(); ?>"><i class="t4p-icon-social-pinterest"></i></a>			
            <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share by Email', 'evolve' ); ?>" target="_blank" href="http://www.addtoany.com/email?linkurl=<?php the_permalink(); ?>&linkname=<?php the_title(); ?>"><i class="t4p-icon-social-envelope-o"></i></a>
            <a rel="nofollow" class="tipsytext" title="<?php _e( 'More options', 'evolve' ); ?>" target="_blank" href="http://www.addtoany.com/share_save#url=<?php the_permalink(); ?>&linkname=<?php the_title(); ?>"><i class="t4p-icon-redo"></i></a>
        </div>
        <?php
    }

    /* LayerSlider */

    function evolve_layerslider() {

        global $wpdb, $post;

        $evolve_slider_page_id = '';
        if ( ! is_home() && ! is_front_page() && ! is_archive() ) {
            $evolve_slider_page_id = $post->ID;
        }
        if ( ! is_home() && is_front_page() ) {
            $evolve_slider_page_id = $post->ID;
        }
        if ( is_home() && ! is_front_page() ) {
            $evolve_slider_page_id = get_option( 'page_for_posts' );
        }


        // Get slider
        $ls_table_name = $wpdb->prefix . "layerslider";
        $ls_id         = get_post_meta( $evolve_slider_page_id, 'evolve_slider', true );
        $ls_slider     = $wpdb->get_row( "SELECT * FROM $ls_table_name WHERE id = " . (int) $ls_id . " ORDER BY date_c DESC LIMIT 1", ARRAY_A );
        $ls_slider     = json_decode( $ls_slider['data'], true );
        ?>

		<style type="text/css" scoped>
            #layerslider-container {
                max-width: <?php echo $ls_slider['properties']['width'] ?>;
            }
        </style>
        <div id="layerslider-container">
            <div id="layerslider-wrapper">
                <?php if ( $ls_slider['properties']['skin'] == 'evolve' ): ?>
                <?php endif; ?>
                <?php echo do_shortcode( '[layerslider id="' . get_post_meta( $evolve_slider_page_id, 'evolve_slider', true ) . '"]' ); ?>
                <?php if ( $ls_slider['properties']['skin'] == 'evolve' ): ?>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }

    /* Bootstrap Slider */

    function evolve_bootstrap() {
        global $evl_options;
        $wrap = false;

        $slides = evolve_get_option( "bootstrap_slides", array() );

        if ( isset( $slides['enabled'] ) ) {
            foreach ( $slides['enabled'] as $i => $enabled ) {
                if ( $enabled == 1 ) {
                    $active = "";
                    if ( ! $wrap ) {
                        $wrap = true;
                        echo "<div id='bootstrap-slider' class='carousel slide' data-ride='carousel'>";
                        echo "<div class='carousel-inner'>";
                        $active = " active";
                    }
                    echo "<div class='item" . $active . "'>";
                    echo "<img class='img-responsive' src='" . $slides["image"][ $i ]['url'] . "' alt='" . $slides["title"][ $i ] . "' />";
                    if ( ( isset( $slides["title"] ) && $slides["title"][ $i ] && ! empty( $slides["title"][ $i ] ) ) || ( isset( $slides["description"] ) && $slides["description"][ $i ] && ! empty( $slides["description"][ $i ] ) ) ) {
                        echo "<div class='carousel-caption'>";

                        if ( isset( $slides["title"][ $i ] ) && ! empty( $slides["title"][ $i ] ) ) {
                            echo "<h2>" . esc_attr( $slides["title"][ $i ] ) . "</h2>";
                        }

                        if ( isset( $slides["description"][ $i ] ) && ! empty( $slides["description"][ $i ] ) ) {
                            echo "<p>" . esc_attr( $slides["description"][ $i ] ) . "</p>";
                        }

                        if ( isset( $slides["button"][ $i ] ) && ! empty( $slides["button"][ $i ] ) ) {
                            echo do_shortcode( $slides["button"][ $i ] );
                        }

                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
        }

        if ( $wrap ) {
            echo "</div>
            <a class='left carousel-control' href='#bootstrap-slider' data-slide='prev'></a><a class='right carousel-control' href='#bootstrap-slider' data-slide='next'></a></div>";
        }
    }

    /* Parallax Slider */

    function evolve_parallax() {

        $slides = evolve_get_option( "parallax_slides", array() );

        if ( isset( $slides['enabled'] ) ) {
            $container = false;
            foreach ( $slides['enabled'] as $i => $enabled ) {
                if ( $enabled == 1 ) {
                    if ( ! $container ) {
                        echo "<div id='da-slider' class='da-slider'>";
                        $container = true;
                    }
                    echo "<div class='da-slide'>";
                    echo "<h2>" . esc_attr( $slides['title'][ $i ] ) . "</h2>";
                    echo "<p>" . esc_attr( $slides['description'][ $i ] ) . "</p>";
                    echo do_shortcode( $slides['button'][ $i ] );
                    echo "<div class='da-img'><img class='img-responsive' src='" . $slides['image'][ $i ]['url'] . "' alt='" . esc_attr( $slides['title'][ $i ] ) . "' /></div>";
                    echo "</div>";
                }
            }
            if ( $container ) {
                echo "<nav class='da-arrows'><span class='da-arrows-prev'></span><span class='da-arrows-next'></span></nav></div>";
            }
        }
    }

    /* Front Page Content Boxes */

    function evolve_content_boxes() {

        $evolve_content_boxes       = evolve_get_option( 'evl_content_boxes', '1' );
        $evolve_content_box1_enable = evolve_get_option( 'evl_content_box1_enable', '1' );
        if ( $evolve_content_box1_enable === false ) {
            $evolve_content_box1_enable = '';
        }
        $evolve_content_box2_enable = evolve_get_option( 'evl_content_box2_enable', '1' );
        if ( $evolve_content_box2_enable === false ) {
            $evolve_content_box2_enable = '';
        }
        $evolve_content_box3_enable = evolve_get_option( 'evl_content_box3_enable', '1' );
        if ( $evolve_content_box3_enable === false ) {
            $evolve_content_box3_enable = '';
        }
        $evolve_content_box4_enable = evolve_get_option( 'evl_content_box4_enable', '1' );
        if ( $evolve_content_box4_enable === false ) {
            $evolve_content_box4_enable = '';
        }
        if ( $evolve_content_boxes == "1" ) {

			echo "<div class='home-content-boxes'><div class='row'>";

            $evolve_content_box1_title = evolve_get_option( 'evl_content_box1_title', 'Beautifully Simple' );
            if ( $evolve_content_box1_title === false ) {
                $evolve_content_box1_title = '';
            }
            $evolve_content_box1_desc = evolve_get_option( 'evl_content_box1_desc', 'Clean modern theme with smooth and pixel perfect design focused on details' );
            if ( $evolve_content_box1_desc === false ) {
                $evolve_content_box1_desc = '';
            }
            $evolve_content_box1_button = evolve_get_option( 'evl_content_box1_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>' );
            if ( $evolve_content_box1_button === false ) {
                $evolve_content_box1_button = '';
            }
            $evolve_content_box1_icon = evolve_get_option( 'evl_content_box1_icon', 'fa-cube' );
            if ( $evolve_content_box1_icon === false ) {
                $evolve_content_box1_icon = '';
            }

            $evolve_evl_content_box1_icon_upload = evolve_get_option( 'evl_content_box1_icon_upload' );

            /**
             * Count how many boxes are enabled on frontpage
             * Apply proper responsivity class
             *
             * @since 1.7.5
             */
            $BoxCount = 0; // Box Counter

            if ( $evolve_content_box1_enable == true ) {
                $BoxCount ++;
            }
            if ( $evolve_content_box2_enable == true ) {
                $BoxCount ++;
            }
            if ( $evolve_content_box3_enable == true ) {
                $BoxCount ++;
            }
            if ( $evolve_content_box4_enable == true ) {
                $BoxCount ++;
            }

            switch ( $BoxCount ):
                case $BoxCount == 1:
                    $BoxClass = 'col-md-12';
                    break;

                case $BoxCount == 2:
                    $BoxClass = 'col-md-6';
                    break;

                case $BoxCount == 3:
                    $BoxClass = 'col-md-4';
                    break;

                case $BoxCount == 4:
                    $BoxClass = 'col-md-3';
                    break;

                default:
                    $BoxClass = 'col-md-3';
            endswitch;

            if ( $evolve_content_box1_enable == true ) {

                echo "<div class='col-sm-12 $BoxClass content-box content-box-1'>";

                if ( isset( $evolve_evl_content_box1_icon_upload['url'] ) && ( $evolve_evl_content_box1_icon_upload['url'] !== '' ) ) {
                    echo "<img class='content_box_1_custom_icon' src='" . $evolve_evl_content_box1_icon_upload['url'] . "' height='" . $evolve_evl_content_box1_icon_upload['height'] . "' width='" . $evolve_evl_content_box1_icon_upload['width'] . "' alt=''/>";
                } else {
                    echo "<i class='fa " . $evolve_content_box1_icon . "'></i>";
                }

                echo "<h2>" . esc_attr( $evolve_content_box1_title ) . "</h2>";

                echo "<p>" . do_shortcode( $evolve_content_box1_desc ) . "</p>";

                echo "<div class='cntbox_btn'>" . do_shortcode( $evolve_content_box1_button ) . "</div>";

                echo "</div>";
            }

            $evolve_content_box2_title = evolve_get_option( 'evl_content_box2_title', 'Easy Customizable' );
            if ( $evolve_content_box2_title === false ) {
                $evolve_content_box2_title = '';
            }
            $evolve_content_box2_desc = evolve_get_option( 'evl_content_box2_desc', 'Over a hundred theme options ready to make your website unique' );
            if ( $evolve_content_box2_desc === false ) {
                $evolve_content_box2_desc = '';
            }
            $evolve_content_box2_button = evolve_get_option( 'evl_content_box2_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>' );
            if ( $evolve_content_box2_button === false ) {
                $evolve_content_box2_button = '';
            }
            $evolve_content_box2_icon = evolve_get_option( 'evl_content_box2_icon', 'fa-circle-o-notch' );
            if ( $evolve_content_box2_icon === false ) {
                $evolve_content_box2_icon = '';
            }

            $evolve_evl_content_box2_icon_upload = evolve_get_option( 'evl_content_box2_icon_upload' );

            if ( $evolve_content_box2_enable == true ) {

                echo "<div class='col-sm-12 $BoxClass content-box content-box-2'>";

                if ( isset( $evolve_evl_content_box2_icon_upload['url'] ) && ( $evolve_evl_content_box2_icon_upload['url'] !== '' ) ) {
                    echo "<img class='content_box_2_custom_icon' src='" . $evolve_evl_content_box2_icon_upload['url'] . "' height='" . $evolve_evl_content_box2_icon_upload['height'] . "' width='" . $evolve_evl_content_box2_icon_upload['width'] . "' alt=''/>";
                } else {
                    echo "<i class='fa " . $evolve_content_box2_icon . "'></i>";
                }

                echo "<h2>" . esc_attr( $evolve_content_box2_title ) . "</h2>";

                echo "<p>" . do_shortcode( $evolve_content_box2_desc ) . "</p>";

                echo "<div class='cntbox_btn'>" . do_shortcode( $evolve_content_box2_button ) . "</div>";

                echo "</div>";
            }


            $evolve_content_box3_title = evolve_get_option( 'evl_content_box3_title', 'Contact Form Ready' );
            if ( $evolve_content_box3_title === false ) {
                $evolve_content_box3_title = '';
            }
            $evolve_content_box3_desc = evolve_get_option( 'evl_content_box3_desc', 'Built-In Contact Page with Google Maps is a standard for this theme' );
            if ( $evolve_content_box3_desc === false ) {
                $evolve_content_box3_desc = '';
            }
            $evolve_content_box3_button = evolve_get_option( 'evl_content_box3_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>' );
            if ( $evolve_content_box3_button === false ) {
                $evolve_content_box3_button = '';
            }
            $evolve_content_box3_icon = evolve_get_option( 'evl_content_box3_icon', 'fa-send' );
            if ( $evolve_content_box3_icon === false ) {
                $evolve_content_box3_icon = '';
            }

            $evolve_evl_content_box3_icon_upload = evolve_get_option( 'evl_content_box3_icon_upload' );

            if ( $evolve_content_box3_enable == true ) {

                echo "<div class='col-sm-12 $BoxClass content-box content-box-3'>";

                if ( isset( $evolve_evl_content_box3_icon_upload['url'] ) && ( $evolve_evl_content_box3_icon_upload['url'] !== '' ) ) {
                    echo "<img class='content_box_3_custom_icon' src='" . $evolve_evl_content_box3_icon_upload['url'] . "' height='" . $evolve_evl_content_box3_icon_upload['height'] . "' width='" . $evolve_evl_content_box3_icon_upload['width'] . "' alt=''/>";
                } else {
                    echo "<i class='fa " . $evolve_content_box3_icon . "'></i>";
                }

                echo "<h2>" . esc_attr( $evolve_content_box3_title ) . "</h2>";

                echo "<p>" . do_shortcode( $evolve_content_box3_desc ) . "</p>";

                echo "<div class='cntbox_btn'>" . do_shortcode( $evolve_content_box3_button ) . "</div>";

                echo "</div>";
            }

            $evolve_content_box4_title = evolve_get_option( 'evl_content_box4_title', 'Modern Blog Layouts' );
            if ( $evolve_content_box4_title === false ) {
                $evolve_content_box4_title = '';
            }
            $evolve_content_box4_desc = evolve_get_option( 'evl_content_box4_desc', 'Up to 3 Blog Layouts, responsive on all media devices' );
            if ( $evolve_content_box4_desc === false ) {
                $evolve_content_box4_desc = '';
            }
            $evolve_content_box4_button = evolve_get_option( 'evl_content_box4_button', '<a class="read-more btn t4p-button" href="#">Learn more</a>' );
            if ( $evolve_content_box4_button === false ) {
                $evolve_content_box4_button = '';
            }
            $evolve_content_box4_icon = evolve_get_option( 'evl_content_box4_icon', 'fa-tablet' );
            if ( $evolve_content_box4_icon === false ) {
                $evolve_content_box4_icon = '';
            }

            $evolve_evl_content_box4_icon_upload = evolve_get_option( 'evl_content_box4_icon_upload' );

            if ( $evolve_content_box4_enable == true ) {

                echo "<div class='col-sm-12 $BoxClass content-box content-box-4'>";

                if ( isset( $evolve_evl_content_box4_icon_upload['url'] ) && ( $evolve_evl_content_box4_icon_upload['url'] !== '' ) ) {
                    echo "<img class='content_box_4_custom_icon' src='" . $evolve_evl_content_box4_icon_upload['url'] . "' height='" . $evolve_evl_content_box4_icon_upload['height'] . "' width='" . $evolve_evl_content_box4_icon_upload['width'] . "' alt=''/>";
                } else {
                    echo "<i class='fa " . $evolve_content_box4_icon . "'></i>";
                }

                echo "<h2>" . esc_attr( $evolve_content_box4_title ) . "</h2>";

                echo "<p>" . do_shortcode( $evolve_content_box4_desc ) . "</p>";

                echo "<div class='cntbox_btn'>" . do_shortcode( $evolve_content_box4_button ) . "</div>";

                echo "</div>";
            }
			echo "</div></div><div class='clearfix'></div>";
        }
    }

    class evolve_ThemeFrameworkMetaboxes {

        public function __construct() {
            global $data;
            $this->data = $data;

            add_action( 'add_meta_boxes', array( $this, 'evolve_add_meta_boxes' ) );
            add_action( 'save_post', array( $this, 'evolve_save_meta_boxes' ) );
            add_action( 'admin_print_scripts-post.php', array( $this, 'evolve_print_metabox_scripts' ) );
            add_action( 'admin_print_scripts-post-new.php', array( $this, 'evolve_print_metabox_scripts' ) );
        }

        public function evolve_add_meta_boxes() {
            $this->evolve_add_meta_box( 'evolve_post_options', 'Post Options', 'post' );
            $this->evolve_add_meta_box( 'evolve_page_options', 'Page Options', 'page' );
            $this->evolve_add_meta_box( 'evolve_page_options', 'Additional Portfolio Options', 'evolve_portfolio' );
        }

        public function evolve_add_meta_box( $id, $label, $post_type ) {
            add_meta_box(
                'evolve_' . $id, $label, array( $this, $id ), $post_type
            );
        }

        public function evolve_save_meta_boxes( $post_id ) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            foreach ( $_POST as $key => $value ) {
                if ( strstr( $key, 'evolve_' ) ) {
                    update_post_meta( $post_id, $key, $value );
                }
            }
        }

        public function evolve_post_options() {
            //mod by denzel, removed the requiring of page_options.php and deleted this file.
            $this->evolve_render_metabox();
        }

        public function evolve_page_options() {
            //mod by denzel, removed the requiring of page_options.php and deleted this file. 
            $this->evolve_render_metabox();
        }

        public function evolve_print_metabox_scripts() {
            echo "<style type='text/css'>";
            echo ".evolve_img_selected{border:3px solid #aaa !important;}";
            echo ".evolve_img_border_radio{border:3px solid #dedede;margin:10px 5px 5px 0;cursor:pointer;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;}";
            echo "</style>";
        }

        public function evolve_select( $id, $label, $options, $desc = '' ) {
            global $post;

            $html = '';
            $html .= '<div class="t4p_metabox_field">';
            $html .= '<label for="pyre_' . $id . '">';
            $html .= $label;
            $html .= '</label>';
            $html .= '<div class="field">';
            $html .= '<select id="evolve_' . $id . '" name="evolve_' . $id . '">';
            foreach ( $options as $key => $option ) {
                if ( get_post_meta( $post->ID, 'evolve_' . $id, true ) == $key ) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }

                $html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
            }
            $html .= '</select>';
            if ( $desc ) {
                $html .= '<p>' . $desc . '</p>';
            }
            $html .= '</div>';
            $html .= '</div>';

            echo $html;
        }

        //added by denzel, image radio button.
        public function evolve_image_radio_button( $id, $label, $options, $desc = '', $default = '' ) {
            global $post;
            $class          = '';
            $checked        = '';
            $javascript_ids = '';
            foreach ( $options as $k => $v ) {
                $javascript_ids .= "#image_{$k},";
            }
            $javascript_ids = rtrim( $javascript_ids, "," );

            $html = '';
            $html .= '<div class="t4p_metabox_field">';
            $html .= '<label for="evolve_' . $id . '">';
            $html .= $label;
            $html .= '</label>';
            $html .= '<div class="field">';
            foreach ( $options as $key => $option ) {
                $html .= '<input type="radio" style="display:none;" id="' . $key . '" name="evolve_' . $id . '" value="' . $key . '" ';
                if ( get_post_meta( $post->ID, 'evolve_' . $id, true ) == $key ) {
                    $checked = 'checked="checked"';
                    $class   = 'evolve_img_border_radio evolve_img_selected';
                } elseif ( get_post_meta( $post->ID, 'evolve_' . $id, true ) == '' && $key == $default ) {
                    $checked = 'checked="checked"';
                    $class   = 'evolve_img_border_radio evolve_img_selected';
                } else {
                    $checked = '';
                    $class   = 'evolve_img_border_radio';
                }

                $html .= $checked . ">";
                $html .= "<img src='$option' alt='' id='image_$key' class='$class' onclick='document.getElementById(\"$key\").checked=true;jQuery(\"$javascript_ids\").removeClass(\"evolve_img_selected\");jQuery(this).addClass(\"evolve_img_selected\");' />";
            }
            $html .= '</div>';
            $html .= '</div>';

            echo $html;
        }

        //added by denzel, bring all contents of /library/functions/page_options.php into this function and remove that file!
        public function evolve_render_metabox() {
            ?>
            <div class='t4p_metabox'>
                <h2 style="margin-top:0;"><?php _e( 'Post options', 'evolve' ); ?></h2>
                <?php
                    $imagepath = get_template_directory_uri() . '/library/functions/images/';
                    $this->evolve_image_radio_button(
                        'sidebar_position', __( 'Sidebar Position', 'evolve' ), array(
                        'default' => $imagepath . '1c.png',
                        '2cl'     => $imagepath . '2cl.png',
                        '2cr'     => $imagepath . '2cr.png',
                        '3cm'     => $imagepath . '3cm.png',
                        '3cr'     => $imagepath . '3cr.png',
                        '3cl'     => $imagepath . '3cl.png'
                    ), '', 'default'
                    );
                ?>
                <span class="description"><?php _e( 'Use this setting to select and set position of sidebar', 'evolve' ); ?></span>
                <br/>
                <span class="description"><?php _e( 'If "No Sidebar" is selected, this layout will follow the settings of Theme Options -> General -> Select a layout.', 'evolve' ); ?></span>
                <br/> <br/>
                <?php
                    $this->evolve_select( 'full_width', __( 'Full Width', 'evolve' ), array(
                        'no'  => __( 'No', 'evolve' ),
                        'yes' => __( 'Yes', 'evolve' ),
                    ), ''
                    );
                ?>
                <span class="description" style="position:relative;top:5px"><?php _e( 'If setting full width, Please set the above Sidebar Position to "No Sidebar".', 'evolve' ); ?></span>
                <br/> <br/>

                <h2 style="margin-top:0;"><?php _e( 'Slider Options', 'evolve' ); ?></h2>
                <?php
                    $this->evolve_select( 'slider_type', __( 'Slider Type', 'evolve' ), array(
                        'no'        => __( 'No Slider', 'evolve' ),
                        'layer'     => __( 'LayerSlider', 'evolve' ),
                        'rev'       => __( 'Revolution Slider', 'evolve' ),
                        'flex'      => __( 'Theme4Press Slider', 'evolve' ),
                        'parallax'  => __( 'Parallax Slider', 'evolve' ),
                        'posts'     => __( 'Posts Slider', 'evolve' ),
                        'bootstrap' => __( 'Bootstrap Slider', 'evolve' )
                    ), ''
                    );
                ?>
                <?php
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			
					if ( is_plugin_active( 'LayerSlider/layerslider.php' ) ) {				
                    global $wpdb;
                    $slides_array[0] = __( 'Select a slider', 'evolve' );
                    // Table name
                    $table_name = $wpdb->prefix . "layerslider";

                    // Get sliders
                    $sliders = $wpdb->get_results( "SELECT * FROM $table_name
									WHERE flag_hidden = '0' AND flag_deleted = '0'
									ORDER BY date_c ASC" );

                    if ( ! empty( $sliders ) ):
                        foreach ( $sliders as $key => $item ):
                            $slides[ $item->id ] = '';
                        endforeach;
                    endif;

                    if ( isset( $slides ) && $slides ) {
                        foreach ( $slides as $key => $val ) {
                            $slides_array[ $key ] = 'LayerSlider #' . ( $key );
                        }
                    }
                    $this->evolve_select( 'slider', __( 'Select LayerSlider', 'evolve' ), $slides_array, ''
                    );
					}
                ?>

                <?php
                    global $wpdb;
                    $revsliders[0] = __( 'Select a slider', 'evolve' );
                    if ( function_exists( 'rev_slider_shortcode' ) ) {
                        $get_sliders = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders' );
                        if ( $get_sliders ) {
                            foreach ( $get_sliders as $slider ) {
                                $revsliders[ $slider->alias ] = $slider->title;
                            }
                        }
                    }
                    $this->evolve_select( 'revslider', __( 'Select Revolution Slider', 'evolve' ), $revsliders, ''
                    );
                ?>
                <?php
                    $slides_array    = array();
                    $slides          = array();
                    $slides_array[0] = __( 'Select a slider', 'evolve' );
                    $slides          = get_terms( 'slide-page' );
                    if ( $slides && ! isset( $slides->errors ) ) {
                        $slides = is_array( $slides ) ? $slides : unserialize( $slides );
                        foreach ( $slides as $key => $val ) {
                            $slides_array[ $val->slug ] = $val->name;
                        }
                    }
                    $this->evolve_select( 'wooslider', __( 'Select Theme4Press Slider', 'evolve' ), $slides_array, ''
                    );
                ?>
                <h2 style="margin-top:0;"><?php _e( 'Widget Options', 'evolve' ); ?></h2>
                <?php
                    $this->evolve_select( 'widget_page', __( 'Enable Header Widgets', 'evolve' ), array(
                        'no'  => __( 'No', 'evolve' ),
                        'yes' => __( 'Yes', 'evolve' )
                    ), ''
                    );
                ?>
                <h2 style="margin-top:0;"><?php _e( 'Page title options', 'evolve' ); ?></h2>
                <?php
                    $this->evolve_select( 'page_title', __( 'Page Title', 'evolve' ), array(
                        'yes' => __( 'Show', 'evolve' ),
                        'no'  => __( 'Hide', 'evolve' ),
                    ), ''
                    );
                ?>
                <?php
                    $this->evolve_select( 'page_breadcrumb', __( 'Page Breadcrumb', 'evolve' ), array(
                        'yes' => __( 'Show', 'evolve' ),
                        'no'  => __( 'Hide', 'evolve' ),
                    ), ''
                    );
                ?>
            </div>
            <?php
        }

    }

    $metaboxes = new evolve_ThemeFrameworkMetaboxes;

    /**
     * evolve_Walker_Nav_Menu
     */
    class evolve_Walker_Nav_Menu extends Walker_Nav_Menu {
        /**
         * @see   Walker::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of page. Used for padding.
         */

        /**
         * @see   Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output       Passed by reference. Used to append additional content.
         * @param object $item         Menu item data object.
         * @param int    $depth        Depth of menu item. Used for padding.
         * @param int    $current_page Menu item ID.
         * @param object $args
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            /**
             * Dividers, Headers or Disabled
             * =============================
             * Determine whether the item is a Divider, Header, Disabled or regular
             * menu item. To prevent errors we use the strcasecmp() function to so a
             * comparison that is not case sensitive. The strcasecmp() function returns
             * a 0 if the strings are equal.
             */
            $class_names = $value = '';

            $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            if ( $args->has_children ) {
                $class_names .= ' dropdown';
            }

            if ( in_array( 'current-menu-item', $classes ) ) {
                $class_names .= ' active';
            }

            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            /**
             * PolyLang Broken Flag Images - Fix
             * =================================
             *
             * @by    jerry
             * @since 3.2.0
             * @todo  find better solution
             */
            $item->title_2 = $item->title; // Let's take flag image
            if ( class_exists( 'Polylang' ) ) {
                if ( preg_match( '/<img src=/', $item->title ) ) {
                    $item->title = strip_tags( $item->title ); // Let's remove flag image
                }
            }

            $atts           = array();
            $atts['title']  = ! empty( $item->title ) ? $item->title : '';
            $atts['target'] = ! empty( $item->target ) ? $item->target : '';
            $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
            $atts['href']   = ! empty( $item->url ) ? $item->url : '';


            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;

            /*
         * Glyphicons
         * ===========
         * Since the the menu item is NOT a Divider or Header we check the see
         * if there is a value in the attr_title property. If the attr_title
         * property is NOT null we apply it as the class name for the glyphicon.
         */
            if (evolve_get_option('evl_main_menu_hover_effect', 'rollover') == 'disable') {
                $item_output .= '<a' . $attributes . '>';
            } else {
                $item_output .= '<a' . $attributes . '><span data-hover="' . $item->title . '">';
            }

            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title_2, $item->ID ) . $args->link_after;
            $item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="arrow"></span>' : '';
            if (evolve_get_option('evl_main_menu_hover_effect', 'rollover') == 'disable') {
                $item_output .= '</a>';
            } else {
                $item_output .= '</span></a>';
            }
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * Traverse elements to create list from elements.
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth.
         * This method shouldn't be called directly, use the walk() method instead.
         *
         * @see   Walker::start_el()
         * @since 2.5.0
         *
         * @param object $element           Data object
         * @param array  $children_elements List of elements to continue traversing.
         * @param int    $max_depth         Max depth to traverse.
         * @param int    $depth             Depth of current element.
         * @param array  $args
         * @param string $output            Passed by reference. Used to append additional content.
         *
         * @return null Null on failure with no changes to parameters.
         */
        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            if ( ! $element ) {
                return;
            }

            $id_field = $this->db_fields['id'];

            // Display this element.
            if ( is_object( $args[0] ) ) {
                $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
            }

            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }

    }

    //end evolve_Walker_Nav_Menu
    // Breadcrumbs //

    function evolve_breadcrumb() {
        global $data, $post;

        echo '<ul class="breadcrumbs">';

        echo '<li><a class="home" href="';
        echo home_url();
        echo '">' . __( 'Home', 'evolve' );
        echo "</a></li>";

        $params['link_none'] = '';
        $separator           = '';

        if ( is_category() ) {
            $category = get_the_category();
            $ID       = $category[0]->cat_ID;
            echo is_wp_error( $cat_parents = get_category_parents( $ID, true, '', false ) ) ? '' : '<li>' . $cat_parents . '</li>';
        }

        if ( is_tax() ) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            echo '<li>' . $term->name . '</li>';
        }

        if ( is_home() ) {
            echo '<li>' . $data['blog_title'] . '</li>';
        }
        if ( is_page() && ! is_front_page() ) {
            $parents   = array();
            $parent_id = $post->post_parent;
            while ( $parent_id ) :
                $page = get_page( $parent_id );
                if ( $params["link_none"] ) {
                    $parents[] = get_the_title( $page->ID );
                } else {
                    $parents[] = '<li><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>' . $separator;
                }
                $parent_id = $page->post_parent;
            endwhile;
            $parents = array_reverse( $parents );
            echo join( ' ', $parents );
            echo '<li>' . get_the_title() . '</li>';
        }
        if ( is_single() && ! is_attachment() ) {
            $cat_1_line   = '';
            $categories_1 = get_the_category( $post->ID );
            if ( $categories_1 ):
                foreach ( $categories_1 as $cat_1 ):
                    $cat_1_ids[] = $cat_1->term_id;
                endforeach;
                $cat_1_line = implode( ',', $cat_1_ids );
            endif;
            $categories = get_categories( array(
                'include' => $cat_1_line,
                'orderby' => 'id'
            ) );
            if ( $categories ) :
                foreach ( $categories as $cat ) :
                    $cats[] = '<li><a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
                endforeach;
                echo join( ' ', $cats );
            endif;
            echo '<li>' . get_the_title() . '</li>';
        }
        if ( is_tag() ) {
            echo '<li>' . "Tag: " . single_tag_title( '', false ) . '</li>';
        }
        if ( is_404() ) {
            echo '<li>' . __( "404 - Page not Found", 'evolve' ) . '</li>';
        }
        if ( is_search() ) {
            echo '<li>' . __( "Search", 'evolve' ) . '</li>';
        }
        if ( is_year() ) {
            echo '<li>' . get_the_time( 'Y' ) . '</li>';
        }
        if ( is_attachment() ) {
            if ( ! empty( $post->post_parent ) ) {
                echo "<li><a href='" . get_permalink( $post->post_parent ) . "'>" . get_the_title( $post->post_parent ) . "</a></li>";
            }
            echo "<li>" . get_the_title() . "</li>";
        }

        echo "</ul>";
    }

    function evolve_posts_slider() {
        ?>
        <div id="slide_holder">
            <div class="slide-container">

                <ul id="slides">

                    <?php
                        $number_items            = evolve_get_option( 'evl_posts_number', '5' );
                        $slider_content          = evolve_get_option( 'evl_posts_slider_content', 'recent' );
                        $slider_content_category = '';
                        $slider_content_category = evolve_get_option( 'evl_posts_slider_id', '' );
                        //make array categories into string with commas.
                        if ( is_array( $slider_content_category ) ) {
                            $slider_content_category = implode( ",", $slider_content_category );
                        }

                        if ( $slider_content == "category" && ! empty( $slider_content_category ) ) {
                            $slider_content_ID = $slider_content_category;
                        } else {
                            $slider_content_ID = '';
                        }

                        $args = array(
                            'cat'                 => $slider_content_ID,
                            'showposts'           => $number_items,
                            'ignore_sticky_posts' => 1,
                        );
                        query_posts( $args );

                        if ( have_posts() ) : $featured = new WP_Query( $args );
                            while ( $featured->have_posts() ) : $featured->the_post();
                                ?>

                                <li class="slide">

                                    <?php
                                        if ( has_post_thumbnail() ) {
                                            echo '<div class="featured-thumbnail"><a href="';
                                            the_permalink();
                                            echo '">';
                                            the_post_thumbnail( 'slider-thumbnail' );
                                            echo '</a></div>';
                                        } else {
                                            $image = evolve_get_first_image();
                                            if ( $image ):
                                                echo '<div class="featured-thumbnail"><a href="';
                                                the_permalink();
                                                echo '"><img src="' . $image . '" alt="';
                                                the_title();
                                                echo '" /></a></div>';
                                            endif;
                                        }
                                    ?>

                                    <h2 class="featured-title">
                                        <a class="title" href="<?php the_permalink() ?>">
                                            <?php
                                                $title  = the_title( '', '', false );
                                                $length = evolve_get_option( 'evl_posts_slider_title_length', 40 );
                                                echo evolve_truncate( $title, $length, '...' );
                                            ?>
                                        </a>
                                    </h2>

                                    <p><?php
                                            $excerpt_length = evolve_get_option( 'evl_posts_slider_excerpt_length', 40 );
                                            echo evolve_excerpt_max_charlength( $excerpt_length );
                                        ?></p>
                                    <a class="button post-more" href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'evolve' ); ?></a>

                                </li>

                            <?php endwhile; ?>

                        <?php else: ?>
                            <li><?php _e( '<h2 style="color:#fff;">Oops, no posts to display! Please check your post slider Category (ID) settings</h2>', 'evolve' ); ?></li>

                        <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
            </div>
        </div>
        <?php
    }

    // Register default function when plugin not activated
    add_action( 'wp_head', 'evolve_plugins_loaded' );

    function evolve_plugins_loaded() {
        if ( ! function_exists( 'is_woocommerce' ) ) {

            function is_woocommerce() {
                return false;
            }

        }
        if ( ! function_exists( 'is_bbpress' ) ) {

            function is_bbpress() {
                return false;
            }

        }
    }

    /* Theme Activation Hook */
    add_action( 'admin_init', 'evolve_theme_activation' );

    function evolve_theme_activation() {
        global $pagenow;
        if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
            update_option( 'shop_catalog_image_size', array( 'width' => 500, 'height' => '', 0 ) );
            update_option( 'shop_single_image_size', array( 'width' => 500, 'height' => '', 0 ) );
            update_option( 'shop_thumbnail_image_size', array( 'width' => 120, 'height' => '', 0 ) );
        }
    }

    /**
     * Woo Config
     */
    include_once( get_template_directory() . '/library/woo-config.php' );

    if ( ! function_exists( 't4p_addURLParameter' ) ) {
        function t4p_addURLParameter( $url, $paramName, $paramValue ) {
            $url_data = parse_url( $url );
            if ( ! isset( $url_data["query"] ) ) {
                $url_data["query"] = "";
            }

            $params = array();
            parse_str( $url_data['query'], $params );
            $params[ $paramName ] = $paramValue;

            if ( $paramName == 'product_count' ) {
                $params['paged'] = '1';
            }
            $url_data['query'] = http_build_query( $params );

            return t4p_build_url( $url_data );
        }
    }
    function t4p_build_url( $url_data ) {
        $url = "";
        if ( isset( $url_data['host'] ) ) {
            $url .= $url_data['scheme'] . '://';
            if ( isset( $url_data['user'] ) ) {
                $url .= $url_data['user'];
                if ( isset( $url_data['pass'] ) ) {
                    $url .= ':' . $url_data['pass'];
                }
                $url .= '@';
            }
            $url .= $url_data['host'];
            if ( isset( $url_data['port'] ) ) {
                $url .= ':' . $url_data['port'];
            }
        }
        if ( isset( $url_data['path'] ) ) {
            $url .= $url_data['path'];
        }
        if ( isset( $url_data['query'] ) ) {
            $url .= '?' . $url_data['query'];
        }
        if ( isset( $url_data['fragment'] ) ) {
            $url .= '#' . $url_data['fragment'];
        }

        return $url;
    }

    //////////////////////////////////////////////////////////////////
    // Woo Products Shortcode Recode
    //////////////////////////////////////////////////////////////////
    function evolve_woo_product( $atts, $content = null ) {
        global $woocommerce_loop;

        if ( empty( $atts ) ) {
            return;
        }

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => '_visibility',
                    'value'   => array( 'catalog', 'visible' ),
                    'compare' => 'IN'
                )
            ),
            'columns'        => 1
        );

        if ( isset( $atts['sku'] ) ) {
            $args['meta_query'][] = array(
                'key'     => '_sku',
                'value'   => $atts['sku'],
                'compare' => '='
            );
        }

        if ( isset( $atts['id'] ) ) {
            $args['p'] = $atts['id'];
        }

        ob_start();

        if ( isset( $columns ) ) {
            $woocommerce_loop['columns'] = $columns;
        }

        $products = new WP_Query( $args );

        if ( $products->have_posts() ) :
            ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

            <?php woocommerce_get_template_part( 'content', 'product' ); ?>

        <?php endwhile; // end of the loop. 
            ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
        endif;

        wp_reset_postdata();

        return '<div class="woocommerce">' . ob_get_clean() . '</div>';
    }

    add_action( 'wp_loaded', 'remove_product_shortcode' );

    function remove_product_shortcode() {
        if ( class_exists( 'Woocommerce' ) ) {
            // First remove the shortcode
            remove_shortcode( 'product' );
            // Then recode it
            add_shortcode( 'product', 'evolve_woo_product' );
        }
    }

    /**
     * Infinite Scroll
     *
     * @since 3.2.0
     */
    add_action( 'wp_footer', 'evolve_infinite_scroll' );

    function evolve_infinite_scroll() {
        global $wp_query;

        $evolve_pagination_type = evolve_get_option( 'evl_pagination_type', 'pagination' );

        if ( $evolve_pagination_type == "infinite" && ! is_single() ) {
            echo '<script>';
            echo '
			var ias = jQuery.ias({
			 container: "#primary",
			 item: ".post",
			 pagination: ".navigation-links",
			 next: ".nav-previous a",
		   });
		   
			ias.extension(new IASTriggerExtension({
				text: "Load more items",
				offset: 99999
			}));
		   ias.extension(new IASSpinnerExtension({
				src: "' . get_template_directory_uri() . '/library/media/images/loader.gif"			   
		   }));
		   ias.extension(new IASNoneLeftExtension());
		';
            echo '</script>';
        }
    }


    add_action( 'wp_footer', 'evolve_infinite_scroll_blog' );

    function evolve_infinite_scroll_blog() {
        global $wp_query;

        echo '<script>';

        echo '
			if (jQuery(".posts-container-infinite").length == 1) {
			var ias = jQuery.ias({
			 container: ".posts-container-infinite",
			 item: "div.post",
			 pagination: "div.pagination",
			 next: "a.pagination-next",
		   });
		   
			ias.extension(new IASTriggerExtension({
				text: "Load more items",
				offset: 99999
			}));
		   ias.extension(new IASSpinnerExtension({
				src: "' . get_template_directory_uri() . '/library/media/images/loader.gif"			   
		   }));
		   ias.extension(new IASNoneLeftExtension());
			}
		';
        echo '</script>';

    }


    /*
 * function to print out css class according to layout or post meta
 * used in content-blog.php, index.php, buddypress.php, bbpress.php
 * @since 3.3.0
 * 
 * added by Denzel
 */

    function evolve_layout_class( $type = 1 ) {
        //$type = 1 is for content-blog.php and index.php, which includes the get_post_meta($post->ID, 'evolve_full_width', true)..
        //$type = 2 is for buddypress.php and bbpress.php, which EXCLUDES the get_post_meta($post->ID, 'evolve_full_width', true)..
        global $post;
        global $wp_query;
        $evolve_layout      = evolve_get_option( 'evl_layout', '2cl' );
        $evolve_post_layout = evolve_get_option( 'evl_post_layout', 'two' );

        $post_id = '';
        if ( $wp_query->is_posts_page ) {
            $post_id = get_option( 'page_for_posts' );
        } else {
            $post_id = isset( $post->ID ) ? $post->ID : '';
        }

        $layout_css = '';

        if ( $evolve_layout == "1c" ) {
            $layout_css .= ' col-md-12';
        } else {

            $layout_css .= ' col-xs-12 col-sm-6';

            if ( ( $evolve_layout == "2cr" && ( $evolve_post_layout == "two" ) || $evolve_layout == "2cl" && ( $evolve_post_layout == "two" ) ) ) {
                $layout_css .= ' col-md-8';
            }

            if ( ( $evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr" ) ) {
                $layout_css .= ' col-md-6';
            } else {
                $layout_css .= ' col-md-8';
            }

            if ( is_single() || is_page() || is_404() || is_search() ) {
                $layout_css .= ' col-single';
            }
        }

        if ( $type == 1 ) {


            if ( class_exists( 'Woocommerce' ) ):
                if ( is_cart() || is_checkout() || is_account_page() || ( get_option( 'woocommerce_thanks_page_id' ) && is_page( get_option( 'woocommerce_thanks_page_id' ) ) ) ) {
                    $layout_css .= ' full-width';
                }
            endif;
        }


        if ( is_single() || is_page() || $wp_query->is_posts_page ):

            if ( $type == 1 ) {

                //Moved from the above, Do this only in single.php or page.php
                if ( get_post_meta( $post_id, 'evolve_full_width', true ) == 'yes' ) {
                    $layout_css .= ' full-width';
                }
            }

            $evolve_sidebar_position = get_post_meta( $post_id, 'evolve_sidebar_position', true );

            if ( $evolve_sidebar_position == '2cl' ) {
                $layout_css = 'col-xs-12 col-sm-6 col-md-8 col-md-8 float-left';
            }

            if ( $evolve_sidebar_position == '2cr' ) {
                $layout_css = 'col-xs-12 col-sm-6 col-md-8 col-md-8 float-right';
            }

            if ( $evolve_sidebar_position == "3cm" ) {
                $layout_css = 'col-xs-12 col-sm-6 col-md-6 float-left';
            }

            if ( $evolve_sidebar_position == "3cr" ) {
                $layout_css = 'col-xs-12 col-sm-6 col-md-6 float-right';
            }

            if ( $evolve_sidebar_position == "3cl" ) {
                $layout_css = 'col-xs-12 col-sm-6 col-md-6 float-left';
            }

            if ( is_single() || is_page() || $wp_query->is_posts_page ) {
                $layout_css .= ' col-single';
            }

        endif;

        echo $layout_css;
    }

    /*
 * function to print out css class according to layout
 * used in content-blog.php, index.php.
 * 
 * added by Denzel
 */

    function evolve_post_class( $xyz ) {

        $evolve_post_layout = evolve_get_option( 'evl_post_layout', 'two' );

        if ( $evolve_post_layout == "two" ) {
            echo ' col-md-6 odd' . ( $xyz % 2 );
        } else {
            echo ' col-md-4 odd' . ( $xyz % 3 );
        }

        if ( has_post_format( array(
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video'
        ), '' ) ) {
            echo ' formatted-post';
        }
    }

    /*
 * function to print out css class according to post format
 * used in content-blog.php, index.php.
 * 
 * added by Denzel
 */

    function evolve_post_class_2() {
        if ( has_post_format( array(
                'aside',
                'audio',
                'chat',
                'gallery',
                'image',
                'link',
                'quote',
                'status',
                'video'
            ), '' ) || is_sticky()
        ) {
            echo 'formatted-post formatted-single margin-40';
        }
    }

    /*
 * function to print out css class according to layout
 * used in sidebar.php and sidebar-2.php
 * 
 * added by Denzel
 */

    function evolve_sidebar_class() {

        global $wp_query;
        global $post;
        $post_id = '';
        if ( $wp_query->is_posts_page ) {
            $post_id = get_option( 'page_for_posts' );
        } else {
            $post_id = isset( $post->ID ) ? $post->ID : '';
        }

        $sidebar_css = '';

        $evolve_layout = evolve_get_option( 'evl_layout', '2cl' );

        //use PHP switch statement, is easier to understand.
        switch ( $evolve_layout ):
            case "1c":
                //do nothing
                break;
            case "2cl":
                $sidebar_css = 'col-sm-6 col-md-4';
                break;
            case "2cr":
                $sidebar_css = 'col-sm-6 col-md-4';
                break;
            case "3cm":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3';
                break;
            case "3cl":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3';
                break;
            case "3cr":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3';
                break;
        endswitch;

        $evolve_sidebar_position = get_post_meta( $post_id, 'evolve_sidebar_position', true );

        //use PHP switch statement, is easier to understand.
        switch ( $evolve_sidebar_position ):
            case "default":
                //do nothing
                break;
            case "2cl":
                $sidebar_css = 'col-sm-6 col-md-4';
                break;
            case "2cr":
                $sidebar_css = 'col-sm-6 col-md-4';
                break;
            case "3cm":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3';
                break;
            case "3cl":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3 float-right';
                break;
            case "3cr":
                $sidebar_css = 'col-xs-12 col-sm-6 col-md-3 float-left';
                break;
        endswitch;


        echo $sidebar_css;
    }

    /*
 * function to determine whether to get_sidebar, depending on theme options layout and post meta layout.
 * used in 404.php, archive.php, attachment.php, author.php, bbpress.php, blog-page.php,... 
 * buddypress.php, index.php, page.php, search.php single.php
 * 
 * @return boolean indicates whether to load sidebar.
 * added by Denzel
 */

    function evolve_lets_get_sidebar() {

        global $wp_query;
        global $post;
        $post_id = '';
        if ( $wp_query->is_posts_page ) {
            $post_id = get_option( 'page_for_posts' );
        } else {
            $post_id = isset( $post->ID ) ? $post->ID : '';
        }

        $get_sidebar = false;

        $evolve_layout = evolve_get_option( 'evl_layout', '2cl' );

        if ( $evolve_layout != "1c" ) {
            $get_sidebar = true;
        }

        if ( ( is_page() || is_single() || $wp_query->is_posts_page ) && get_post_meta( $post_id, 'evolve_full_width', true ) == 'yes' ) {
            $get_sidebar = false;
        }

        if ( is_single() || is_page() || $wp_query->is_posts_page ):

            $evolve_sidebar_position = get_post_meta( $post_id, 'evolve_sidebar_position', true );

            if ( $evolve_sidebar_position != 'default' && $evolve_sidebar_position != '' ) {
                $get_sidebar = true;
            }

        endif;

        return $get_sidebar;
    }

    /*
 * function to determine whether to get_sidebar('2'), depending on theme options layout and post meta layout.
 * used in 404.php, archive.php, attachment.php, author.php, bbpress.php, blog-page.php,... 
 * buddypress.php, index.php, page.php, search.php single.php
 * 
 * @return boolean indicates whether to load sidebar.
 * added by Denzel
 */

    function evolve_lets_get_sidebar_2() {

        global $wp_query;
        global $post;
        $post_id = '';
        if ( $wp_query->is_posts_page ) {
            $post_id = get_option( 'page_for_posts' );
        } else {
            $post_id = isset($post->ID) ? $post->ID : '';
        }

        $get_sidebar = false;

        $evolve_layout = evolve_get_option( 'evl_layout', '2cl' );

        if ( $evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr" ) {
            $get_sidebar = true;
        }

        if ( ( is_page() || is_single() || $wp_query->is_posts_page ) && get_post_meta( $post_id, 'evolve_full_width', true ) == 'yes' ) {
            $get_sidebar = false;
        }

        if ( is_single() || is_page() || $wp_query->is_posts_page ):

            $evolve_sidebar_position = get_post_meta( $post_id, 'evolve_sidebar_position', true );

            if ( $evolve_sidebar_position == '2cl' || $evolve_sidebar_position == '2cr' ) {
                $get_sidebar = false;
            }

            if ( $evolve_sidebar_position == "3cm" || $evolve_sidebar_position == "3cl" || $evolve_sidebar_position == "3cr" ) {
                $get_sidebar = true;
            }

        endif;

        return $get_sidebar;
    }

    //importer
    $importer = get_template_directory() . '/library/plugins/importer/importer.php';
    include( $importer );

    //import demo data success message!
    add_action( 'admin_notices', 'evolve_importer_admin_notice' );

    function evolve_importer_admin_notice() {
        if ( isset( $_GET['imported'] ) && $_GET['imported'] == 'success' ) {
            echo '<div id="setting-error-settings_updated" class="updated settings-error"><p>';
            printf( __( 'Successfully imported demo data!', 'evolve' ) );
            echo "</p></div>";
        }
    }

	function evolve_print_fonts($name, $css_class, $additional_css = '', $additional_color_css_class = '',$imp='') {		
        global $evl_options;
        $options     = $evl_options;
        $css         = '';
        $font_size   = '';
        $font_family = '';
        $font_style  = '';
        $font_weight = '';
        $color       = '';
        if ( $options[ $name ]['font-size'] != '' ) {
            $font_size = $options[ $name ]['font-size'];
            $css .= "$css_class{font-size:" . $font_size ." ".$imp.";}";
        }
        if ( $options[ $name ]['font-family'] != '' ) {
            $font_family = $options[ $name ]['font-family'];
            $css .= "$css_class{font-family:" . $font_family . " !important;}";
        }
        if ( isset( $options[ $name ]['font-style'] ) && $options[ $name ]['font-style'] != '' ) {
            $font_style = $options[ $name ]['font-style'];
            $css .= "$css_class{font-style:" . $font_style . " !important;}";
        }
        if ( isset( $options[ $name ]['font-weight'] ) && $options[ $name ]['font-weight'] != '' ) {
            $font_weight = $options[ $name ]['font-weight'];
            $css .= "$css_class{font-weight:" . $font_weight . " !important;}";
        }
        if ( $options[ $name ]['color'] != '' ) {
            $color = $options[ $name ]['color'];
            $css .= "$css_class{color:" . $color . " !important;}";
        }
        if ( $additional_css != '' ) {
            $css .= "$css_class{" . $additional_css . ";}";
        }
        if ( $additional_color_css_class != '' ) {
            $color = $options[ $name ]['color'];
            $css .= "$additional_color_css_class{color:" . $color . " !important;}";
        }

        return $css;
    }

    if ( ! function_exists( 'evolve_custom_number_paging_nav' ) ) :

        function evolve_custom_number_paging_nav() {
            // Don't print empty markup if there's only one page.
            if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
                return;
            }

            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

            $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

            // Set up paginated links.
            $links = paginate_links( array(
                'base'      => $pagenum_link,
                'format'    => $format,
                'total'     => $GLOBALS['wp_query']->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 3,
                'add_args'  => array_map( 'urlencode', $query_args ),
                'prev_text' => sprintf( '<span class="t4p-icon-chevron-left"></span> %s', __( 'Previous ', 'evolve' ) ),
                'next_text' => sprintf( '%s <span class="t4p-icon-chevron-right"></span>', __( 'Next ', 'evolve' ) ),
                'type'      => 'list',
            ) );

            if ( $links ) :

                echo $links;

            endif;
        }
    endif;


    // Theme4Press Core Blog Shortcode
    function t4p_process_tag( $m ) {
        if ( $m[2] == 'dropcap' || $m[2] == 'highlight' || $m[2] == 'tooltip' ) {
            return $m[0];
        }

        // allow [[foo]] syntax for escaping a tag
        if ( $m[1] == '[' && $m[6] == ']' ) {
            return substr( $m[0], 1, - 1 );
        }

        return $m[1] . $m[6];
    }

    if ( ! function_exists( 't4p_hexdarker' ) ) {

        // Theme4Press Core Button Shortcode
        function t4p_hexdarker( $hex, $factor = 10 ) {
            $new_hex = '';

            $base['R'] = hexdec( $hex{0} . $hex{1} );
            $base['G'] = hexdec( $hex{2} . $hex{3} );
            $base['B'] = hexdec( $hex{4} . $hex{5} );

            foreach ( $base as $k => $v ) {
                $amount      = $v / 100;
                $amount      = round( $amount * $factor );
                $new_decimal = $v - $amount;

                $new_hex_component = dechex( $new_decimal );
                if ( strlen( $new_hex_component ) < 2 ) {
                    $new_hex_component = "0" . $new_hex_component;
                }
                $new_hex .= $new_hex_component;
            }

            return $new_hex;
        }

    }

    // Portfolio Related Projects
    function get_related_projects( $post_id, $number_posts = 8 ) {
        $query = new WP_Query();

        $args = '';

        if ( $number_posts == 0 ) {
            return $query;
        }


        $item_cats = get_the_terms( $post_id, 'portfolio_category' );
        if ( $item_cats ):
            foreach ( $item_cats as $item_cat ) {
                $item_array[] = $item_cat->term_id;
            }
        endif;

        $args = wp_parse_args( $args, array(
            'posts_per_page'      => $number_posts,
            'post__not_in'        => array( $post_id ),
            'ignore_sticky_posts' => 0,
            'meta_key'            => '_thumbnail_id',
            'post_type'           => 'evolve_portfolio',
            'tax_query'           => array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field'    => 'id',
                    'terms'    => $item_array
                )
            )
        ) );

        $query = new WP_Query( $args );

        return $query;
    }

    // Portfolio Pagination
    if ( ! function_exists( 't4p_pagination' ) ):
        function t4p_pagination( $pages = '', $range = 2, $current_query = '' ) {
            global $smof_data;
            global $evl_options;
            $showitems = ( $range * 2 ) + 1;

            if ( $current_query == '' ) {
                global $paged;
                if ( empty( $paged ) ) {
                    $paged = 1;
                }
            } else {
                $paged = $current_query->query_vars['paged'];
            }

            if ( $pages == '' ) {
                if ( $current_query == '' ) {
                    global $wp_query;
                    $pages = $wp_query->max_num_pages;
                    if ( ! $pages ) {
                        $pages = 1;
                    }
                } else {
                    $pages = $current_query->max_num_pages;
                }
            }

            if ( 1 != $pages ) {
                //if ( ( $evl_options['evl_portfolio_pagination_type'] == 'Infinite Scroll' && is_home() ) || ( $evl_options['evl_portfolio_pagination_type'] == 'Infinite Scroll' && is_page_template('portfolio-grid.php') ) ) {          
                //	echo "<div class='pagination infinite-scroll clearfix'>";
                //} else {
                echo "<div class='pagination clearfix'>";
                //}
                //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><span class='arrows'>&laquo;</span> First</a>";
                if ( $paged > 1 ) {
                    echo "<a class='pagination-prev' href='" . get_pagenum_link( $paged - 1 ) . "'><span class='page-prev'></span>" . __( 'Previous', 'evolve' ) . "</a>";
                }

                for ( $i = 1; $i <= $pages; $i ++ ) {
                    if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
                        echo ( $paged == $i ) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link( $i ) . "' class='inactive' >" . $i . "</a>";
                    }
                }

                if ( $paged < $pages ) {
                    echo "<a class='pagination-next' href='" . get_pagenum_link( $paged + 1 ) . "'>" . __( 'Next', 'evolve' ) . "<span class='page-next'></span></a>";
                }
                //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last <span class='arrows'>&raquo;</span></a>";
                echo "</div>\n";
            }
        }
    endif;


    // Custom RSS Link
    add_filter( 'feed_link', 'pyre_feed_link', 1, 2 );
    function pyre_feed_link( $output, $feed ) {
        if ( isset( $smof_data['rss_link'] ) && $smof_data['rss_link'] ) {
            $feed_url = $smof_data['rss_link'];

            $feed_array          = array(
                'rss'           => $feed_url,
                'rss2'          => $feed_url,
                'atom'          => $feed_url,
                'rdf'           => $feed_url,
                'comments_rss2' => ''
            );
            $feed_array[ $feed ] = $feed_url;
            $output              = $feed_array[ $feed ];
        }

        return $output;
    }

    function t4p_hex2rgb( $hex ) {
        if ( strpos( $hex, 'rgb' ) !== false ) {

            $rgb_part = strstr( $hex, '(' );
            $rgb_part = trim( $rgb_part, '(' );
            $rgb_part = rtrim( $rgb_part, ')' );
            $rgb_part = explode( ',', $rgb_part );

            $rgb = array( $rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3] );

        } elseif ( $hex == 'transparent' ) {
            $rgb = array( '255', '255', '255', '0' );
        } else {

            $hex = str_replace( '#', '', $hex );

            if ( strlen( $hex ) == 3 ) {
                $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
                $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
                $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
            } else {
                $r = hexdec( substr( $hex, 0, 2 ) );
                $g = hexdec( substr( $hex, 2, 2 ) );
                $b = hexdec( substr( $hex, 4, 2 ) );
            }
            $rgb = array( $r, $g, $b );
        }

        return $rgb; // returns an array with the rgb values
    }

    /**
     * Menu fallback. Link to the menu editor if that is useful.
     *
     * @param  array $args
     *
     * @return string
     */
    function link_to_menu_editor( $args ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // see wp-includes/nav-menu-template.php for available arguments
        extract( $args );

        $link = $link_before
                . '<a href="' . admin_url( 'nav-menus.php' ) . '">' . $before . 'Add a menu' . $after . '</a>'
                . $link_after;

        // We have a list
        if ( false !== stripos( $items_wrap, '<ul' )
             or false !== stripos( $items_wrap, '<ol' )
        ) {
            $link = "<li>$link</li>";
        }

        $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
        if ( ! empty ( $container ) ) {
            $output = "<$container class='$container_class' id='$container_id'>$output</$container>";
        }

        if ( $echo ) {
            echo $output;
        }

        return $output;
}

/**
 * Page Title Bar Display in post, page, woocommerce etc
 *
 * 
 * 
 */

function evolve_page_title_bar( $title, $subtitle, $secondary_content ) {
?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
				<div class="page-title-captions">
					<?php if( $title ): ?>
						<h1 class="entry-title"><?php echo $title; ?></h1>
						<?php if( $subtitle ): ?>
						<h3><?php echo $subtitle; ?></h3>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<?php echo $secondary_content; ?>
			</div>
		</div>
	</div>
<?php }

function evolve_current_page_title_bar( $post_id ) {
	global $post;
    global $wp_query;

    $post_id = '';
    if ($wp_query->is_posts_page) {
        $post_id = get_option('page_for_posts');
    } else {
        $post_id = isset($post->ID) ? $post->ID : '';
    }
	
	$evolve_page_titlebar = evolve_get_option('page_title_bar', '1');

	ob_start();
	
    $evolve_breadcrumbs = evolve_get_option('evl_breadcrumbs', '1');
    if ($evolve_breadcrumbs == "1"):
        if (is_home() || is_front_page()):
        elseif ((is_single() && get_post_meta($post_id, 'evolve_page_breadcrumb', true) == 'no') || (is_page() && get_post_meta($post_id, 'evolve_page_breadcrumb', true) == 'no')):
        else:evolve_breadcrumb();
        endif;
    endif;

	$secondary_content = ob_get_contents();
	ob_get_clean();

	$title = '';
	$subtitle = '';
	
	if( get_post_meta( $post_id, 'pyre_page_title_custom_text', true ) != '' ) {
		$title = get_post_meta( $post_id, 'pyre_page_title_custom_text', true );
	}

	if( get_post_meta( $post_id, 'pyre_page_title_custom_subheader', true ) != '' ) {
		$subtitle = get_post_meta( $post_id, 'pyre_page_title_custom_subheader', true );
	}

	if( ! $title ) {
		$title = get_the_title();

		if( is_home() ) {
		}

		if( is_search() ) {
			$title = __('Search results for:', 'evolve') . get_search_query();
		}

		if( is_404() ) {
			$title = __('Error 404 Page', 'evolve');
		}

			if( is_archive() && 
				! is_bbpress()
			) {
			if ( is_day() ) {
				$title = __( 'Daily Archives: ', 'evolve' ) . '<span>' . get_the_date() . '</span>';
			} else if ( is_month() ) {
				$title = __( 'Monthly Archives: ', 'evolve' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'evolve' ) ) . '</span>';
			} elseif ( is_year() ) {
				$title = __( 'Yearly Archives: ', 'evolve' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'evolve' ) ) . '</span>';
			} elseif ( is_author() ) {
				$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $_GET['author_name'] ) : get_user_by(  'id', get_the_author_meta('ID') );
				$title = $curauth->nickname;
			} else {
				$title = single_cat_title( '', false );
			}
		}

		if( class_exists( 'Woocommerce' ) && is_woocommerce() && ( is_product() || is_shop() ) && ! is_search() ) {
			if( ! is_product() ) {
				$title = woocommerce_page_title( false );
			}
		}
	}

	if ( ! $subtitle ) {

	}
	
	
	if( ! is_archive() && ! is_search() && ! ( is_home() && ! is_front_page() ) ) {
		if( get_post_meta( $post_id, 'pyre_page_title', true ) == 'yes' ||
			( ($evolve_page_titlebar != 0) && (get_post_meta( $post_id, 'pyre_page_title', true ) != 'no') )
		) {

			if( get_post_meta( $post_id, 'pyre_page_title_text', true ) == 'no' ) {
				$title = '';
				$subtitle = '';
			}
				if( is_home() && is_front_page() ) {
					// do nothing
			} else {		
			evolve_page_title_bar( $title, $subtitle, $secondary_content );
			}			
			
		}
	} else {

		if( is_home() ) {
			// do nothing
		} else {		
		if( evolve_get_option('page_title_bar', '1') ) {
			evolve_page_title_bar( $title, $subtitle, $secondary_content );
		}
		}
	}		
}