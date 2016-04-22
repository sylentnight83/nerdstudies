<?php
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );

// Don't resize images
function evolve_filter_image_sizes( $sizes ) {
	return array();
}

// Hook importer into admin init
add_action( 'admin_init', 't4p_importer' );
function t4p_importer() {
	global $wpdb;

    if ( current_user_can( 'manage_options' ) && isset( $_GET['import_data_content'] ) ) {
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers

		if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
			$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			include $wp_importer;
		}

		if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
			$wp_import = get_template_directory() . '/library/plugins/importer/wordpress-importer.php';
			include $wp_import;
		}

		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class  
		
		$theme_xml = get_template_directory() . '/library/plugins/importer/data/evolve.xml.gz';		
		$theme_woo_xml = get_template_directory() . '/library/plugins/importer/data/evolve_woo.xml.gz';
                           
		add_filter('intermediate_image_sizes_advanced', 'evolve_filter_image_sizes');	   

			/* Import Woocommerce if WooCommerce Exists */
			if( class_exists('Woocommerce') ) {
				$importer = new WP_Import();
				$importer->fetch_attachments = true;
				ob_start();
				$importer->import($theme_woo_xml);
				ob_end_clean();  
				
			/* Images */
			//$importer = new WP_Import();
			//$importer->fetch_attachments = true;
			//ob_start();
			//$importer->import($theme_attachments);
			//ob_end_clean();	

				// Set pages
				$woopages = array(
					'woocommerce_shop_page_id' => 'Shop',
					'woocommerce_cart_page_id' => 'Cart',
					'woocommerce_checkout_page_id' => 'Checkout',
					'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
					'woocommerce_thanks_page_id' => 'Order Received',
					'woocommerce_myaccount_page_id' => 'My Account',
					'woocommerce_edit_address_page_id' => 'Edit My Address',
					'woocommerce_view_order_page_id' => 'View Order',
					'woocommerce_change_password_page_id' => 'Change Password',
					'woocommerce_logout_page_id' => 'Logout',
					'woocommerce_lost_password_page_id' => 'Lost Password'
				);
				foreach($woopages as $woo_page_name => $woo_page_title) {
					$woopage = get_page_by_title( $woo_page_title );
					if(isset( $woopage ) && $woopage->ID) {
						update_option($woo_page_name, $woopage->ID); // Front Page
					}
				}

				// We no longer need to install pages
				delete_option( '_wc_needs_pages' );
				delete_transient( '_wc_activation_redirect' );

				// Flush rules after install
				flush_rewrite_rules();
				
			} else {
				
				$importer = new WP_Import();
				/* First Import Posts, Pages, Portfolio Content, FAQ, Menus */
				$importer->fetch_attachments = true;
				ob_start();
				$importer->import($theme_xml);
				ob_end_clean();  
				
			/* Images */
			//$importer = new WP_Import();
			//$importer->fetch_attachments = true;
			//ob_start();
			//$importer->import($theme_attachments);
			//ob_end_clean();					

			}			
      
			// Set imported menus to registered theme locations
			$locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
			$menus = wp_get_nav_menus(); // registered menus

			if($menus) {
				foreach($menus as $menu) { // assign menus to theme locations
					//if( $menu->name == 'Main Menu' ) {
					//	$locations['main_navigation'] = $menu->term_id;
					//} else if( $menu->name == 'Top Menu' ) {
					//	$locations['top_navigation'] = $menu->term_id;
					//}
					
					//modified use Menu
					if( $menu->name == 'Menu' ) {
						$locations['primary-menu'] = $menu->term_id;
					}
					 
				}
			}   
			set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations   
			// then update the menu_check option to make sure this code only runs once 						
				
			// Import Theme Options
			$theme_options_txt = get_template_directory_uri() . '/library/plugins/importer/data/theme_options.json'; // theme options data file
			$theme_options_txt = wp_remote_get( $theme_options_txt );
			$datafile = json_decode( ( $theme_options_txt['body']) , true);
            update_option( 'evolve', $datafile );			

			// Add sidebar widget areas
			$sidebars = array(
	  		'Shop' => 'Shop',
	  		//'Magazine' => 'Magazine'
	  	);			
	  	update_option( 'sbg_sidebars', $sidebars );
	
	  	foreach( $sidebars as $sidebar ) {
	  		$sidebar_class = evolve_name_to_class( $sidebar );
	  		register_sidebar(array(
          'name'=>$sidebar,
	  			'id' => 'evolve-custom-sidebar-'.strtolower($sidebar_class),
	  			'before_widget' => '<div id="%1$s" class="widget %2$s">',
	  			'after_widget' => '</div>',
	  			'before_title' => '<div class="heading"><h3>',
	  			'after_title' => '</h3><div class="title-sep-container"><div class="title-sep"></div></div></div><div class="clearfix"></div>',          
	  		));
	  	}

			// Add data to widgets
			$widgets_json = get_template_directory_uri() . '/library/plugins/importer/data/widget_data.json'; // widgets data file
			$widgets_json = wp_remote_get( $widgets_json );
			$widget_data = $widgets_json['body'];
			$import_widgets = t4p_import_widget_data( $widget_data );

            // Set reading options
            $homepage = get_page_by_title( 'Theme4Press Slider' );
			if(isset( $homepage ) && $homepage->ID) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $homepage->ID); // Front Page
            }
			
            // Theme4Press Sliders Import
            $t4p_url = get_template_directory() . '/library/plugins/importer/data/t4p_slider.zip';
            @evolve_import_t4psliders( $t4p_url ); 			

            //finally redirect to success page
            wp_redirect( admin_url( 'themes.php?page=evl_options_options&imported=success#of-option-generaloptions' ) );
        }
    }
}

// Parsing Widgets Function
// Thanks to http://wordpress.org/plugins/widget-settings-importexport/
function t4p_import_widget_data( $widget_data ) {
	$json_data = $widget_data;
	$json_data = json_decode( $json_data, true );

	$sidebar_data = $json_data[0];
	$widget_data = $json_data[1];

	foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
		$widgets[ $widget_data_title ] = '';
		foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
			if( is_int( $widget_data_key ) ) {
				$widgets[$widget_data_title][$widget_data_key] = 'on';
			}
		}
	}
	unset($widgets[""]);

	foreach ( $sidebar_data as $title => $sidebar ) {
		$count = count( $sidebar );
		for ( $i = 0; $i < $count; $i++ ) {
			$widget = array( );
			$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
			$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
			if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
				unset( $sidebar_data[$title][$i] );
			}
		}
		$sidebar_data[$title] = array_values( $sidebar_data[$title] );
	}

	foreach ( $widgets as $widget_title => $widget_value ) {
		foreach ( $widget_value as $widget_key => $widget_value ) {
			$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
		}
	}

	$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

	t4p_parse_import_data( $sidebar_data );
}

function t4p_parse_import_data( $import_array ) {
	global $wp_registered_sidebars;
	$sidebars_data = $import_array[0];
	$widget_data = $import_array[1];
	$current_sidebars = get_option( 'sidebars_widgets' );
	$new_widgets = array( );

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name = t4p_get_new_widget_name( $title, $index );
				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
						$new_index++;
					}
				}
				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
					$multiwidget = $new_widgets[$title]['_multiwidget'];
					unset( $new_widgets[$title]['_multiwidget'] );
					$new_widgets[$title]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[$new_index] = $widget_data[$title][$index];
					$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : false;					
					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[$title] = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;

	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content )
			update_option( 'widget_' . $title, $content );

		return true;
	}

	return false;
}

function t4p_get_new_widget_name( $widget_name, $widget_index ) {
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array( );
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;
	return $new_widget_name;
}

// Rename sidebar
function evolve_name_to_class($name){
	$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
	return $class;
}

/**
 * Import Theme4Press Sliders
 */
function evolve_import_t4psliders( $zip_file ) {
    $upload_dir = wp_upload_dir();
    $base_dir = trailingslashit( $upload_dir['basedir'] );
    $t4p_dir = $base_dir . 'evolve_slider_exports/';

    @unlink ( $t4p_dir . 'sliders.xml' );
    @unlink ( $t4p_dir . 'settings.json' );

    $zip = new ZipArchive();
    $zip->open( $zip_file );
    $zip->extractTo( $t4p_dir );
    $zip->close();

    if ( !defined('WP_LOAD_IMPORTERS') ) {
        define('WP_LOAD_IMPORTERS', true);
    }

    if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
        $wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        include $wp_importer;
    }

    if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
        $wp_import = plugin_dir_path( __FILE__ ) . 'libs/wordpress-importer.php';
        include $wp_import;
    }

    if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
        $importer = new WP_Import();
        $xml = $t4p_dir . 'sliders.xml';
        $importer->fetch_attachments = true;
        ob_start();
        $importer->import($xml);
        ob_end_clean();

        $loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1, 'meta_key' => '_thumbnail_id' ) );

        while( $loop->have_posts() ) { $loop->the_post();
            $thumbnail_ids[get_post_meta( get_the_ID(), '_thumbnail_id', true )] = get_the_ID();
        }

        foreach( new DirectoryIterator( $t4p_dir ) as $file ) {
            if( $file->isDot() || $file->getFilename() == '.DS_Store' ) {
                continue;
            }

            $image_path = pathinfo( $t4p_dir . $file->getFilename() );
            if( $image_path['extension'] != 'xml' && $image_path['extension'] != 'json' ) {
                $filename = $image_path['filename'];
                $new_image_path = $upload_dir['path'] . '/' . $image_path['basename'];
                $new_image_url = $upload_dir['url'] . '/' . $image_path['basename'];
                @copy( $t4p_dir . $file->getFilename(), $new_image_path );

                // Check the type of tile. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype( basename( $new_image_path ), null );

                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $new_image_url, 
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $new_image_path ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $new_image_path, $thumbnail_ids[$filename] );

                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $new_image_path );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                set_post_thumbnail( $thumbnail_ids[$filename], $attach_id );
            }
        }

        $url = wp_nonce_url( 'edit.php?post_type=slide&page=t4p_export_import' );
        if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
            return; // stop processing here
        }

        if( WP_Filesystem( $creds ) ) {
            global $wp_filesystem;

            $settings = $wp_filesystem->get_contents( $t4p_dir . 'settings.json' );
            
            $decode = json_decode( $settings, TRUE );

            foreach( $decode as $slug => $settings ) {
                $get_term = get_term_by( 'slug', $slug, 'slide-page' );

                if( $get_term ) {
                    update_option( 'taxonomy_' . $get_term->term_id, $settings );
                }
            }
        }
    }
}