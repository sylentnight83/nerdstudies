<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

if( ! class_exists( 'Theme4Press_Slider' ) ) {
	class Theme4Press_Slider {

		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			// Add settings
			add_action( 'slide-page_add_form_fields', array( $this, 'slider_add_new_meta_fields' ), 10, 2 );
			add_action( 'slide-page_edit_form_fields', array( $this, 'slider_edit_meta_fields' ), 10, 2 );  
			add_action( 'edited_slide-page', array( $this, 'slider_save_taxonomy_custom_meta' ), 10, 2 );  
			add_action( 'create_slide-page', array( $this, 'slider_save_taxonomy_custom_meta' ), 10, 2 );
		}

		function init() {
			global $smof_data;

			if( ! $smof_data['status_t4p_slider'] ) {
				register_post_type(
					'slide',
					array(
						'public' => true,
						'has_archive' => false,
						'rewrite' => array('slug' => 'slide'),
						'supports' => array('title', 'thumbnail'),
						'can_export' => true,
						'menu_position' => 100,
						'hierarchical' => false,
						'labels' => array(
							'name'                => _x( 'Theme4Press Sliders', 'Post Type General Name', 't4p-core' ),
							'singular_name'       => _x( 'Theme4Press Slider', 'Post Type Singular Name', 't4p-core' ),
							'menu_name'           => __( 'Theme4Press Slider', 't4p-core' ),
							'parent_item_colon'   => __( 'Parent Slide:', 't4p-core' ),
							'all_items'           => __( 'Add or Edit Slides', 't4p-core' ),
							'view_item'           => __( 'View Slides', 't4p-core' ),
							'add_new_item'        => __( 'Add New Slide', 't4p-core' ),
							'add_new'             => __( 'Add New Slide', 't4p-core' ),
							'edit_item'           => __( 'Edit Slide', 't4p-core' ),
							'update_item'         => __( 'Update Slide', 't4p-core' ),
							'search_items'        => __( 'Search Slide', 't4p-core' ),
							'not_found'           => __( 'Not found', 't4p-core' ),
							'not_found_in_trash'  => __( 'Not found in Trash', 't4p-core' ),
						)
					)
				);

				register_taxonomy('slide-page', 'slide',
					array(
						'hierarchical' => true,
						'label' => 'Slider',
						'query_var' => true,
						'rewrite' => true,
						'hierarchical' => true,
						'show_in_nav_menus' => false,
						'show_tagcloud' => false,
						'labels' => array(
							'name'                       => _x( 'Sliders', 'Taxonomy General Name', 't4p-core' ),
							'singular_name'              => _x( 'Slider', 'Taxonomy Singular Name', 't4p-core' ),
							'menu_name'                  => __( 'Add or Edit Sliders', 't4p-core' ),
							'all_items'                  => __( 'All Sliders', 't4p-core' ),
							'parent_item'                => __( 'Parent Slider', 't4p-core' ),
							'parent_item_colon'          => __( 'Parent Slider:', 't4p-core' ),
							'new_item_name'              => __( 'New Slider Name', 't4p-core' ),
							'add_new_item'               => __( 'Add Slider', 't4p-core' ),
							'edit_item'                  => __( 'Edit Slider', 't4p-core' ),
							'update_item'                => __( 'Update Slider', 't4p-core' ),
							'separate_items_with_commas' => __( 'Separate sliders with commas', 't4p-core' ),
							'search_items'               => __( 'Search Sliders', 't4p-core' ),
							'add_or_remove_items'        => __( 'Add or remove sliders', 't4p-core' ),
							'choose_from_most_used'      => __( 'Choose from the most used sliders', 't4p-core' ),
							'not_found'                  => __( 'Not Found', 't4p-core' ),
						),
					)
				);
			}
		}

		/**
		 * Enqueue Scripts and Styles
		 *
		 * @return	void
		 */
		function admin_init() {
			global $pagenow;

			$post_type = '';

			if( isset( $_GET['post'] ) && $_GET['post'] ) {
				$post_type = get_post_type( $_GET['post'] );
			}

			if( ( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'slide-page' ) || ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'slide' ) || $post_type == 'slide' ) {
				wp_enqueue_script( 't4p-slider', plugin_dir_url( __FILE__ ) . 'js/t4p-slider.js', false, '1.0', false );
			}

			if( isset( $_GET['page'] ) && $_GET['page'] == 'fs_export_import' ) {
				$this->export_sliders();
			}
		}

		function admin_menu() {
		    global $submenu;
		    unset( $submenu['edit.php?post_type=slide'][10] );

		    add_submenu_page( 'edit.php?post_type=slide', __( 'Export / Import', 't4p-core' ), __( 'Export / Import', 't4p-core' ), 'manage_options', 'fs_export_import', array( $this, 'fs_export_import_settings' ) );
		}

		// Add term page
		function slider_add_new_meta_fields() {
			// this will add the custom meta field to the add new term page
			?>
			<div class="form-field">
				<label for="term_meta[slider_width]"><?php _e( 'Slider Width', 't4p-core' ); ?></label>
				<input type="text" name="term_meta[slider_width]" id="term_meta[slider_width]" value="100%">
				<p class="description"><?php _e( 'In pixels or percentage, ex: 100% for full width, 940px for fixed width.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field">
				<label for="term_meta[slider_height]"><?php _e( 'Slider Height', 't4p-core' ); ?></label>
				<input type="text" name="term_meta[slider_height]" id="term_meta[slider_height]" value="400px">
				<p class="description"><?php _e( 'In pixels, ex: 500px.', 't4p-core' ); ?></p>
			</div>
			<?php $theme = wp_get_theme(); // gets the current theme
				if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) { 
				} else {
				?>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[full_screen]"><?php _e( 'Full Screen Slider', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[full_screen]" id="term_meta[full_screen]" value="0">
				<input type="checkbox" name="term_meta[full_screen]" id="term_meta[full_screen]" value="1">
				<p class="description"><?php _e( 'Check this option if you want full width and height of the screen.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[parallax]"><?php _e( 'Parallax Scrolling Effect', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[parallax]" id="term_meta[parallax]" value="0">
				<input type="checkbox" name="term_meta[parallax]" id="term_meta[parallax]" value="1">
				<p class="description"><?php _e( 'Check this box to have a parallax scrolling effect, this ONLY works when assigning the slider in page options. It does not work when using a slider shortcode. With this option enabled, the slider height you input will not be exact due to n"egative margin which is based off the overall header size. ex: 500px will show as 415px. Please adjust accordingly.', 't4p-core' ); ?></p>
			</div>
				<?php } ?>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[nav_arrows]"><?php _e( 'Display Navigation Arrows', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[nav_arrows]" id="term_meta[nav_arrows]" value="0">
				<input type="checkbox" name="term_meta[nav_arrows]" id="term_meta[nav_arrows]" value="1" checked="checked">
				<p class="description"><?php _e( 'Check this box to display the navigation arrows.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[pagination_circles]"><?php _e( 'Display Pagination Circles', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[pagination_circles]" id="term_meta[pagination_circles]" value="0">
				<input type="checkbox" name="term_meta[pagination_circles]" id="term_meta[pagination_circles]" value="1">
				<p class="description"><?php _e( 'Check this box to display the pagination circles.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[autoplay]"><?php _e( 'Autoplay', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[autoplay]" id="term_meta[autoplay]" value="0">
				<input type="checkbox" name="term_meta[autoplay]" id="term_meta[autoplay]" value="1" checked="checked">
				<p class="description"><?php _e( 'Check this box to autoplay the slides.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field form-field-checkbox">
				<label for="term_meta[loop]"><?php _e( 'Slide Loop', 't4p-core' ); ?></label>
				<input type="hidden" name="term_meta[loop]" id="term_meta[loop]" value="0">
				<input type="checkbox" name="term_meta[loop]" id="term_meta[loop]" value="1">
				<p class="description"><?php _e( 'Check this box to have the slider loop infinitely.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field">
				<label for="term_meta[animation]"><?php _e( 'Animation', 't4p-core' ); ?></label>
				<select name="term_meta[animation]" id="term_meta[animation]">
					<option value="fade">Fade</option>
					<option value="slide">Slide</option>
				</select>
				<p class="description"><?php _e( 'The type of animation when slides rotate.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field">
				<label for="term_meta[slideshow_speed]"><?php _e( 'Slideshow Speed', 't4p-core' ); ?></label>
				<input type="text" name="term_meta[slideshow_speed]" id="term_meta[slideshow_speed]" value="7000">
				<p class="description"><?php _e( 'Controls the speed of the slideshow. 1000 = 1 second.', 't4p-core' ); ?></p>
			</div>
			<div class="form-field">
				<label for="term_meta[animation_speed]"><?php _e( 'Animation Speed', 't4p-core' ); ?></label>
				<input type="text" name="term_meta[animation_speed]" id="term_meta[animation_speed]" value="600">
				<p class="description"><?php _e( 'Controls the speed of the slide transition from slide to slide. 1000 = 1 second.', 't4p-core' ); ?></p>
			</div>
		<?php
		}

		// Edit term page
		function slider_edit_meta_fields( $term ) {
			// put the term ID into a variable
			$t_id = $term->term_id;
		 
			// retrieve the existing value(s) for this meta field. This returns an array
			$term_meta = get_option( "taxonomy_$t_id" ); ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[slider_width]"><?php _e( 'Slider Width', 't4p-core' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[slider_width]" id="term_meta[slider_width]" value="<?php echo esc_attr( $term_meta['slider_width'] ) ? esc_attr( $term_meta['slider_width'] ) : ''; ?>">
					<p class="description"><?php _e( 'In pixels or percentage, ex: 100% for full width, 940px for fixed width.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[slider_height]"><?php _e( 'Slider Height', 't4p-core' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[slider_height]" id="term_meta[slider_height]" value="<?php echo esc_attr( $term_meta['slider_height'] ) ? esc_attr( $term_meta['slider_height'] ) : ''; ?>">
					<p class="description"><?php _e( 'In pixels, ex: 500px.', 't4p-core' ); ?></p>
				</td>
			</tr>
			
			<?php $theme = wp_get_theme(); // gets the current theme
				if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) { 
				} else {
				?>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[full_screen]"><?php _e( 'Full Screen Slider', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[full_screen]" id="term_meta[full_screen]" value="0">
					<input type="checkbox" name="term_meta[full_screen]" id="term_meta[full_screen]" value="1" <?php echo esc_attr( $term_meta['full_screen'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this option if you want full width and height of the screen.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[parallax]"><?php _e( 'Parallax Scrolling Effect', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[parallax]" id="term_meta[parallax]" value="0">
					<input type="checkbox" name="term_meta[parallax]" id="term_meta[parallax]" value="1" <?php echo esc_attr( $term_meta['parallax'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this box to have a parallax scrolling effect, this ONLY works when assigning the slider in page options. It does not work when using a slider shortcode. With this option enabled, the slider height you input will not be exact due to n"egative margin which is based off the overall header size. ex: 500px will show as 415px. Please adjust accordingly.', 't4p-core' ); ?></p>
				</td>
			</tr>
				<?php } ?>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[nav_arrows]"><?php _e( 'Display Navigation Arrows', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[nav_arrows]" id="term_meta[nav_arrows]" value="0">
					<input type="checkbox" name="term_meta[nav_arrows]" id="term_meta[nav_arrows]" value="1" <?php echo esc_attr( $term_meta['nav_arrows'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this box to display the navigation arrows.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[pagination_circles]"><?php _e( 'Display Pagination Circles', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[pagination_circles]" id="term_meta[pagination_circles]" value="0">
					<input type="checkbox" name="term_meta[pagination_circles]" id="term_meta[pagination_circles]" value="1" <?php echo esc_attr( $term_meta['pagination_circles'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this box to display the pagination circles.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[autoplay]"><?php _e( 'Autoplay', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[autoplay]" id="term_meta[autoplay]" value="0">
					<input type="checkbox" name="term_meta[autoplay]" id="term_meta[autoplay]" value="1" <?php echo esc_attr( $term_meta['autoplay'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this box to autoplay the slides.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field form-field-checkbox">
				<th scope="row" valign="top"><label for="term_meta[loop]"><?php _e( 'Slide Loop', 't4p-core' ); ?></label></th>
				<td>
					<input type="hidden" name="term_meta[loop]" id="term_meta[loop]" value="0">
					<input type="checkbox" name="term_meta[loop]" id="term_meta[loop]" value="1" <?php echo esc_attr( $term_meta['loop'] ) ? 'checked="checked"' : ''; ?>>
					<p class="description"><?php _e( 'Check this box to have the slider loop infinitely.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[animation]"><?php _e( 'Animation', 't4p-core' ); ?></label></th>
				<td>
					<select name="term_meta[animation]" id="term_meta[animation]">
					<option value="fade" <?php echo ( esc_attr( $term_meta['animation'] ) == 'fade' ) ? 'selected="selected"' : ''; ?>>Fade</option>
					<option value="slide" <?php echo ( esc_attr( $term_meta['animation'] ) == 'slide' ) ? 'selected="selected"' : ''; ?>>Slide</option>
					</select>
					<p class="description"><?php _e( 'The type of animation when slides rotate.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[slideshow_speed]"><?php _e( 'Slideshow Speed', 't4p-core' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[slideshow_speed]" id="term_meta[slideshow_speed]" value="<?php echo esc_attr( $term_meta['slideshow_speed'] ) ? esc_attr( $term_meta['slideshow_speed'] ) : ''; ?>">
					<p class="description"><?php _e( 'Controls the speed of the slideshow. 1000 = 1 second.', 't4p-core' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[animation_speed]"><?php _e( 'Animation Speed', 't4p-core' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[animation_speed]" id="term_meta[animation_speed]" value="<?php echo esc_attr( $term_meta['animation_speed'] ) ? esc_attr( $term_meta['animation_speed'] ) : ''; ?>">
					<p class="description"><?php _e( 'Controls the speed of the slide transition from slide to slide. 1000 = 1 second.', 't4p-core' ); ?></p>
				</td>
			</tr>
		<?php
		}

		// Save extra taxonomy fields callback function.
		function slider_save_taxonomy_custom_meta( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "taxonomy_$t_id" );
				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				// Save the option array.
				update_option( "taxonomy_$t_id", $term_meta );
			}
		}

		// Export / Import Settings Page
		function fs_export_import_settings() {
			if( $_FILES ) {
				$this->import_sliders( $_FILES['import']['tmp_name'] );
			}
		?>
		<div class="wrap">
			<h2><?php _e( 'Export and Import Theme4Press Sliders', 't4p-core' ); ?></h2>
			<form enctype="multipart/form-data" method="post" action="">
			    <table class="form-table">
			        <tr valign="top">
				        <th scope="row"><?php _e( 'Export', 't4p-core' ); ?></th>
				        <td><input type="submit" class="button button-primary" name="export_button" value="<?php _e( 'Export All Sliders', 't4p-core' ); ?>" /></td>
			        </tr>
					<tr valign="top">
						<th>
							<label for="upload"><?php _e( 'Choose a file from your computer:', 't4p-core'); ?></label>
						</th>
						<td>
							<input type="file" id="upload" name="import" size="25" />
							<input type="hidden" name="action" value="save" />
							<input type="hidden" name="max_file_size" value="33554432" />
							<p class="submit"><input type="submit" name="upload" id="submit" class="button" value="Upload file and import"  /></p>
						</td>
					</tr>
			    </table>
			</form>
		</div>
		<?php
		}

		function export_sliders() {
			if( isset($_POST['export_button']) && $_POST['export_button'] ) {
				// Load Importer API
				require_once ABSPATH . 'wp-admin/includes/export.php';

				ob_start();
				export_wp( array(
					'content' => 'slide',
				) );
				$export = ob_get_contents();
				ob_get_clean();

				$terms = get_terms( 'slide-page', array(
					'hide_empty' => 1
				) );

				foreach( $terms as $term ) {
					$term_meta = get_option( 'taxonomy_' . $term->term_id );
					$export_terms[$term->slug] = $term_meta;
				}

				$json_export_terms = json_encode($export_terms);

				$upload_dir = wp_upload_dir();
				$base_dir = trailingslashit( $upload_dir['basedir'] );
				$fs_dir = $base_dir . 't4p_slider/';

				$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1, 'meta_key' => '_thumbnail_id' ) );

				while( $loop->have_posts() ) { $loop->the_post();
					$post_image_id = get_post_thumbnail_id( get_the_ID() );
					$image_path = get_attached_file($post_image_id);
					if( isset( $image_path ) && $image_path ) {
						$ext = pathinfo( $image_path, PATHINFO_EXTENSION );
						@copy( $image_path, $fs_dir . $post_image_id . '.' . $ext );
					}
				}

				wp_reset_query();

				$url = wp_nonce_url( 'edit.php?post_type=slide&page=fs_export_import' );
				if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
					return; // stop processing here
				}

				wp_mkdir_p( $fs_dir  );

				if( WP_Filesystem( $creds ) ) {
					global $wp_filesystem;

					if ( ! $wp_filesystem->put_contents( $fs_dir . 'sliders.xml', $export, FS_CHMOD_FILE ) || ! $wp_filesystem->put_contents( $fs_dir . 'settings.json', $json_export_terms, FS_CHMOD_FILE ) ) {
					    echo 'Couldn\'t export sliders, make sure wp-content/uploads is writeable.';
					} else {
						// Initialize archive object
						$zip = new ZipArchive;
						$zip->open( 't4p_slider.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE );

						foreach( new DirectoryIterator( $fs_dir ) as $file ) {
						    if( $file->isDot() ) {
						    	continue;
						    }

							$zip->addFile( $fs_dir . $file->getFilename(), $file->getFilename() );
						}

						$zip_file = $zip->filename;

						// Zip archive will be created only after closing object
						$zip->close();

						header( 'Content-type: application/zip' );
						header( 'Content-Disposition: attachment; filename="t4p_slider.zip"' );
						header( 'Content-length: ' . filesize( $zip_file ) );
						header( 'Pragma: no-cache' );
						header( 'Expires: 0' );
						readfile( $zip_file );

						foreach( new DirectoryIterator( $fs_dir ) as $file ) {
						    if( $file->isDot() ) {
						    	continue;
						    }

						    @unlink ( $fs_dir . $file->getFilename() );
						}
					}
				}
			}
		}

		function import_sliders( $zip_file ) {
			$upload_dir = wp_upload_dir();
			$base_dir = trailingslashit( $upload_dir['basedir'] );
			$fs_dir = $base_dir . 't4p_slider_exports/';

			@unlink ( $fs_dir . 'sliders.xml' );
			@unlink ( $fs_dir . 'settings.json' );

			$zip = new ZipArchive();
			$zip->open( $zip_file );
			$zip->extractTo( $fs_dir );
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
				$xml = $fs_dir . 'sliders.xml';
				$importer->fetch_attachments = true;
				ob_start();
				$importer->import($xml);
				ob_end_clean();

				$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1, 'meta_key' => '_thumbnail_id' ) );

				while( $loop->have_posts() ) { $loop->the_post();
					$thumbnail_ids[get_post_meta( get_the_ID(), '_thumbnail_id', true )] = get_the_ID();
				}

				foreach( new DirectoryIterator( $fs_dir ) as $file ) {
				    if( $file->isDot() || $file->getFilename() == '.DS_Store' ) {
				    	continue;
				    }

				    $image_path = pathinfo( $fs_dir . $file->getFilename() );
				    if( $image_path['extension'] != 'xml' && $image_path['extension'] != 'json' ) {
				    	$filename = $image_path['filename'];
				    	$new_image_path = $upload_dir['path'] . '/' . $image_path['basename'];
				    	$new_image_url = $upload_dir['url'] . '/' . $image_path['basename'];
				    	@copy( $fs_dir . $file->getFilename(), $new_image_path );

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

				$url = wp_nonce_url( 'edit.php?post_type=slide&page=fs_export_import' );
				if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
					return; // stop processing here
				}

				if( WP_Filesystem( $creds ) ) {
					global $wp_filesystem;

					$settings = $wp_filesystem->get_contents( $fs_dir . 'settings.json' );
					
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
	}

	$t4p_slider = new Theme4Press_Slider();
}