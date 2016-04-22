<!--BEGIN .header-pattern-->
<div class="new-top-menu">
    <div class="container">
        <div class="clearfix">
            <div class="col-md-6">
                <div class="row">
                    <div class="top-menu h4-menu center-menu" >
                        <?php
                        if (has_nav_menu('top-menu')) {
                            echo '<nav class="nav nav-holder link-effect">';
                            wp_nav_menu(array('theme_location' => 'top-menu', 'menu_class' => 'new-top-menu-cont nav-menu', 'menu_id' => '', 'depth' => 2, 'fallback_cb' => 'link_to_menu_editor', 'walker' => new evolve_Walker_Nav_Menu()));
                        } else {
                            ?>
                            <nav class="nav nav-holder">
                                <?php
                                wp_nav_menu(array('theme_location' => 'top-menu', 'menu_class' => 'new-top-menu-cont nav-menu', 'fallback_cb' => 'link_to_menu_editor'));
                            }
                            ?>
                        </nav>
                    </div><!-- /.primary-menu -->
                </div>
            </div>

            <?php
            $evolve_social_links = evolve_get_option('evl_social_links', '1');
            if ($evolve_social_links == "1") {
                ?>
                <div class="col-md-6">
                    <div class="top-menu-social-container">
                        <!--BEGIN #subscribe-follow-->
                        <div class="top-menu-social">
                            <?php
                            get_template_part('social-buttons', 'header');
                            ?>                                        
                        </div>
                    </div>
                </div>
                <!--END #subscribe-follow-->
            <?php } ?>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!--BEGIN .header-pattern-->
<div class="header-pattern">
    <!--BEGIN .header-border-->
    <div class="header-border-sticky">
        <div class="header-border<?php
            $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
            if (get_header_image()) {
                echo ' custom-header';
            }
            ?>">
            <!--BEGIN .header-->
            <div class="header">

                <!--BEGIN .container-header-->
                <div class="container container-header">
                    
                    <div class="col-md-4 col-sm-4">
                        <!--BEGIN #Woocommerce-->
                        <?php
                        $woocommerce_cart_link_main_nav = evolve_get_option('evl_woocommerce_cart_link_main_nav', '0');
                        if (class_exists('Woocommerce') && $woocommerce_cart_link_main_nav) {
                            global $woocommerce;
                            ?>
                            <div class="woocommerce-menu-holder">
                                <ul class="woocommerce-menu">
                                    <?php $woocommerce_cart_link_main_nav = evolve_get_option('evl_woocommerce_cart_link_main_nav', '0'); ?>
                                    <?php if ($woocommerce_cart_link_main_nav): ?>
                                        <li class="cart">
                                            <?php if (!$woocommerce->cart->cart_contents_count): ?>
                                                <a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                                                    <?php echo woocommerce_price($woocommerce->cart->cart_contents_total); ?>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <div class="cart-contents">
                                                            <div class="cart-content">
                                                                <strong style="padding:7px 10px;line-height:35px;">
                                                                    <?php _e('Your cart is currently empty.', 'evolve'); ?>
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php else: ?>
                                                <a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>">
                                                    <?php echo woocommerce_price($woocommerce->cart->cart_contents_total); ?>
                                                </a>
                                                <div class="cart-contents">
                                                    <?php foreach ($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item);   ?>
                                                        <div class="cart-content">
                                                            <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                                                <?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
                                                                <?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
                                                                <div class="cart-desc">
                                                                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                                                    <span class="product-quantity">
                                                                        <?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <div class="cart-checkout">
                                                        <div class="cart-link">
                                                            <a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'evolve'); ?></a>
                                                        </div>
                                                        <div class="checkout-link">
                                                            <a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'evolve'); ?></a>
                                                        </div>
                                                    </div>
                                                </div><!-- /.cart-contents -->
                                            <?php endif; //if(!$woocommerce->cart->cart_contents_count):     ?>
                                        </li><!-- /li.cart -->
                                    <?php endif; ?>

                                    <?php $woocommerce_acc_link_main_nav = evolve_get_option('evl_woocommerce_acc_link_main_nav', '0'); ?>
                                    <?php if ($woocommerce_acc_link_main_nav): ?>
                                        <li class="my-account">
                                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="my-account-link">

                                                <?php _e('My Account', 'evolve'); ?></a>
                                            <?php if (!is_user_logged_in()): ?>
                                                <div class="login-box">
                                                    <form action="<?php echo wp_login_url(); ?>" name="loginform" method="post">
                                                        <p>
                                                            <input type="text" class="input-text" name="log" id="username" value="" placeholder="<?php echo __('Username', 'evolve'); ?>" />
                                                        </p>
                                                        <p>
                                                            <input type="password" class="input-text" name="pwd" id="pasword" value="" placeholder="<?php echo __('Password', 'evolve'); ?>" />
                                                        </p>
                                                        <p class="forgetmenot">
                                                            <label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Remember Me', 'evolve'); ?></label>
                                                        </p>
                                                        <p class="submit">
                                                            <input type="submit" name="wp-submit" id="wp-submit" class="button small default comment-submit" value="<?php _e('Log In', 'evolve'); ?>">
                                                            <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                                                            <input type="hidden" name="testcookie" value="1">
                                                        </p>
                                                        <div class="clear"></div>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <ul class="sub-menu">
                                                    <li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Logout', 'evolve'); ?></a></li>
                                                </ul>
                                            <?php endif; ?>
                                        </li><!-- /li.my-account -->
                                    <?php endif; ?>                        
                                </ul><!-- /ul.woocommerce-menu -->
                            </div><!-- /span .woocommerce-menu-holder -->
                        <?php } ?>
                        <!--END #Woocommerce-->                        
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <?php
                        $evolve_pos_logo = evolve_get_option('evl_pos_logo', 'left');
                        if ($evolve_pos_logo == "disable") {

                        } else {
                            $evolve_header_logo = evolve_get_option('evl_header_logo', '');
                            if ($evolve_header_logo) {
                                echo "<div class='header-logo-container'><a href=" . home_url() . "><img id='logo-image' class='img-responsive' src=" . $evolve_header_logo . " /></a></div>";
                            }
                        }
                        ?>
                        <!--BEGIN .title-container-->
                        <div class="title-container">
                            <?php
                            $tagline = '<div id="tagline">' . get_bloginfo('description') . '</div>';
                            $evolve_tagline_pos = evolve_get_option('evl_tagline_pos', 'next');
                            $evolve_blog_title = evolve_get_option('evl_blog_title', '0');
                            if ($evolve_blog_title == "0" || !$evolve_blog_title) {
                                ?>
                                <div id="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo('name') ?></a></div>
                                <?php
                            } else {

                            }
                            if ($evolve_tagline_pos !== "disable") {
                                echo $tagline;
                            }
                            ?>                        
                        </div>
                        <!--END .title-container-->
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <!--BEGIN #searchform-->
                        <?php
                        $evolve_searchbox = evolve_get_option('evl_searchbox', '1');
                        if ($evolve_searchbox == "1") {
                            ?>
                            <form action="<?php echo home_url(); ?>" method="get" class="searchform">
                                <div id="search-text-box">
                                    <label class="searchfield" id="search_label_top" for="search-text-top"><input id="search-text-top" type="text" tabindex="1" name="s" class="search" placeholder="<?php _e('Type your search', 'evolve'); ?>" /><span class="srch-btn"></span></label>
                                 
                                </div>
                            </form>
                        <?php }?>
                        <!--END #searchform-->
                    </div>

                </div>
                <!--END .container-header-->
            </div>
            <!--END .header-->
        </div>
    </div>
    <!--END .header-border-->
</div>
<!--END .header-pattern-->
<div class="menu-container">
    <?php
    $evolve_menu_background = evolve_get_option('evl_disable_menu_back', '1');
    $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
    if ($evolve_width_layout == "fluid" && $evolve_menu_background == "1") {
        ?>
        <div class="fluid-width">
        <?php } ?>

        <div class="menu-header">
            <div class="menu-header-sticky">
                <!--BEGIN .container-menu-->
                <div class="container nacked-menu center-menu container-menu custom-center">
                    <?php
                    $evolve_main_menu = evolve_get_option('evl_main_menu', '0');
                    if ($evolve_main_menu == "1") {
                        ?>
                        <br /><br />
                    <?php } else { ?>
                        <div class="primary-menu" >
                            <?php
                            if (has_nav_menu('primary-menu')) {
                                echo '<nav class="nav nav-holder link-effect">';
                                wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'menu_id' => '', 'fallback_cb' => 'link_to_menu_editor', 'walker' => new evolve_Walker_Nav_Menu()));
                            } else {
                                ?>
                                <nav class="nav nav-holder">
                                    <?php
                                    wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'fallback_cb' => 'link_to_menu_editor'));
                                }
                                ?>
                            </nav>
                        </div><!-- /.primary-menu -->
                        <?php
                        $evolve_sticky_header = evolve_get_option('evl_sticky_header', '1');
                        if ($evolve_sticky_header == "1") {
                            // sticky header
                            get_template_part('sticky-header');
                        }
                        ?>
                    <?php } ?>
                </div><!-- /.container -->
            </div><!-- /.menu-header -->
        </div>
        <?php
        $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
        if ($evolve_width_layout == "fluid") {
            ?>
        </div><!-- /.fluid-width -->
    <?php } ?>
</div>    