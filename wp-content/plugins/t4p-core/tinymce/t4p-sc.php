<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new t4p_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="t4p-popup">

	<div id="t4p-shortcode-wrap">

		<div id="t4p-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => 'Choose a Shortcode',
					'alert' => 'Alert',
					'blog' => 'Blog',
					'button' => 'Button',
					'checklist' => 'Checklist',
					'clientslider' => 'Client Slider',
					'columns' => 'Columns',
					'contentboxes' => 'Content Boxes',
					'countersbox' => 'Counters Box',
					'counterscircle' => 'Counters Circle',          
					'dropcap' => 'Dropcap',
					'flipboxes' => 'Flip Boxes',          
					'fontawesome' => 'FontAwesome',
					'fullwidth' => 'Full Width Container',
					'googlemap' => 'Google Map',
					'highlight' => 'Highlight',
					'imagecarousel' => 'Image Carousel',
					'imageframe' => 'Image Frame',          
					'lightbox' => 'Lightbox',
					'menuanchor' => 'Menu Anchor',  
					'modal' => 'Modal',
					'modaltextlink' => 'Modal Text Link',                  
					'person' => 'Person',
					'popover' => 'Popover',
					'postslider' => 'Post Slider',          
					'pricingtable' => 'Pricing Table',
					'progressbar' => 'Progress Bar',
					'recentposts' => 'Recent Posts',
					'recentworks' => 'Recent Works',
					'sectionseparator' => 'Section Separator',          
					'separator' => 'Separator',
					'sharingbox' => 'Sharing Box',
					'slider' => 'Slider',
					'sociallinks' => 'Social Links',
					'soundcloud' => 'SoundCloud',          
					'table' => 'Table',
					'tabs' => 'Tabs',          
					'taglinebox' => 'Tagline Box',
					'testimonials' => 'Testimonials',
					't4pslider' => 'Theme4Press Slider',          
					'title' => 'Title',
					'toggles' => 'Toggles',
					'tooltip' => 'Tooltip',
					'vimeo' => 'Vimeo',
					'woofeatured' => 'Woocommerce Featured Products Slider',
					'wooproducts' => 'Woocommerce Products Slider',
					'youtube' => 'Youtube'
			);
			?>
			<table id="t4p-sc-form-table" class="t4p-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label"><?php _e( 'Choose Shortcode', 't4p-core' ); ?></td>
						<td class="field">
							<div class="t4p-form-select-field">
							<div class="t4p-shortcodes-arrow">&#xf107;</div>
								<select name="t4p_select_shortcode" id="t4p_select_shortcode" class="t4p-form-select t4p-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="t4p-sc-form">

				<table id="t4p-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="t4p-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="t4p-insert"><?php _e( 'Insert Shortcode', 't4p-core' ); ?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#t4p-sc-form-table -->

			</form>
			<!-- /#t4p-sc-form -->

		</div>
		<!-- /#t4p-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#t4p-shortcode-wrap -->

</div>
<!-- /#t4p-popup -->

</body>
</html>