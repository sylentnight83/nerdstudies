<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function t4p_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if( $all ) {
		$number_of_posts['-1'] = 'All';
	}

	if( $default ) {
		$number_of_posts[''] = 'Default';
	}

	foreach( range( $range_start, $range ) as $number ) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function t4p_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if( $empty_choice == true ) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				$post_categories[$cat->slug] = $cat->name;
			}
		}

		if( isset( $post_categories ) ) {
			return $post_categories;
		}
	}
}

$choices = array( 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices = array( 'no' => 'No', 'yes' => 'Yes' );
$choices_with_default = array( '' => 'Default', 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices_with_default = array( '' => 'Default', 'no' => 'No', 'yes' => 'Yes' );
$leftright = array( 'left' => 'Left', 'right' => 'Right' );
$dec_numbers = array( '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1' );

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = T4P_TINYMCE_DIR . '/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents( $fontawesome_path );
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Alert Type', 't4p-core' ),
			'desc' => __( 'Select the type of alert message. Choose custom for advanced color options below.', 't4p-core' ),
			'options' => array(
				'general' => 'General',
				'error' => 'Error',
				'success' => 'Success',
				'notice' => 'Notice',
				'custom' => 'Custom',
			)
		),
		'accentcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Accent Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the border, text and icon color for custom alert boxes.', 't4p-core')
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the background color for custom alert boxes.', 't4p-core')
		),
		'bordersize' => array(
			'std' => '1px',
			'type' => 'text',
			'label' => __( 'Border Width', 't4p-core' ),
			'desc' => 'Custom setting only. For custom alert boxes. In pixels (px), ex: 1px.'
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Custom Icon', 't4p-core' ),
			'desc' => __( 'Custom setting only. Click an icon to select, click again to deselect', 't4p-core' ),
			'options' => $icons
		),
		'boxshadow' => array(
			'type' => 'select',
			'label' => __( 'Box Shadow', 't4p-core' ),
			'desc' =>  __( 'Display a box shadow below the alert box.', 't4p-core' ),
			'options' => $choices
		),		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 't4p-core' ),
			'desc' => __( 'Insert the alert\'s content', 't4p-core' ),
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),
	'shortcode' => '[alert type="{{type}}" accent_color="{{accentcolor}}" background_color="{{backgroundcolor}}" border_size="{{bordersize}}" icon="{{icon}}" box_shadow="{{boxshadow}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"]{{content}}[/alert]',
	'popup_title' => __( 'Alert Shortcode', 't4p-core' )
);


/*-----------------------------------------------------------------------------------*/
/*	Blog Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Blog Layout', 't4p-core' ),
			'desc' => __( 'Select the layout for the blog shortcode', 't4p-core' ),
			'options' => array(
				'large' => 'Large',
				'medium' => 'Medium',
				'large alternate' => 'Large Alternate',
				'medium alternate' => 'Medium Alternate',
				'grid' => 'Grid',
				'timeline' => 'Timeline'
			)
		),
		'posts_per_page' => array(
			'type' => 'select',
			'label' => __( 'Posts Per Page', 't4p-core' ),
			'desc' => __( 'Select number of posts per page', 't4p-core' ),
			'options' => t4p_shortcodes_range( 25, true, true )
		),
		'cat_slug' => array(
			'type' => 'multiple_select',
			'label' => __( 'Categories', 't4p-core' ),
			'desc' => __( 'Select a category or leave blank for all', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category' )
		),
		'exclude_cats' => array(
			'type' => 'multiple_select',
			'label' => __( 'Exclude Categories', 't4p-core' ),
			'desc' => __( 'Select a category to exclude', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category' )
		),
		'title' => array(
			'type' => 'select',
			'label' => __( 'Show Title', 't4p-core' ),
			'desc' =>  __( 'Display the post title below the featured image', 't4p-core' ),
			'options' => $choices
		),
		'title_link' => array(
			'type' => 'select',
			'label' => __( 'Link Title To Post', 't4p-core' ),
			'desc' =>  __( 'Choose if the title should be a link to the single post page.', 't4p-core' ),
			'options' => $choices
		),		
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Show Thumbnail', 't4p-core' ),
			'desc' =>  __( 'Display the post featured image', 't4p-core' ),
			'options' => $choices
		),
		'excerpt' => array(
			'type' => 'select',
			'label' => __( 'Show Excerpt', 't4p-core' ),
			'desc' =>  __( 'Show excerpt or choose "no" for full content', 't4p-core' ),
			'options' => $choices
		),
		'excerpt_length' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Number of words/characters in Excerpt', 't4p-core' ),
			'desc' =>  __( 'Controls the excerpt length based on words or characters that is set in Theme Options > Extra.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 60, false )
		),
		'meta_all' => array(
			'type' => 'select',
			'label' => __( 'Show Meta Info', 't4p-core' ),
			'desc' =>  __( 'Choose to show all meta data', 't4p-core' ),
			'options' => $choices
		),
		'meta_author' => array(
			'type' => 'select',
			'label' => __( 'Show Author Name', 't4p-core' ),
			'desc' =>  __( 'Choose to show the author', 't4p-core' ),
			'options' => $choices
		),
		'meta_categories' => array(
			'type' => 'select',
			'label' => __( 'Show Categories', 't4p-core' ),
			'desc' =>  __( 'Choose to show the categories', 't4p-core' ),
			'options' => $choices
		),
		'meta_comments' => array(
			'type' => 'select',
			'label' => __( 'Show Comment Count', 't4p-core' ),
			'desc' =>  __( 'Choose to show the comments', 't4p-core' ),
			'options' => $choices
		),
		'meta_date' => array(
			'type' => 'select',
			'label' => __( 'Show Date', 't4p-core' ),
			'desc' =>  __( 'Choose to show the date', 't4p-core' ),
			'options' => $choices
		),
		'meta_link' => array(
			'type' => 'select',
			'label' => __( 'Show Read More Link', 't4p-core' ),
			'desc' =>  __( 'Choose to show the link', 't4p-core' ),
			'options' => $choices
		),
		'meta_tags' => array(
			'type' => 'select',
			'label' => __( 'Show Tags', 't4p-core' ),
			'desc' =>  __( 'Choose to show the tags', 't4p-core' ),
			'options' => $choices
		),
		'paging' => array(
			'type' => 'select',
			'label' => __( 'Show Pagination', 't4p-core' ),
			'desc' =>  __( 'Show numerical pagination boxes', 't4p-core' ),
			'options' => $choices
		),
		'scrolling' => array(
			'type' => 'select',
			'label' => __( 'Infinite Scrolling', 't4p-core' ),
			'desc' =>  __( 'Choose the type of scrolling', 't4p-core' ),
			'options' => array(
				'pagination' => 'Pagination',
				'infinite' => 'Infinite Scrolling'
			)
		),
		'blog_grid_columns' => array(
			'type' => 'select',
			'label' => __( 'Grid Layout # of Columns', 't4p-core' ),
			'desc' => __( 'Select whether to display the grid layout in 2, 3 or 4 column.', 't4p-core' ),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
			)
		),
		'strip_html' => array(
			'type' => 'select',
			'label' => __( 'Strip HTML from Posts Content', 't4p-core' ),
			'desc' =>  __( 'Strip HTML from the post excerpt', 't4p-core' ),
			'options' => $choices
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),
	'shortcode' => '[blog number_posts="{{posts_per_page}}" cat_slug="{{cat_slug}}" exclude_cats="{{exclude_cats}}" show_title="{{title}}" title_link="{{title_link}}" thumbnail="{{thumbnail}}" excerpt="{{excerpt}}" excerpt_length="{{excerpt_length}}" meta_all="{{meta_all}}" meta_author="{{meta_author}}" meta_categories="{{meta_categories}}" meta_comments="{{meta_comments}}" meta_date="{{meta_date}}" meta_link="{{meta_link}}" meta_tags="{{meta_tags}}" paging="{{paging}}" scrolling="{{scrolling}}" strip_html="{{strip_html}}" blog_grid_columns="{{blog_grid_columns}}" layout="{{layout}}" class="{{class}}" id="{{id}}"][/blog]',
	'popup_title' => __( 'Blog Shortcode', 't4p-core')
);

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(

		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button URL', 't4p-core' ),
			'desc' => __( 'Add the button\'s url ex: http://example.com.', 't4p-core' )
		),
		'style' => array(
			'type' => 'select',
			'label' => __( 'Button Style', 't4p-core' ),
			'desc' => __( 'Select the button\'s color. Select default or color name for theme options, or select custom to use advanced color options below.', 't4p-core' ),
			'options' => array(
				'default' => 'Default',
				'custom' => 'Custom',
				'green' => 'Green',
				'darkgreen' => 'Dark Green',
				'orange' => 'Orange',
				'blue' => 'Blue',
				'red' => 'Red',
				'pink' => 'Pink',
				'darkgray' => 'Dark Gray',
				'lightgray' => 'Light Gray',
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 't4p-core' ),
			'desc' => __( 'Select the button\'s size. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
				'xlarge' => 'XLarge',
			)
		),
		'type' => array(
			'type' => 'select',
			'label' => __( 'Button Type', 't4p-core' ),
			'desc' => __( 'Select the button\'s type. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'flat' => 'Flat',
				'3d' => '3D',
			)
		),
		'shape' => array(
			'type' => 'select',
			'label' => __( 'Button Shape', 't4p-core' ),
			'desc' => __( 'Select the button\'s shape. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'square' => 'Square',
				'pill' => 'Pill',
				'round' => 'Round',
			)
		),				
		'target' => array(
			'type' => 'select',
			'label' => __( 'Button Target', 't4p-core' ),
			'desc' => __( '_self = open in same window <br />_blank = open in new window.', 't4p-core' ),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button Title Attribute', 't4p-core' ),
			'desc' => __( 'Set a title attribute for the button link.', 't4p-core' ),
		),
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __( 'Button\'s Text', 't4p-core' ),
			'desc' => __( 'Add the text that will display in the button.', 't4p-core' ),
		),
		'gradtopcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Button Gradient Top Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the top color of the button background.', 't4p-core' )
		),
		'gradbottomcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Button Gradient Bottom Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the bottom color of the button background or leave empty for solid color.', 't4p-core' )
		),
		'gradtopcolorhover' => array(
			'type' => 'colorpicker',
			'label' => __( 'Button Gradient Top Color Hover', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the top hover color of the button background.', 't4p-core' )
		),
		'gradbottomcolorhover' => array(
			'type' => 'colorpicker',
			'label' => __( 'Button Gradient Bottom Color Hover', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the bottom hover color of the button background or leave empty for solid color.', 't4p-core' )
		),
		'accentcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Accent Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. This option controls the color of the button border, divider, text and icon.', 't4p-core' )
		),
		'accenthovercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Accent Hover Color', 't4p-core' ),
			'desc' => __( 'Custom setting only. This option controls the hover color of the button border, divider, text and icon.', 't4p-core' )
		),		
		'bevelcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Bevel Color (3D Mode only)', 't4p-core' ),
			'desc' => __( 'Custom setting only. Set the bevel color of 3D buttons.', 't4p-core' )
		),		
		'borderwidth' => array(
			'std' => '1px',
			'type' => 'text',
			'label' => __( 'Border Width', 't4p-core' ),
			'desc' => __( 'Custom setting only. In pixels (px), ex: 1px.  Leave blank for theme option selection.', 't4p-core' )
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'Custom setting. Backside.', 't4p-core' )
		),
		'borderhovercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Hover Color', 't4p-core' ),
			'desc' => __( 'Custom setting. Backside.', 't4p-core' )
		),
		/*		
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Text Color', 't4p-core' ),
			'desc' => 'Custom setting. Backside.'
		),
		'texthovercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Text Hover Color', 't4p-core' ),
			'desc' => 'Custom setting. Backside.'
		),
		*/
		'shadow' => array(
			'type' => 'select',
			'label' => __( 'Shadow', 't4p-core' ),
			'desc' => __( 'Choose to enable/disable the shadows. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'yes' => 'Yes',
				'no' => 'No',
			),
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Custom Icon', 't4p-core' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 't4p-core' ),
			'options' => $icons
		),
		/*
		'iconcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Icon Color', 't4p-core' ),
			'desc' => 'Custom setting. Leave blank for theme option selection.'
		),
		*/
		'iconposition' => array(
			'type' => 'select',
			'label' => __( 'Icon Position', 't4p-core' ),
			'desc' => __( 'Choose the position of the icon on the button.', 't4p-core' ),
			'options' => $leftright
		),			
		'icondivider' => array(
			'type' => 'select',
			'label' => __( 'Icon Divider', 't4p-core' ),
			'desc' => __( 'Choose to display a divider between icon and text.', 't4p-core' ),
			'options' => $choices
		),
		'modal' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Modal Window Anchor', 't4p-core' ),
			'desc' => __( 'Add the class name of the modal window you want to open on button click.', 't4p-core' ),
		),		
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),			
	),
	//'shortcode' => '[button link="{{url}}" color="{{style}}" size="{{size}}" type="{{type}}" shape="{{shape}}" target="{{target}}" title="{{title}}" gradient_colors="{{gradtopcolor}}|{{gradbottomcolor}}" gradient_hover_colors="{{gradtopcolorhover}}|{{gradbottomcolorhover}}" bevel_color="{{bevelcolor}}" border_width="{{bordersize}}" border_color="{{bordercolor}}" border_hover_color="{{borderhovercolor}}" text_color="{{textcolor}}" text_hover_color="{{texthovercolor}}" shadow="{{shadow}}" icon="{{icon}}" icon_color="{{iconcolor}}" icon_divider="{{icondivider}}" icon_position="{{iconposition}}" modal="{{modal}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"]{{content}}[/button]',
	'shortcode' => '[button link="{{url}}" color="{{style}}" size="{{size}}" type="{{type}}" shape="{{shape}}" target="{{target}}" title="{{title}}" gradient_colors="{{gradtopcolor}}|{{gradbottomcolor}}" gradient_hover_colors="{{gradtopcolorhover}}|{{gradbottomcolorhover}}" accent_color="{{accentcolor}}" accent_hover_color="{{accenthovercolor}}" bevel_color="{{bevelcolor}}" border_width="{{borderwidth}}" border_color="{{bordercolor}}" border_hover_color="{{borderhovercolor}}" shadow="{{shadow}}" icon="{{icon}}" icon_divider="{{icondivider}}" icon_position="{{iconposition}}" modal="{{modal}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"]{{content}}[/button]',
	'popup_title' => __( 'Button Shortcode', 't4p-core')
);

/*-----------------------------------------------------------------------------------*/
/*	Checklist Config
/*-----------------------------------------------------------------------------------*/
$t4p_shortcodes['checklist'] = array(
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 't4p-core' ),
			'desc' => __( 'Global setting for all list items, this can be overridden individually below. Click an icon to select, click again to deselect.', 't4p-core' ),
			'options' => $icons
		),
		'circle' => array(
			'type' => 'select',
			'label' => __( 'Icon in Circle', 't4p-core' ),
			'desc' => __( 'Global setting for all list items, this can be overridden individually below. Choose to display the icon in a circle.', 't4p-core' ),
			'options' => $choices
		),	
		'size' => array(
			'type' => 'select',
			'label' => __( 'Item Size', 't4p-core' ),
			'desc' => __( 'Select the list item\'s size.', 't4p-core' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			)
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),

	'shortcode' => '[checklist icon="{{icon}}" circle="{{circle}}" size="{{size}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/checklist]',
	'popup_title' => __( 'Checklist Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Select Icon', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' ),
				'options' => $icons
			),
			'iconcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),
			'circle' => array(
				'type' => 'select',
				'label' => __( 'Icon in Circle', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' ),
				'options' => $choices_with_default
			),
			'circlecolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Circle Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),				
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'List Item Content', 't4p-core' ),
				'desc' => __( 'Add list item content', 't4p-core' ),
			),
		),
		'shortcode' => '[li_item icon="{{icon}}" iconcolor="{{iconcolor}}" circle="{{circle}}" circlecolor="{{circlecolor}}"]{{content}}[/li_item]',
		'clone_button' => __( 'Add New List Item', 't4p-core')
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Client Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['clientslider'] = array(
	'params' => array(
		'picture_size' => array(
			'type' => 'select',
			'label' => __( 'Picture Size', 't4p-core' ),
			'desc' => __( 'fixed = width and height will be fixed <br />auto = width and height will adjust to the image.', 't4p-core' ),
			'options' => array(
				'fixed' => 'Fixed',
				'auto' => 'Auto'
			)
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),
	'shortcode' => '[clients picture_size="{{picture_size}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/clients]', // as there is no wrapper shortcode
	'popup_title' => __( 'Client Slider Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Client Website Link', 't4p-core' ),
				'desc' => __( 'Add the url to client\'s website <br />ex: http://example.com', 't4p-core')
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Link Target', 't4p-core' ),
				'desc' => __( '_self = open in same window <br /> _blank = open in new window', 't4p-core' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Client Image', 't4p-core' ),
				'desc' => __( 'Upload the client image', 't4p-core' ),
			),
			'alt' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Image Alt Text', 't4p-core' ),
				'desc' => 'The alt attribute provides alternative information if an image cannot be viewed'
			),				
		),
		'shortcode' => '[client link="{{url}}" linktarget="{{target}}" image="{{image}}" alt="{{alt}}"]',
		'clone_button' => __( 'Add New Client Image', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['columns'] = array(
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __( 'Insert Columns Shortcode', 't4p-core' ),
	'no_preview' => true,
	'params' => array(),

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __( 'Column Type', 't4p-core' ),
				'desc' => __( 'Select the width of the column', 't4p-core' ),
				'options' => array(
					'one_third' => 'One Third',
					'two_third' => 'Two Thirds',
					'one_half' => 'One Half',
					'one_fourth' => 'One Fourth',
					'three_fourth' => 'Three Fourth',
				)
			),
			'last' => array(
				'type' => 'select',
				'label' => __( 'Last Column', 't4p-core' ),
				'desc' => 'Choose if the column is last in a set. This has to be set to "Yes" for the last column in a set',
				'options' => $reverse_choices
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __( 'Column Content', 't4p-core' ),
				'desc' => __( 'Insert the column content', 't4p-core' ),
			),
			'class' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'CSS Class', 't4p-core' ),
				'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
			),
			'id' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'CSS ID', 't4p-core' ),
				'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
			),			
		),
		'shortcode' => '[{{column}} last="{{last}}" class="{{class}}" id="{{id}}"]{{content}}[/{{column}}] ',
		'clone_button' => __( 'Add Column', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Content Boxes Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['contentboxes'] = array(
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Box Layout', 't4p-core' ),
			'desc' => __( 'Select the layout for the content box', 't4p-core' ),
			'options' => array(
				'icon-with-title' => 'Icon beside Title',
				'icon-on-top' => 'Icon on Top of Title',
				'icon-on-side' => 'Icon beside Title and Content aligned with Title',
				'icon-boxed' => 'Icon Boxed',
			)
		),
		'columns' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Columns', 't4p-core' ),
			'desc' =>  __( 'Set the number of columns per row.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 5, false )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),			
	),
	'shortcode' => '[content_boxes layout="{{layout}}" columns="{{columns}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/content_boxes]', // as there is no wrapper shortcode
	'popup_title' => __( 'Content Boxes Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Title', 't4p-core')
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon', 't4p-core' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 't4p-core' ),
				'options' => $icons
			),
			'backgroundcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Content Box Background Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),			
			'iconcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),
			'circlecolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Circle Background Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),
			'circlebordercolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Circle Border Color', 't4p-core' ),
				'desc' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core')
			),			
			'iconflip' => array(
				'type' => 'select',
				'label' => __( 'Flip Icon', 't4p-core' ),
				'desc' => __( 'Choose to flip the icon.', 't4p-core' ),
				'options' => array(
					''	=> 'None',
					'horizontal' => 'Horizontal',
					'vertical' => 'Vertical',
				)
			),
			'iconrotate' => array(
				'type' => 'select',
				'label' => __( 'Rotate Icon', 't4p-core' ),
				'desc' => __( 'Choose to rotate the icon.', 't4p-core' ),
				'options' => array(
					''	=> 'None',
					'90' => '90',
					'180' => '180',
					'270' => '270',					
				)
			),				
			'iconspin' => array(
				'type' => 'select',
				'label' => __( 'Spinning Icon', 't4p-core' ),
				'desc' => __( 'Choose to let the icon spin.', 't4p-core' ),
				'options' => $reverse_choices
			),									
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Icon Image', 't4p-core' ),
				'desc' => __( 'To upload your own icon image, deselect the icon above and then upload your icon image.', 't4p-core' ),
			),
			'image_width' => array(
				'std' => 35,
				'type' => 'text',
				'label' => __( 'Icon Image Width', 't4p-core' ),
				'desc' => __( 'If using an icon image, specify the image width in pixels but do not add px, ex: 35.', 't4p-core' ),
			),
			'image_height' => array(
				'std' => 35,
				'type' => 'text',
				'label' => __( 'Icon Image Height', 't4p-core' ),
				'desc' => __( 'If using an icon image, specify the image height in pixels but do not add px, ex: 35.', 't4p-core' ),
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Read More Link Url', 't4p-core' ),
				'desc' => __( 'Add the link\'s url ex: http://example.com', 't4p-core' ),

			),
			'linktext' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Read More Link Text', 't4p-core' ),
				'desc' => __( 'Insert the text to display as the link', 't4p-core' ),

			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Read More Link Target', 't4p-core' ),
				'desc' => __( '_self = open in same window <br /> _blank = open in new window', 't4p-core' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Content Box Content', 't4p-core' ),
				'desc' => __( 'Add content for content box', 't4p-core' ),
			),
			'animation_type' => array(
				'type' => 'select',
				'label' => __( 'Animation Type', 't4p-core' ),
				'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
				'options' => array(
					'0' => 'None',
					'bounce' => 'Bounce',
					'fade' => 'Fade',
					'flash' => 'Flash',
					'shake' => 'Shake',
					'slide' => 'Slide',
				)
			),
			'animation_direction' => array(
				'type' => 'select',
				'label' => __( 'Direction of Animation', 't4p-core' ),
				'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
				'options' => array(
					'down' => 'Down',
					'left' => 'Left',
					'right' => 'Right',
					'up' => 'Up',
				)
			),
			'animation_speed' => array(
				'type' => 'select',
				'std' => '',
				'label' => __( 'Speed of Animation', 't4p-core' ),
				'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
				'options' => $dec_numbers,
			)
		),
		'shortcode' => '[content_box title="{{title}}" backgroundcolor="{{backgroundcolor}}" icon="{{icon}}" iconcolor="{{iconcolor}}" circlecolor="{{circlecolor}}" circlebordercolor="{{circlebordercolor}}" iconflip="{{iconflip}}" iconrotate="{{iconrotate}}" iconspin="{{iconspin}}" image="{{image}}" image_width="{{image_width}}" image_height="{{image_height}}" link="{{link}}" linktarget="{{target}}" linktext="{{linktext}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}"]{{content}}[/content_box]',
		'clone_button' => __( 'Add New Content Box', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Counters Box Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['countersbox'] = array(
	'params' => array(
		'columns' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Columns', 't4p-core' ),
			'desc' =>  __( 'Set the number of columns per row.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 4, false )
		),	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),
	),
	'shortcode' => '[counters_box columns="{{columns}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/counters_box]', // as there is no wrapper shortcode
	'popup_title' => __( 'Counters Box Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'value' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Counter Value', 't4p-core' ),
				'desc' => __( 'The number to which the counter will animate.', 't4p-core')
			),
			'unit' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Counter Box Unit', 't4p-core' ),
				'desc' => __( 'Insert a unit for the counter. ex %', 't4p-core' ),
			),
			'unitpos' => array(
				'type' => 'select',
				'label' => __( 'Unit Position', 't4p-core' ),
				'desc' => __( 'Choose the positioning of the unit.', 't4p-core' ),
				'options' => array(
					'suffix' => 'After Counter',
					'prefix' => 'Before Counter',
				)
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon', 't4p-core' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 't4p-core' ),
				'options' => $icons
			),			
			'border' => array(
				'type' => 'select',
				'label' => __( 'Show Border', 't4p-core' ),
				'desc' => __( 'Choose to show a box border.', 't4p-core' ),
				'options' => $choices
			),
			'color' => array(
				'type' => 'colorpicker',
				'label' => __( 'Color Of Counter', 't4p-core' ),
				'desc' => __( 'Controls the color of the counter text and icon. Leave blank for theme option selection.', 't4p-core')
			),
			'direction' => array(
				'type' => 'select',
				'label' => __( 'Counter Diection', 't4p-core' ),
				'desc' => __( 'Choose to count up or down.', 't4p-core' ),
				'options' => array(
					'up' => 'Countup',
					'down' => 'Countdown',
				)
			),			
			'content' => array(
				'std' => 'Text',
				'type' => 'text',
				'label' => __( 'Counter Box Text', 't4p-core' ),
				'desc' => __( 'Insert text for counter box', 't4p-core' ),
			)
		),
		'shortcode' => '[counter_box value="{{value}}" unit="{{unit}}" unit_pos="{{unitpos}}" icon="{{icon}}" border="{{border}}" color="{{color}}" direction="{{direction}}"]{{content}}[/counter_box]',
		'clone_button' => __( 'Add New Counter Box', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Counters Circle Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['counterscircle'] = array(
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),
	),
	'shortcode' => '[counters_circle class="{{class}}" id="{{id}}"]{{child_shortcode}}[/counters_circle]', // as there is no wrapper shortcode
	'popup_title' => __( 'Counters Circle Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'value' => array(
				'type' => 'select',
				'label' => __( 'Filled Area Percentage', 't4p-core' ),
				'desc' => __( 'From 1% to 100%', 't4p-core' ),
				'options' => t4p_shortcodes_range(100, false)
			),
			'filledcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Filled Color', 't4p-core' ),
				'desc' => __( 'Controls the color of the filled in area. Leave blank for theme option selection.', 't4p-core')
			),
			'unfilledcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Unfilled Color', 't4p-core' ),
				'desc' => __( 'Controls the color of the unfilled in area. Leave blank for theme option selection.', 't4p-core')
			),
			'size' => array(
				'std' => '220',
				'type' => 'text',
				'label' => __( 'Size of the Counter', 't4p-core' ),
				'desc' => __( 'Insert size of the counter in px. ex: 220', 't4p-core' ),
			),
			'scales' => array(
				'type' => 'select',
				'label' => __( 'Show Scales', 't4p-core' ),
				'desc' => __( 'Choose to show a scale around circles.', 't4p-core' ),
				'options' => $reverse_choices
			),		
			'countdown' => array(
				'type' => 'select',
				'label' => __( 'Countdown', 't4p-core' ),
				'desc' => __( 'Choose to let the circle filling move counter clockwise.', 't4p-core' ),
				'options' => $reverse_choices
			),					
			'speed' => array(
				'std' => '1500',
				'type' => 'text',
				'label' => __( 'Animation Speed', 't4p-core' ),
				'desc' => __( 'Insert animation speed in milliseconds', 't4p-core' ),
			),
			'content' => array(
				'std' => 'Text',
				'type' => 'text',
				'label' => __( 'Counter Circle Text', 't4p-core' ),
				'desc' => __( 'Insert text for counter circle box, keep it short', 't4p-core' ),
			),			
		),
		'shortcode' => '[counter_circle filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" size="{{size}}" scales="{{scales}}" countdown="{{countdown}}" speed="{{speed}}" value="{{value}}"]{{content}}[/counter_circle]',
		'clone_button' => __( 'Add New Counter Circle', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Dropcap Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'A',
			'type' => 'textarea',
			'label' => __( 'Dropcap Letter', 't4p-core' ),
			'desc' => __( 'Add the letter to be used as dropcap', 't4p-core' ),
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 't4p-core ')
		),		
		'boxed' => array(
			'type' => 'select',
			'label' => __( 'Boxed Dropcap', 't4p-core' ),
			'desc' => __( 'Choose to get a boxed dropcap.', 't4p-core' ),
			'options' => $reverse_choices
		),
		'boxedradius' => array(
			'std' => '8px',
			'type' => 'text',
			'label' => __( 'Box Radius', 't4p-core' ),
			'desc' => 'Choose the radius of the boxed dropcap. In pixels (px), ex: 1px, or "round".'
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),
	),
	'shortcode' => '[dropcap color="{{color}}" boxed="{{boxed}}" boxed_radius="{{boxedradius}}" class="{{class}}" id="{{id}}"]{{content}}[/dropcap]',
	'popup_title' => __( 'Dropcap Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Post Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['postslider'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Layout', 't4p-core' ),
			'desc' => __( 'Choose a layout style for Post Slider.', 't4p-core' ),
			'options' => array(
				'posts' => 'Posts with Title',
				'posts-with-excerpt' => 'Posts with Title and Excerpt',
				'attachments-only' => 'Attachment Layout, Only Images Attached to Post/Page'
			)
		),
		'excerpt' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Excerpt Number of Words', 't4p-core' ),
			'desc' => __( 'Insert the number of words you want to show in the excerpt.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 50, false)
		),
		'category' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Category', 't4p-core' ),
			'desc' => __( 'Select a category of posts to display.', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category', true )
		),
		'limit' => array(
			'std' => 3,
			'type' => 'select',
			'label' => __( 'Number of Slides', 't4p-core' ),
			'desc' => __( 'Select the number of slides to display.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 10, false )
		),
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Lightbox on Click', 't4p-core' ),
			'desc' => __( 'Only works on attachment layout.', 't4p-core' ),
			'options' => $choices
		),
		'image' => array(
			'type' => 'gallery',
			'label' => __( 'Attach Images to Post/Page Gallery', 't4p-core' ),
			'desc' => __( 'Only works for attachments layout.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),
	'shortcode' => '[postslider layout="{{type}}" excerpt="{{excerpt}}" category="{{category}}" limit="{{limit}}" id="" lightbox="{{lightbox}}" class="{{class}}" id="{{id}}"][/postslider]',
	'popup_title' => __( 'Post Slider Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Flip Boxes Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['flipboxes'] = array(
	'params' => array(

		'columns' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Columns', 't4p-core' ),
			'desc' =>  __( 'Set the number of columns per row.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 4, false )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[flip_boxes columns="{{columns}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/flip_boxes]', // as there is no wrapper shortcode
	'popup_title' => __( 'Flip Boxes Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'titlefront' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'text',
				'label' => __( 'Flip Box Frontside Heading', 't4p-core' ),
				'desc' => __( 'Add a heading for the frontside of the flip box.', 't4p-core' ),
			),			
			'titleback' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'text',
				'label' => __( 'Flip Box Backside Heading', 't4p-core' ),
				'desc' => __( 'Add a heading for the backside of the flip box.', 't4p-core' ),
			),			
			'textfront' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Flip Box Frontside Content', 't4p-core' ),
				'desc' => __( 'Add content for the frontside of the flip box.', 't4p-core' ),
			),			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Flip Box Backside Content', 't4p-core' ),
				'desc' => __( 'Add content for the backside of the flip box.', 't4p-core' ),
			),		
			'backgroundcolorfront' => array(
				'type' => 'colorpicker',
				'label' => __( 'Background Color Frontside', 't4p-core' ),
				'desc' => __( 'Controls the background color of the frontside. Leave blank for theme option selection.', 't4p-core' )
			),
			'titlecolorfront' => array(
				'type' => 'colorpicker',
				'label' => __( 'Heading Color Frontside', 't4p-core' ),
				'desc' => __( 'Controls the heading color of the frontside. Leave blank for theme option selection.', 't4p-core' )
			),
			'textcolorfront' => array(
				'type' => 'colorpicker',
				'label' => __( 'Text Color Frontside', 't4p-core' ),
				'desc' => __( 'Controls the text color of the frontside. Leave blank for theme option selection.', 't4p-core' )
			),			
			'backgroundcolorback' => array(
				'type' => 'colorpicker',
				'label' => __( 'Background Color Backside', 't4p-core' ),
				'desc' => __( 'Controls the background color of the backside. Leave blank for theme option selection.', 't4p-core' )
			),
			'titlecolorback' => array(
				'type' => 'colorpicker',
				'label' => __( 'Heading Color Backside', 't4p-core' ),
				'desc' => __( 'Controls the heading color of the backside. Leave blank for theme option selection.', 't4p-core' )
			),				
			'textcolorback' => array(
				'type' => 'colorpicker',
				'label' => __( 'Text Color Backside', 't4p-core' ),
				'desc' => __( 'Controls the text color of the backside. Leave blank for theme option selection.', 't4p-core' )
			),			
			'bordersize' => array(
				'std' => '1px',
				'type' => 'text',
				'label' => __( 'Border Size', 't4p-core' ),
				'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' ),
			),
			'bordercolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Border Color', 't4p-core' ),
				'desc' => __( 'Controls the border color.  Leave blank for theme option selection.', 't4p-core' )
			),
			'borderradius' => array(
				'std' => '3px',
				'type' => 'text',
				'label' => __( 'BorderRadius', 't4p-core' ),
				'desc' => __( 'Choose the radius of the flip box. In pixels (px), ex: 1px, or "round".  Leave blank for theme option selection.', 't4p-core' ),
			),			
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon', 't4p-core' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 't4p-core' ),
				'options' => $icons
			),			
			'iconcolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Color', 't4p-core' ),
				'desc' => __( 'Controls the color of the icon. Leave blank for theme option selection.', 't4p-core' )
			),
			'circle' => array(
				'std' => 0,
				'type' => 'select',
				'label' => __( 'Icon Circle', 't4p-core' ),
				'desc' => __( 'Choose to use a circled background on the icon.', 't4p-core' ),
				'options' => $choices
			),			
			'circlecolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Circle Background Color', 't4p-core' ),
				'desc' => __( 'Controls the color of the circle. Leave blank for theme option selection.', 't4p-core')
			),
			'circlebordercolor' => array(
				'type' => 'colorpicker',
				'label' => __( 'Icon Circle Border Color', 't4p-core' ),
				'desc' => __( 'Controls the color of the circle border. Leave blank for theme option selection.', 't4p-core')
			),			
			'iconflip' => array(
				'type' => 'select',
				'label' => __( 'Flip Icon', 't4p-core' ),
				'desc' => __( 'Choose to flip the icon.', 't4p-core' ),
				'options' => array(
					''	=> 'None',
					'horizontal' => 'Horizontal',
					'vertical' => 'Vertical',
				)
			),
			'iconrotate' => array(
				'type' => 'select',
				'label' => __( 'Rotate Icon', 't4p-core' ),
				'desc' => __( 'Choose to rotate the icon.', 't4p-core' ),
				'options' => array(
					''	=> 'None',
					'90' => '90',
					'180' => '180',
					'270' => '270',					
				)
			),				
			'iconspin' => array(
				'type' => 'select',
				'label' => __( 'Spinning Icon', 't4p-core' ),
				'desc' => __( 'Choose to let the icon spin.', 't4p-core' ),
				'options' => $reverse_choices
			),									
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Icon Image', 't4p-core' ),
				'desc' => __( 'To upload your own icon image, deselect the icon above and then upload your icon image.', 't4p-core' ),
			),
			'image_width' => array(
				'std' => 35,
				'type' => 'text',
				'label' => __( 'Icon Image Width', 't4p-core' ),
				'desc' => __( 'If using an icon image, specify the image width in pixels but do not add px, ex: 35.', 't4p-core' ),
			),
			'image_height' => array(
				'std' => 35,
				'type' => 'text',
				'label' => __( 'Icon Image Height', 't4p-core' ),
				'desc' => __( 'If using an icon image, specify the image height in pixels but do not add px, ex: 35.', 't4p-core' ),
			),
			'animation_type' => array(
				'type' => 'select',
				'label' => __( 'Animation Type', 't4p-core' ),
				'desc' => __( 'Select the type on animation to use on the shortcode.', 't4p-core' ),
				'options' => array(
					'0' => 'None',
					'bounce' => 'Bounce',
					'fade' => 'Fade',
					'flash' => 'Flash',
					'shake' => 'Shake',
					'slide' => 'Slide',
				)
			),
			'animation_direction' => array(
				'type' => 'select',
				'label' => __( 'Direction of Animation', 't4p-core' ),
				'desc' => __( 'Select the incoming direction for the animation.', 't4p-core' ),
				'options' => array(
					'down' => 'Down',
					'left' => 'Left',
					'right' => 'Right',
					'up' => 'Up',
				)
			),
			'animation_speed' => array(
				'type' => 'select',
				'std' => '',
				'label' => __( 'Speed of Animation', 't4p-core' ),
				'desc' => __( 'Type in speed of animation in seconds (0.1 - 1).', 't4p-core' ),
				'options' => $dec_numbers,
			)
		),
		'shortcode' => '[flip_box title_front="{{titlefront}}" title_back="{{titleback}}" text_front="{{textfront}}" border_color="{{bordercolor}}" border_radius="{{borderradius}}" border_size="{{bordersize}}" background_color_front="{{backgroundcolorfront}}" title_front_color="{{titlecolorfront}}" text_front_color="{{textcolorfront}}" background_color_back="{{backgroundcolorback}}" title_back_color="{{titlecolorback}}" text_back_color="{{textcolorback}}" icon="{{icon}}" icon_color="{{iconcolor}}" circle="{{circle}}" circle_color="{{circlecolor}}" circle_border_color="{{circlebordercolor}}" icon_flip="{{iconflip}}" icon_rotate="{{iconrotate}}" icon_spin="{{iconspin}}" image="{{image}}" image_width="{{image_width}}" image_height="{{image_height}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}"]{{content}}[/flip_box]',
		'clone_button' => __( 'Add New Flip Box', 't4p-core')
	)
);


/*-----------------------------------------------------------------------------------*/
/*	FontAwesome Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 't4p-core' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 't4p-core' ),
			'options' => $icons
		),
		'circle' => array(
			'type' => 'select',
			'label' => __( 'Icon in Circle', 't4p-core' ),
			'desc' => __( 'Choose to display the icon in a circle.', 't4p-core' ),
			'options' => $choices
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size of Icon', 't4p-core' ),
			'desc' => __( 'Select the size of the icon.', 't4p-core' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			)
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the icon. Leave blank for theme option selection.', 't4p-core')
		),
		'circlecolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Circle Background Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the circle. Leave blank for theme option selection.', 't4p-core')
		),
		'circlebordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Circle Border Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the circle border. Leave blank for theme option selection.', 't4p-core')
		),
		'flip' => array(
			'type' => 'select',
			'label' => __( 'Flip Icon', 't4p-core' ),
			'desc' => __( 'Choose to flip the icon.', 't4p-core' ),
			'options' => array(
				''	=> 'None',
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical',
			)
		),
		'rotate' => array(
			'type' => 'select',
			'label' => __( 'Rotate Icon', 't4p-core' ),
			'desc' => __( 'Choose to rotate the icon.', 't4p-core' ),
			'options' => array(
				''	=> 'None',
				'90' => '90',
				'180' => '180',
				'270' => '270',					
			)
		),				
		'spin' => array(
			'type' => 'select',
			'label' => __( 'Spinning Icon', 't4p-core' ),
			'desc' => __( 'Choose to let the icon spin.', 't4p-core' ),
			'options' => $reverse_choices
		),		
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode.', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation.', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1).', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),		
	),
	'shortcode' => '[fontawesome icon="{{icon}}" circle="{{circle}}" size="{{size}}" iconcolor="{{iconcolor}}" circlecolor="{{circlecolor}}" circlebordercolor="{{circlebordercolor}}" flip="{{flip}}" rotate="{{rotate}}" spin="{{spin}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Font Awesome Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Fullwidth Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['fullwidth'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color.  Leave blank for theme option selection.', 't4p-core')
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __( 'Backgrond Image', 't4p-core' ),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __( 'Background Repeat', 't4p-core' ),
			'desc' => 'Choose how the background image repeats.',
			'options' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat Vertically and Horizontally',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically'
			)
		),
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 't4p-core' ),
			'desc' => 'Choose the postion of the background image',
			'options' => array(
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
				'center top' => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom'
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __( 'Background Scroll', 't4p-core' ),
			'desc' => 'Choose how the background image scrolls',
			'options' => array(
				'scroll' => 'Scroll: background scrolls along with the element',
				'fixed' => 'Fixed: background is fixed giving a parallax effect',
				'local' => 'Local: background scrolls along with the element\'s contents'
			)
		),
		'bordersize' => array(
			'std' => '0px',
			'type' => 'text',
			'label' => __( 'Border Size', 't4p-core' ),
			'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' ),
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'Controls the border color.  Leave blank for theme option selection.', 't4p-core')
		),
		'borderstyle' => array(
			'type' => 'select',
			'label' => __( 'Border Style', 't4p-core' ),
			'desc' => __( 'Controls the border style.', 't4p-core' ),
			'options' => array(
				'solid' => 'Solid',
				'dashed' => 'Dashed',
				'dotted' => 'Dotted'
			)			
		),		
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', 't4p-core' ),
			'desc' => __( 'In pixels', 't4p-core' ),
			'options' => t4p_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', 't4p-core' ),
			'desc' => __( 'In pixels', 't4p-core' ),
			'options' => t4p_shortcodes_range( 100, false )
		),
		'menuanchor' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name Of Menu Anchor', 't4p-core' ),
			'desc' => 'This name will be the id you will have to use in your one page menu.',
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 't4p-core' ),
			'desc' => __( 'Add content', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),			
	),
	'shortcode' => '[fullwidth menu_anchor="{{menuanchor}}" backgroundcolor="{{backgroundcolor}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}" bordercolor="{{bordercolor}}" borderstyle="{{borderstyle}}" paddingtop="{{paddingtop}}px" paddingbottom="{{paddingbottom}}px" class="{{class}}" id="{{id}}"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Fullwidth Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Google Map Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['googlemap'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Map Type', 't4p-core' ),
			'desc' => __( 'Select the type of google map to display.', 't4p-core' ),
			'options' => array(
				'roadmap' => 'Roadmap',
				'satellite' => 'Satellite',
				'hybrid' => 'Hybrid',
				'terrain' => 'Terrain'
			)
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __( 'Map Width', 't4p-core' ),
			'desc' => __( 'Map width in percentage or pixels. ex: 100%, or 940px', 't4p-core')
		),
		'height' => array(
			'std' => '300px',
			'type' => 'text',
			'label' => __( 'Map Height', 't4p-core' ),
			'desc' => __( 'Map height in percentage or pixels. ex: 100%, or 300px', 't4p-core')
		),
		'zoom' => array(
			'std' => 14,
			'type' => 'select',
			'label' => __( 'Zoom Level', 't4p-core' ),
			'desc' => __( 'Higher number will be more zoomed in.', 't4p-core' ),
			'options' => t4p_shortcodes_range( 25, false )
		),
		'scrollwheel' => array(
			'type' => 'select',
			'label' => __( 'Scrollwheel on Map', 't4p-core' ),
			'desc' => __( 'Enable zooming using a mouse\'s scroll wheel.', 't4p-core' ),
			'options' => $choices
		),
		'scale' => array(
			'type' => 'select',
			'label' => __( 'Show Scale Control on Map', 't4p-core' ),
			'desc' => __( 'Display the map scale.', 't4p-core' ),
			'options' => $choices
		),
		'zoom_pancontrol' => array(
			'type' => 'select',
			'label' => __( 'Show Pan Control on Map', 't4p-core' ),
			'desc' => __( 'Displays pan control button.', 't4p-core' ),
			'options' => $choices
		),
		'popup' => array(
			'type' => 'select',
			'label' => __( 'Show tooltip by default?', 't4p-core' ),
			'desc' => __( 'Display or hide the tooltip when the map first loads.', 't4p-core' ),
			'options' => $choices
		),
		'mapstyle' => array(
			'type' => 'select',
			'label' => __( 'Select the Map Styling', 't4p-core' ),
			'desc' => __( 'Choose default styling for classic google map styles. Choose theme styling for our custom style. Choose custom styling to make your own with the advanced options below.', 't4p-core' ),
			'options' => array(
				'default' => 'Default Styling',
				'theme' => 'Theme Styling',
				'custom' => 'Custom Styling',
			)
		),	
		'overlaycolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Map Overlay Color', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Pick an overlaying color for the map. Works best with "roadmap" type.', 't4p-core')
		),
		'infobox' => array(
			'type' => 'select',
			'label' => __( 'Infobox Styling', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Choose between default or custom info box.', 't4p-core' ),
			'options' => array(
				'default' => 'Default Infobox',
				'custom' => 'Custom Infobox',
			)
		),
		'infoboxcontent' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Infobox Content', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Type in custom info box content to replace address string. For multiple addresses, separate info box contents by using the | symbol. ex: InfoBox 1|InfoBox 2|InfoBox 3', 't4p-core' ),
		),		
		'infoboxtextcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Info Box Text Color', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Pick a color for the info box text.', 't4p-core')
		),
		'infoboxbackgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Info Box Background Color', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Pick a color for the info box background.', 't4p-core')
		),
		'icon' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Custom Marker Icon', 't4p-core' ),
			'desc' => __( 'Custom styling setting only. Use full image urls for custom marker icons or input "theme" for our custom marker. For multiple addresses, separate icons by using the | symbol or use one for all. ex: Icon 1|Icon 2|Icon 3', 't4p-core' ),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Address', 't4p-core' ),
			'desc' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol. <br />ex: Address 1|Address 2|Address 3', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' ),
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' ),
		)
	),
	'shortcode' => '[map address="{{content}}" type="{{type}}" map_style="{{mapstyle}}" overlay_color="{{overlaycolor}}" infobox="{{infobox}}" infobox_background_color="{{infoboxbackgroundcolor}}" infobox_text_color="{{infoboxtextcolor}}" infobox_content="{{infoboxcontent}}" icon="{{icon}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}" popup="{{popup}}" class="{{class}}" id="{{id}}"][/map]',
	'popup_title' => __( 'Google Map Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Highlight Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' => array(

		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Highlight Color', 't4p-core' ),
			'desc' => __( 'Pick a highlight color', 't4p-core')
		),
		'rounded' => array(
			'type' => 'select',
			'label' => __( 'Highlight With Round Edges', 't4p-core' ),
			'desc' => __( 'Choose to have rounded edges.', 't4p-core' ),
			'options' => $reverse_choices
		),		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content to Higlight', 't4p-core' ),
			'desc' => __( 'Add your content to be highlighted', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),			

	),
	'shortcode' => '[highlight color="{{color}}" rounded="{{rounded}}" class="{{class}}" id="{{id}}"]{{content}}[/highlight]',
	'popup_title' => __( 'Highlight Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Image Carousel Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['imagecarousel'] = array(
	'params' => array(
		'picture_size' => array(
			'type' => 'select',
			'label' => __( 'Picture Size', 't4p-core' ),
			'desc' => __( 'fixed = width and height will be fixed <br />auto = width and height will adjust to the image.', 't4p-core' ),
			'options' => array(
				'fixed' => 'Fixed',
				'auto' => 'Auto'
			)
		),
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Image lightbox', 't4p-core' ),
			'desc' => __( 'Show image in lightbox.', 't4p-core' ),
			'options' => $choices
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[images picture_size="{{picture_size}}" lightbox="{{lightbox}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/images]', // as there is no wrapper shortcode
	'popup_title' => __( 'Image Carousel Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Image Website Link', 't4p-core' ),
				'desc' => __( 'Add the url to image\'s website. If lightbox option is enabled, you have to add the full image link to show it in the lightbox.', 't4p-core' )
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Link Target', 't4p-core' ),
				'desc' => __( '_self = open in same window <br />_blank = open in new window', 't4p-core' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Image', 't4p-core' ),
				'desc' => __( 'Upload an image to display.', 't4p-core' ),
			),
			'alt' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Image Alt Text', 't4p-core' ),
				'desc' => __( 'The alt attribute provides alternative information if an image cannot be viewed.', 't4p-core' ),
			)
		),
		'shortcode' => '[image link="{{url}}" linktarget="{{target}}" image="{{image}}" alt="{{alt}}"]',
		'clone_button' => __( 'Add New Image', 't4p-core' )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Image Frame Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['imageframe'] = array(
	'no_preview' => true,
	'params' => array(
		'style_type' => array(
			'type' => 'select',
			'label' => __( 'Frame Style Type', 't4p-core' ),
			'desc' => __( 'Select the frame style type.', 't4p-core' ),
			'options' => array(
				'none' => 'None',
				'border' => 'Border',
				'glow' => 'Glow',
				'dropshadow' => 'Drop Shadow',
				'bottomshadow' => 'Bottom Shadow'
			)
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'For border style only. Controls the border color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'bordersize' => array(
			'std' => '0px',
			'type' => 'text',
			'label' => __( 'Border Size', 't4p-core' ),
			'desc' => __( 'For border style only. In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' ),
		),
		'stylecolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Style Color', 't4p-core' ),
			'desc' => __( 'For all style types except border. Controls the style color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'align' => array(
			'std' => 'none',
			'type' => 'select',
			'label' => __( 'Align', 't4p-core' ),
			'desc' => 'Choose how to align the image',
			'options' => array(
				'none' => 'None',
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center'
			)
		),
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Image lightbox', 't4p-core' ),
			'desc' => __( 'Show image in Lightbox', 't4p-core' ),
			'options' => $reverse_choices
		),
		'image' => array(
			'type' => 'uploader',
			'label' => __( 'Image', 't4p-core' ),
			'desc' => 'Upload an image to display in the frame'
		),
		'alt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Image Alt Text', 't4p-core' ),
			'desc' => 'The alt attribute provides alternative information if an image cannot be viewed'
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core')
		),			
	),
	'shortcode' => '[imageframe lightbox="{{lightbox}}" style_type="{{style_type}}" bordercolor="{{bordercolor}}" bordersize="{{bordersize}}" stylecolor="{{stylecolor}}" align="{{align}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"]&lt;img alt="{{alt}}" src="{{image}}" /&gt;[/imageframe]',
	'popup_title' => __( 'Image Frame Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'params' => array(

		'full_image' => array(
			'type' => 'uploader',
			'label' => __( 'Full Image', 't4p-core' ),
			'desc' => __( 'Upload an image that will show up in the lightbox.', 't4p-core' ),
		),
		'thumb_image' => array(
			'type' => 'uploader',
			'label' => __( 'Thumbnail Image', 't4p-core' ),
			'desc' => __( 'Clicking this image will show lightbox.', 't4p-core' ),
		),
		'alt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Alt Text', 't4p-core' ),
			'desc' => __( 'The alt attribute provides alternative information if an image cannot be viewed.', 't4p-core' ),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Lightbox Description', 't4p-core' ),
			'desc' => __( 'This will show up in the lightbox as a description below the image.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),				
	),
	'shortcode' => '&lt;a title="{{title}}" class="{{class}} id="{{id}} href="{{full_image}}" rel="prettyPhoto"&gt;&lt;img alt="{{alt}}" src="{{thumb_image}}" /&gt;&lt;/a&gt;',
	'popup_title' => __( 'Lightbox Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Menu Anchor Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['menuanchor'] = array(
	'no_preview' => true,
	'params' => array(

		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name Of Menu Anchor', 't4p-core' ),
			'desc' => 'This name will be the id you will have to use in your one page menu.',

		)
	),
	'shortcode' => '[menu_anchor name="{{name}}"]',
	'popup_title' => __( 'Menu Anchor Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Modal Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['modal'] = array(
	'no_preview' => true,
	'params' => array(

		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name Of Modal', 't4p-core' ),
			'desc' => __( 'Needs to be a unique identifier (lowercase), used for button or modal_text_link shortcode to open the modal. ex: mymodal', 't4p-core' ),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Modal Heading', 't4p-core' ),
			'desc' => __( 'Heading text for the modal.', 't4p-core' ),
		),		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size Of Modal', 't4p-core' ),
			'desc' => __( 'Select the modal window size.', 't4p-core' ),
			'options' => array(
				'small' => 'Small',
				'large' => 'Large'
			)
		),
		'background' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the modal background color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'Controls the modal border color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'showfooter' => array(
			'type' => 'select',
			'label' => __( 'Show footer', 't4p-core' ),
			'desc' => __( 'Choose to show the modal footer with close button.', 't4p-core' ),
			'options' => $choices
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Contents of Modal', 't4p-core' ),
			'desc' => __( 'Add your content to be displayed in modal.', 't4p-core' ),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[modal name="{{name}}" title="{{title}}" size="{{size}}" background="{{background}}" border_color="{{bordercolor}}" show_footer="{{showfooter}}" class="{{class}}" id="{{id}}"]{{content}}[/modal]',
	'popup_title' => __( 'Modal Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Modal Text Link Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['modaltextlink'] = array(
	'no_preview' => true,
	'params' => array(
		'modal' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name Of Modal', 't4p-core' ),
			'desc' => 'Unique identifier of the modal to open on click.',
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text or HTML code', 't4p-core' ),
			'desc' => __( 'Insert text or HTML code here (e.g: HTML for image). This content will be used to trigger the modal popup.', 't4p-core' ),
		),	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[modal_text_link name="{{modal}}" class="{{class}}" id="{{id}}"]{{content}}[/modal_text_link]',
	'popup_title' => __( 'Modal Text Link Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Person Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['person'] = array(
	'no_preview' => true,
	'params' => array(
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name', 't4p-core' ),
			'desc' => __( 'Insert the name of the person.', 't4p-core' ),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 't4p-core' ),
			'desc' => __( 'Insert the title of the person', 't4p-core' ),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Profile Description', 't4p-core' ),
			'desc' => __( 'Enter the content to be displayed', 't4p-core' )
		),
		'picture' => array(
			'type' => 'uploader',
			'label' => __( 'Picture', 't4p-core' ),
			'desc' => __( 'Upload an image to display.', 't4p-core' ),
		),
		'piclink' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Picture Link URL', 't4p-core' ),
			'desc' => __( 'Add the URL the picture will link to, ex: http://example.com.', 't4p-core' ),
		),
		'picstyle' => array(
			'type' => 'select',
			'label' => __( 'Picture Style Type', 't4p-core' ),
			'desc' => __( 'Selected the style type for the picture,', 't4p-core' ),
			'options' => array(
				'none' => 'None',
				'border' => 'Border',
				'glow' => 'Glow',
				'dropshadow' => 'Drop Shadow',
				'bottomshadow' => 'Bottom Shadow'
			)
		),
		'pic_style_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Picture Style color', 't4p-core' ),
			'desc' => __( 'For all style types except border. Controls the style color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'picborder' => array(
			'std' => '0',
			'type' => 'text',
			'label' => __( 'Picture Border Size', 't4p-core' ),
			'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' ),
		),
		'picbordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Picture Border Color', 't4p-core' ),
			'desc' => __( 'Controls the picture\'s border color. Leave blank for theme option selection.', 't4p-core' ),
		),		
		'iconboxed' => array(
			'type' => 'select',
			'label' => __( 'Boxed Social Icons', 't4p-core' ),
			'desc' => __( 'Choose to get a boxed icons. Choose default for theme option selection.', 't4p-core' ),
			'options' => $reverse_choices_with_default
		),
		'iconboxedradius' => array(
			'std' => '3px',
			'type' => 'text',
			'label' => __( 'Social Icon Box Radius', 't4p-core' ),
			'desc' => __( 'Choose the radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 't4p-core' ),
		),		
		'iconcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Colors', 't4p-core' ),
			'desc' => __( 'Specify the color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA.  Leave blank for theme option selection.', 't4p-core' ),
		),
		'boxcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Box Colors', 't4p-core' ),
			'desc' => __( 'Specify the box color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
		),
		'icontooltip' => array(
			'type' => 'select',
			'label' => __( 'Social Icon Tooltip Position', 't4p-core' ),
			'desc' => __( 'Choose the display position for tooltips. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'Right' => 'Right',
			)
		),			
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Email Address', 't4p-core' ),
			'desc' => __( 'Insert an email address to display the email icon', 't4p-core' ),
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Facebook Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Facebook link', 't4p-core' ),
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Twitter Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Twitter link', 't4p-core' ),
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Dribbble Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Dribbble link', 't4p-core' ),
		),
		'google' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Google+ Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Google+ link', 't4p-core' ),
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'LinkedIn Link', 't4p-core' ),
			'desc' => __( 'Insert your custom LinkedIn link', 't4p-core' ),
		),
		'blogger' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Blogger Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Blogger link', 't4p-core' ),
		),
		'tumblr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Tumblr Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Tumblr link', 't4p-core' ),
		),
		'reddit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Reddit Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Reddit link', 't4p-core' ),
		),
		'yahoo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Yahoo Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Yahoo link', 't4p-core' ),
		),
		'deviantart' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Deviantart Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Deviantart link', 't4p-core' ),
		),
		'vimeo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Vimeo Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Vimeo link', 't4p-core' ),
		),
		'youtube' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Youtube Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Youtube link', 't4p-core' ),
		),
		'pinterest' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Pinterst Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Pinterest link', 't4p-core' ),
		),
		'rss' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'RSS Link', 't4p-core' ),
			'desc' => __( 'Insert your custom RSS link', 't4p-core' ),
		),		
		'digg' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Digg Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Digg link', 't4p-core' ),
		),
		'flickr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Flickr Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Flickr link', 't4p-core' ),
		),
		'forrst' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Forrst Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Forrst link', 't4p-core' ),
		),
		'myspace' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Myspace Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Myspace link', 't4p-core' ),
		),
		'skype' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Skype Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Skype link', 't4p-core' ),
		),
		'paypal' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'PayPal Link', 't4p-core' ),
			'desc' => __( 'Insert your custom paypal link', 't4p-core' ),
		),
		'dropbox' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Dropbox Link', 't4p-core' ),
			'desc' => __( 'Insert your custom dropbox link', 't4p-core' ),
		),
		'soundcloud' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'SoundCloud Link', 't4p-core' ),
			'desc' => __( 'Insert your custom soundcloud link', 't4p-core' ),
		),
		'vk' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'VK Link', 't4p-core' ),
			'desc' => __( 'Insert your custom vk link', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),
	),
	'shortcode' => '[person name="{{name}}" title="{{title}}" picture="{{picture}}" pic_link="{{piclink}}" pic_style="{{picstyle}}" pic_style_color="{{pic_style_color}}" pic_bordersize="{{picborder}}" pic_bordercolor="{{picbordercolor}}"  social_icon_boxed="{{iconboxed}}" social_icon_boxed_radius="{{iconboxedradius}}" social_icon_colors="{{iconcolor}}"  social_icon_boxed_colors="{{boxcolor}}" social_icon_tooltip="{{icontooltip}}" email="{{email}}" facebook="{{facebook}}" twitter="{{twitter}}" dribbble="{{dribbble}}" google="{{google}}" linkedin="{{linkedin}}" blogger="{{blogger}}" tumblr="{{tumblr}}" reddit="{{reddit}}" yahoo="{{yahoo}}" deviantart="{{deviantart}}" vimeo="{{vimeo}}" youtube="{{youtube}}" rss="{{rss}}" pinterest="{{pinterest}}" digg="{{digg}}" flickr="{{flickr}}" forrst="{{forrst}}" myspace="{{myspace}}" skype="{{skype}}" paypal="{{paypal}}" dropbox="{{dropbox}}" soundcloud="{{soundcloud}}" vk="{{vk}}" class="{{class}} id="{{id}}"]{{content}}[/person]',
	'popup_title' => __( 'Person Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Popover Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['popover'] = array(
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Popover Heading', 't4p-core' ),
			'desc' => __( 'Heading text of the popover.', 't4p-core' ),
		),
		'titlebgcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Popover Heading Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color of the popover heading. Leave blank for theme option selection.', 't4p-core')
		),			
		'popovercontent' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Contents Inside Popover', 't4p-core' ),
			'desc' => __( 'Text to be displayed inside the popover.', 't4p-core' ),
		),
		'contentbgcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Popover Content Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color of the popover content area. Leave blank for theme option selection.', 't4p-core')
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Popover Border Color', 't4p-core' ),
			'desc' => __( 'Controls the border color of the of the popover box. Leave blank for theme option selection.', 't4p-core')
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Popover Text Color', 't4p-core' ),
			'desc' => __( 'Controls all the text color inside the popover box. Leave blank for theme option selection.', 't4p-core')
		),
		'trigger' => array(
			'type' => 'select',
			'label' => __( 'Popover Trigger Method', 't4p-core' ),
			'desc' => __( 'Choose mouse action to trigger popover.', 't4p-core' ),
			'options' => array(
				'click' => 'Click',
				'hover' => 'Hover',
			)
		),
		'placement' => array(
			'type' => 'select',
			'label' => __( 'Popover Position', 't4p-core' ),
			'desc' => __( 'Choose the display position of the popover. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'Right' => 'Right',
			)
		),
		'content' => array(
			'std' => 'Text',
			'type' => 'text',
			'label' => __( 'Triggering Content', 't4p-core' ),
			'desc' => __( 'Content that will trigger the popover.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[popover title="{{title}}" title_bg_color="{{titlebgcolor}}" content="{{popovercontent}}" content_bg_color="{{contentbgcolor}}" bordercolor="{{bordercolor}}" textcolor="{{textcolor}}" trigger="{{trigger}}" placement="{{placement}}" class="{{class}}" id="{{id}}"]{{content}}[/popover]', // as there is no wrapper shortcode
	'popup_title' => __( 'Popover Shortcode', 't4p-core' ),
	'no_preview' => true,
);

/*-----------------------------------------------------------------------------------*/
/*	Pricing Table Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['pricingtable'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Type', 't4p-core' ),
			'desc' => __( 'Select the type of pricing table', 't4p-core' ),
			'options' => array(
				'1' => 'Style 1 (Supports 5 Columns)',
				'2' => 'Style 2 (Supports 4 Columns)',
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => 'Controls the background color. Leave blank for theme option selection.'
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => 'Controls the border color. Leave blank for theme option selection.'
		),
		'dividercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Divider Color', 't4p-core' ),
			'desc' => 'Controls the divider color. Leave blank for theme option selection.'
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Number of Columns', 't4p-core' ),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '1 Column',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '2 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '3 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '4 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '5 Columns'
			)
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[pricing_table type="{{type}}" backgroundcolor="{{backgroundcolor}}" bordercolor="{{bordercolor}}" dividercolor="{{dividercolor}}" class="{{class}}" id="{{id}}"]{{columns}}[/pricing_table]',
	'popup_title' => __( 'Pricing Table Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['progressbar'] = array(
	'params' => array(

		'percentage' => array(
			'type' => 'select',
			'label' => __( 'Filled Area Percentage', 't4p-core' ),
			'desc' => __( 'From 1% to 100%', 't4p-core' ),
			'options' => t4p_shortcodes_range( 100, false )
		),
		'unit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Progress Bar Unit', 't4p-core' ),
			'desc' => __( 'Insert a unit for the progress bar. ex %', 't4p-core' ),
		),
		'filledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Filled Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the filled in area. Leave blank for theme option selection.', 't4p-core' )
		),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Unfilled Color', 't4p-core' ),
			'desc' => __( 'Controls the color of the unfilled in area. Leave blank for theme option selection.', 't4p-core' )
		),
		'striped' => array(
			'type' => 'select',
			'label' => __( 'Striped Filling', 't4p-core' ),
			'desc' => __( 'Choose to get the filled area striped.', 't4p-core' ),
			'options' => $reverse_choices
		),
		'animatedstripes' => array(
			'type' => 'select',
			'label' => __( 'Animated Stripes', 't4p-core' ),
			'desc' => __( 'Choose to get the the stripes animated.', 't4p-core' ),
			'options' => $reverse_choices
		),			
		'textcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Text Color', 't4p-core' ),
			'desc' => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core ')
		),
		'content' => array(
			'std' => 'Text',
			'type' => 'text',
			'label' => __( 'Progess Bar Text', 't4p-core' ),
			'desc' => __( 'Text will show up on progess bar', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[progress percentage="{{percentage}}" unit="{{unit}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" striped="{{striped}}" animated_stripes="{{animatedstripes}}" textcolor="{{textcolor}}" class="{{class}}" id="{{id}}"]{{content}}[/progress]',
	'popup_title' => __( 'Progress Bar Shortcode', 't4p-core' ),
	'no_preview' => true,
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Posts Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['recentposts'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Layout', 't4p-core' ),
			'desc' => 'Select the layout for the shortcode',
			'options' => array(
				'default' => 'Default',
				'thumbnails-on-side' => 'Thumbnails on Side',
				'icon-on-side' => 'Icon on Side',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Columns', 't4p-core' ),
			'desc' => __( 'Select the number of columns to display', 't4p-core' ),
			'options' => t4p_shortcodes_range( 4, false )
		),
		'number_posts' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Posts', 't4p-core' ),
			'desc' => 'Select the number of posts to display',
			'options' => t4p_shortcodes_range( 12, false )
		),
		'cat_slug' => array(
			'type' => 'multiple_select',
			'label' => __( 'Categories', 't4p-core' ),
			'desc' => __( 'Select a category or leave blank for all', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category' )
		),
		'exclude_cats' => array(
			'type' => 'multiple_select',
			'label' => __( 'Exclude Categories', 't4p-core' ),
			'desc' => __( 'Select a category to exclude', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category' )
		),
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Show Thumbnail', 't4p-core' ),
			'desc' => 'Display the post featured image',
			'options' => $choices
		),
		'title' => array(
			'type' => 'select',
			'label' => __( 'Show Title', 't4p-core' ),
			'desc' => 'Display the post title below the featured image',
			'options' => $choices
		),
		'meta' => array(
			'type' => 'select',
			'label' => __( 'Show Meta', 't4p-core' ),
			'desc' => 'Choose to show all meta data',
			'options' => $choices
		),
		'excerpt' => array(
			'type' => 'select',
			'label' => __( 'Show Excerpt', 't4p-core' ),
			'desc' => 'Choose to display the post excerpt',
			'options' => $choices
		),
		'excerpt_length' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Excerpt Length', 't4p-core' ),
			'desc' => 'Insert the number of words/characters you want to show in the excerpt',
			'options' => t4p_shortcodes_range( 60, false )
		),
		'strip_html' => array(
			'type' => 'select',
			'label' => __( 'Strip HTML', 't4p-core' ),
			'desc' => 'Strip HTML from the post excerpt',
			'options' => $choices
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[recent_posts layout="{{layout}}" columns="{{columns}}" number_posts="{{number_posts}}" cat_slug="{{cat_slug}}" exclude_cats="{{exclude_cats}}" thumbnail="{{thumbnail}}" title="{{title}}" meta="{{meta}}" excerpt="{{excerpt}}" excerpt_length="{{excerpt_length}}" strip_html="{{strip_html}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"][/recent_posts]',
	'popup_title' => __( 'Recent Posts Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Works Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['recentworks'] = array(
	'no_preview' => true,
	'params' => array(
		'layout' => array(
			'type' => 'select',
			'label' => __( 'Layout', 't4p-core' ),
			'desc' => 'Choose the layout for the shortcode',
			'options' => array(
				'carousel' => 'Carousel',
				'grid' => 'Grid',
				'grid-with-excerpts' => 'Grid with Excerpts',
			)
		),
		'picture_size' => array(
			'type' => 'select',
			'label' => __( 'Picture Size For Carousel Layout', 't4p-core' ),
			'desc' => __( 'fixed = width and height will be fixed <br />auto = width and height will adjust to the image.<br />only works with carousel layout.', 't4p-core' ),
			'options' => array(
				'fixed' => 'Fixed',
				'auto' => 'Auto'
			)
		),
		'filters' => array(
			'type' => 'select',
			'label' => __( 'Show Filters', 't4p-core' ),
			'desc' => 'Choose to show or hide the category filters',
			'options' => $choices
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Columns', 't4p-core' ),
			'desc' => __( 'Select the number of columns to display', 't4p-core' ),
			'options' => t4p_shortcodes_range( 4, false )
		),
		'cat_slug' => array(
			'type' => 'multiple_select',
			'label' => __( 'Categories', 't4p-core' ),
			'desc' => __( 'Select a category or leave blank for all', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'portfolio_category' )
		),
		'exclude_cats' => array(
			'type' => 'multiple_select',
			'label' => __( 'Exclude Categories', 't4p-core' ),
			'desc' => __( 'Select a category to exclude', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'category' )
		),		
		'number_posts' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Posts', 't4p-core' ),
			'desc' => 'Select the number of posts to display',
			'options' => t4p_shortcodes_range( 12, false )
		),
		'excerpt_length' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Excerpt Length', 't4p-core' ),
			'desc' => 'Insert the number of words/characters you want to show in the excerpt',
			'options' => t4p_shortcodes_range( 60, false )
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[recent_works picture_size="{{picture_size}}" layout="{{layout}}" filters="{{filters}}" columns="{{columns}}" cat_slug="{{cat_slug}}" number_posts="{{number_posts}}" excerpt_length="{{excerpt_length}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"][/recent_works]',
	'popup_title' => __( 'Recent Works Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Section Separator Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['sectionseparator'] = array(
	'no_preview' => true,
	'params' => array(
		'divider_candy' => array(
			'type' => 'select',
			'label' => __( 'Position of the Divider Candy', 't4p-core' ),
			'desc' => __( 'Select the position of the triangle candy', 't4p-core' ),
			'options' => array(
				'top' => 'Top',
				'bottom' => 'Bottom',
				'bottom,top' => 'Top and Bottom',
			)
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 't4p-core' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 't4p-core' ),
			'options' => $icons
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 't4p-core' ),
			'desc' => __( 'Leave blank for theme option selection.', 't4p-core' )
		),
		'border' => array(
			'std' => '1px',
			'type' => 'text',
			'label' => __( 'Border Size', 't4p-core' ),
			'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' ),
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'Controls the border color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color of Divider Candy', 't4p-core' ),
			'desc' => __( 'Controls the background color of the triangle. Leave blank for theme option selection.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[section_separator divider_candy="{{divider_candy}}" icon="{{icon}}" icon_color="{{iconcolor}}" bordersize="{{border}}" bordercolor="{{bordercolor}}" backgroundcolor="{{backgroundcolor}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Section Separator Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Separator Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(

		'style_type' => array(
			'type' => 'select',
			'label' => __( 'Style', 't4p-core' ),
			'desc' => __( 'Choose the separator line style', 't4p-core' ),
			'options' => array(
				'none' => 'No Style',
				'single' => 'Single Border Solid',
				'double' => 'Double Border Solid',
				'single|dashed' => 'Single Border Dashed',
				'double|dashed' => 'Double Border Dashed',
				'single|dotted' => 'Single Border Dotted',
				'double|dotted' => 'Double Border Dotted',
				'shadow' => 'Shadow'
			)
		),
		'topmargin' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __( 'Margin Top', 't4p-core' ),
			'desc' => __( 'Spacing above the separator', 't4p-core' ),
			'options' => t4p_shortcodes_range( 100, false, false, 0 )
		),
		'bottommargin' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __( 'Margin Bottom', 't4p-core' ),
			'desc' => __( 'Spacing below the separator', 't4p-core' ),
			'options' => t4p_shortcodes_range( 100, false, false, 0 )
		),
		'sepcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Separator Color', 't4p-core' ),
			'desc' => __( 'Controls the separator color. Leave blank for theme option selection.', 't4p-core' )
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 't4p-core' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 't4p-core' ),
			'options' => $icons
		),			
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Separator Width', 't4p-core' ),
			'desc' => __( 'In pixels (px or %), ex: 1px, ex: 50%. Leave blank for full width.', 't4p-core' ),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[separator style_type="{{style_type}}" top_margin="{{topmargin}}" bottom_margin="{{bottommargin}}"  sep_color="{{sepcolor}}" icon="{{icon}}" width="{{width}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Separator Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Sharing Box Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['sharingbox'] = array(
	'no_preview' => true,
	'params' => array(
		'tagline' => array(
			'std' => 'Share This',
			'type' => 'text',
			'label' => __( 'Tagline', 't4p-core' ),
			'desc' => 'The title tagline that will display'
		),
		'taglinecolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Tagline Color', 't4p-core' ),
			'desc' => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core')
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color. Leave blank for theme option selection.', 't4p-core')
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 't4p-core' ),
			'desc' => 'The post title that will be shared'
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link', 't4p-core' ),
			'desc' => 'The link that will be shared'
		),
		'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Description', 't4p-core' ),
			'desc' => 'The description that will be shared'
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link to Share', 't4p-core' ),
			'desc' => ''
		),
		'iconboxed' => array(
			'type' => 'select',
			'label' => __( 'Boxed Social Icons', 't4p-core' ),
			'desc' => __( 'Choose to get a boxed icons. Choose default for theme option selection.', 't4p-core' ),
			'options' => $reverse_choices_with_default
		),
		'iconboxedradius' => array(
			'std' => '3px',
			'type' => 'text',
			'label' => __( 'Social Icon Box Radius', 't4p-core' ),
			'desc' => __( 'Choose the radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 't4p-core' ),
		),	
		'iconcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Colors', 't4p-core' ),
			'desc' => __( 'Specify the color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
		),
		'boxcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Box Colors', 't4p-core' ),
			'desc' => __( 'Specify the box color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
		),
		'icontooltip' => array(
			'type' => 'select',
			'label' => __( 'Social Icon Tooltip Position', 't4p-core' ),
			'desc' => __( 'Choose the display position for tooltips. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'Right' => 'Right',
			)
		),		
		'pinterest_image' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __( 'Choose Image to Share on Pinterest', 't4p-core' ),
			'desc' => ''
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[sharing tagline="{{tagline}}" tagline_color="{{taglinecolor}}" title="{{title}}" link="{{link}}" description="{{description}}" pinterest_image="{{pinterest_image}}" icons_boxed="{{iconboxed}}" icons_boxed_radius="{{iconboxedradius}}" box_colors="{{boxcolor}}" icon_colors="{{iconcolor}}" tooltip_placement="{{icontooltip}}" backgroundcolor="{{backgroundcolor}}" class="{{class}}" id="{{id}}"][/sharing]',
	'popup_title' => __( 'Sharing Box Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['slider'] = array(
	'params' => array(
		'size' => array(
			'std' => '100%',
			'type' => 'size',
			'label' => __( 'Image Size (Width/Height)', 't4p-core' ),
			'desc' => __( 'Width and Height in percentage (%) or pixels (px)', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[slider width="{{size_width}}" height="{{size_height}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/slider]', // as there is no wrapper shortcode
	'popup_title' => __( 'Slider Shortcode', 't4p-core' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'slider_type' => array(
				'type' => 'select',
				'label' => __( 'Slide Type', 't4p-core' ),
				'desc' => 'Choose a video or image slide',
				'options' => array(
					'image' => 'Image',
					'video' => 'Video'
				)
			),
			'video_content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __( 'Video Shortcode or Video Embed Code', 't4p-core' ),
				'desc' => 'Click the Youtube or Vimeo Shortcode button below then enter your unique video ID, or copy and paste your video embed code.<a href=\'[youtube id="Enter video ID (eg. RZRyQT1qedE)" width="600" height="350"]\' class="t4p-shortcodes-button t4p-add-video-shortcode">Insert Youtube Shortcode</a><a href=\'[vimeo id="Enter video ID (eg. 78439312)" width="600" height="350"]\' class="t4p-shortcodes-button t4p-add-video-shortcode">Insert Vimeo Shortcode</a>'
			),
			'image_content' => array(
				'std' => '',
				'type' => 'uploader',
				'label' => __( 'Slide Image', 't4p-core' ),
				'desc' => 'Upload an image to display in the slide'
			),
			'image_url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Full Image Link or External Link', 't4p-core' ),
				'desc' => 'Add the url of where the image will link to. If lightbox option is enabled,and you don\'t add the full image link, lightbox will open slide image'
			),
			'image_target' => array(
				'type' => 'select',
				'label' => __( 'Link Target', 't4p-core' ),
				'desc' => __( '_self = open in same window <br /> _blank = open in new window', 't4p-core' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'image_lightbox' => array(
				'type' => 'select',
				'label' => __( 'Lighbox', 't4p-core' ),
				'desc' => __( 'Show image in Lightbox', 't4p-core' ),
				'options' => $choices
			),
		),
		'shortcode' => '[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]',
		'clone_button' => __( 'Add New Slide', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Social Links Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['sociallinks'] = array(
	'no_preview' => true,
	'params' => array(
		'iconboxed' => array(
			'type' => 'select',
			'label' => __( 'Boxed Social Icons', 't4p-core' ),
			'desc' => __( 'Choose to get a boxed icons. Choose default for theme option selection.', 't4p-core' ),
			'options' => $reverse_choices_with_default
		),
		'iconboxedradius' => array(
			'std' => '3px',
			'type' => 'text',
			'label' => __( 'Social Icon Box Radius', 't4p-core' ),
			'desc' => __( 'Choose the radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 't4p-core' ),
		),
		'iconcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Colors', 't4p-core' ),
			'desc' => __( 'Specify the color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA.  Leave blank for theme option selection.', 't4p-core' ),
		),
		'boxcolor' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Social Icon Custom Box Colors', 't4p-core' ),
			'desc' => __( 'Specify the box color of social icons. Use one for all or separate by | symbol. 
ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
		),
		'icontooltip' => array(
			'type' => 'select',
			'label' => __( 'Social Icon Tooltip Position', 't4p-core' ),
			'desc' => __( 'Choose the display position for tooltips. Choose default for theme option selection.', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'Right' => 'Right',
			)
		),			
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Facebook Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Facebook link', 't4p-core' ),
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Twitter Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Twitter link', 't4p-core' ),
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Dribbble Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Dribbble link', 't4p-core' ),
		),
		'google' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Google+ Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Google+ link', 't4p-core' ),
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'LinkedIn Link', 't4p-core' ),
			'desc' => __( 'Insert your custom LinkedIn link', 't4p-core' ),
		),
		'blogger' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Blogger Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Blogger link', 't4p-core' ),
		),
		'tumblr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Tumblr Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Tumblr link', 't4p-core' ),
		),
		'reddit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Reddit Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Reddit link', 't4p-core' ),
		),
		'yahoo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Yahoo Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Yahoo link', 't4p-core' ),
		),
		'deviantart' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Deviantart Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Deviantart link', 't4p-core' ),
		),
		'vimeo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Vimeo Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Vimeo link', 't4p-core' ),
		),
		'youtube' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Youtube Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Youtube link', 't4p-core' ),
		),
		'pinterest' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Pinterst Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Pinterest link', 't4p-core' ),
		),
		'rss' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'RSS Link', 't4p-core' ),
			'desc' => __( 'Insert your custom RSS link', 't4p-core' ),
		),		
		'digg' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Digg Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Digg link', 't4p-core' ),
		),
		'flickr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Flickr Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Flickr link', 't4p-core' ),
		),
		'forrst' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Forrst Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Forrst link', 't4p-core' ),
		),
		'myspace' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Myspace Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Myspace link', 't4p-core' ),
		),
		'skype' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Skype Link', 't4p-core' ),
			'desc' => __( 'Insert your custom Skype link', 't4p-core' ),
		),
		'paypal' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'PayPal Link', 't4p-core' ),
			'desc' => __( 'Insert your custom paypal link', 't4p-core' ),
		),
		'dropbox' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Dropbox Link', 't4p-core' ),
			'desc' => __( 'Insert your custom dropbox link', 't4p-core' ),
		),
		'soundcloud' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'SoundCloud Link', 't4p-core' ),
			'desc' => __( 'Insert your custom soundcloud link', 't4p-core' ),
		),
		'vk' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'VK Link', 't4p-core' ),
			'desc' => __( 'Insert your custom vk link', 't4p-core' ),
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Email Address', 't4p-core' ),
			'desc' => __( 'Insert an email address to display the email icon', 't4p-core' ),
		),
		'show_custom' => array(
			'type' => 'select',
			'label' => __( 'Show Custom Social Icon', 't4p-core' ),
			'desc' => __( 'Show the custom social icon specified in Theme Options', 't4p-core' ),
			'options' => $reverse_choices
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[social_links icons_boxed="{{iconboxed}}" icons_boxed_radius="{{iconboxedradius}}" icon_colors="{{iconcolor}}" box_colors="{{boxcolor}}" tooltip_placement="{{icontooltip}}" rss="{{rss}}" facebook="{{facebook}}" twitter="{{twitter}}" dribbble="{{dribbble}}" google="{{google}}" linkedin="{{linkedin}}" blogger="{{blogger}}" tumblr="{{tumblr}}" reddit="{{reddit}}" yahoo="{{yahoo}}" deviantart="{{deviantart}}" vimeo="{{vimeo}}" youtube="{{youtube}}" pinterest="{{pinterest}}" digg="{{digg}}" flickr="{{flickr}}" forrst="{{forrst}}" myspace="{{myspace}}" skype="{{skype}}" paypal="{{paypal}}" dropbox="{{dropbox}}" soundcloud="{{soundcloud}}" vk="{{vk}}" email="{{email}}" show_custom="{{show_custom}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Social Links Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	SoundCloud Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['soundcloud'] = array(
	'no_preview' => true,
	'params' => array(

		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'SoundCloud Url', 't4p-core' ),
			'desc' => 'The SoundCloud url, ex: http://api.soundcloud.com/tracks/139533495'
		),
		'comments' => array(
			'type' => 'select',
			'label' => __( 'Show Comments', 't4p-core' ),
			'desc' => 'Choose to display comments',
			'options' => $choices
		),
		'autoplay' => array(
			'type' => 'select',
			'label' => __( 'Autoplay', 't4p-core' ),
			'desc' => 'Choose to autoplay the track',
			'options' => $reverse_choices
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '#ff7700',
			'label' => __( 'Color', 't4p-core' ),
			'desc' => 'Select the color of the shortcode'
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __( 'Width', 't4p-core' ),
			'desc' => 'In pixels (px) or percentage (%)'
		),
		'height' => array(
			'std' => '81px',
			'type' => 'text',
			'label' => __( 'Height', 't4p-core' ),
			'desc' => 'In pixels (px)'
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[soundcloud url="{{url}}" comments="{{comments}}" auto_play="{{autoplay}}" color="{{color}}" width="{{width}}" height="{{height}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Sharing Box Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Table Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['table'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Type', 't4p-core' ),
			'desc' => __( 'Select the table style', 't4p-core' ),
			'options' => array(
				'1' => 'Style 1',
				'2' => 'Style 2',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Number of Columns', 't4p-core' ),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'1' => '1 Column',
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns',
				'5' => '5 Columns'				
			)
		)
	),
	'shortcode' => '',
	'popup_title' => __( 'Table Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['tabs'] = array(
	'no_preview' => true,
	'params' => array(
		'layout' => array(
			'type' => 'select',
			'label' => __( 'Layout', 't4p-core' ),
			'desc' => __( 'Choose the layout of the shortcode', 't4p-core' ),
			'options' => array(
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical'
			)
		),
		'justified' => array(
			'type' => 'select',
			'label' => __( 'Justify Tabs', 't4p-core' ),
			'desc' => __( 'Choose to get tabs stretched over full shortcode width.', 't4p-core' ),
			'options' => $choices
		),		
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background tab color.  Leave blank for theme option selection.', 't4p-core' ),
		),
		'inactivecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Inactive Color', 't4p-core' ),
			'desc' => __( 'Controls the inactive tab color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),

	'shortcode' => '[t4p_tabs layout="{{layout}}" justified="{{justified}}" backgroundcolor="{{backgroundcolor}}" inactivecolor="{{inactivecolor}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/t4p_tabs]',
	'popup_title' => __( 'Insert Tab Shortcode', 't4p-core' ),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => __( 'Tab Title', 't4p-core' ),
				'desc' => __( 'Title of the tab', 't4p-core' ),
			),
			'content' => array(
				'std' => 'Tab Content',
				'type' => 'textarea',
				'label' => __( 'Tab Content', 't4p-core' ),
				'desc' => __( 'Add the tabs content', 't4p-core' )
			)
		),
		'shortcode' => '[t4p_tab title="{{title}}"]{{content}}[/t4p_tab]',
		'clone_button' => __( 'Add Tab', 't4p-core' )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Tagline Box Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['taglinebox'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'shadow' => array(
			'type' => 'select',
			'label' => __( 'Shadow', 't4p-core' ),
			'desc' => __( 'Show the shadow below the box', 't4p-core' ),
			'options' => $reverse_choices
		),
		'shadowopacity' => array(
			'type' => 'select',
			'label' => __( 'Shadow Opacity', 't4p-core' ),
			'desc' => __( 'Choose the opacity of the shadow', 't4p-core' ),
			'options' => $dec_numbers
		),
		'border' => array(
			'std' => '1px',
			'type' => 'text',
			'label' => __( 'Border Size', 't4p-core' ),
			'desc' => __( 'In pixels (px), ex: 1px', 't4p-core' ),
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Color', 't4p-core' ),
			'desc' => __( 'Controls the border color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'highlightposition' => array(
			'type' => 'select',
			'label' => __( 'Highlight Border Position', 't4p-core' ),
			'desc' => __( 'Choose the position of the highlight. This border highlight is from theme options primary color and does not take the color from border color above', 't4p-core' ),
			'options' => array(
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'right' => 'Right',
				'none' => 'None',
			)
		),
		'contentalignment' => array(
			'type' => 'select',
			'label' => __( 'Content Alignment', 't4p-core' ),
			'desc' => __( 'Choose how the content should be displayed.', 't4p-core' ),
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'Right',
			)
		),		
		'button' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button Text', 't4p-core' ),
			'desc' => __( 'Insert the text that will display in the button', 't4p-core' ),
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link', 't4p-core' ),
			'desc' => __( 'The url the button will link to', 't4p-core')
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Link Target', 't4p-core' ),
			'desc' => __( '_self = open in same window <br /> _blank = open in new window', 't4p-core' ),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'buttonsize' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 't4p-core' ),
			'desc' => __( 'Select the button\'s size.', 't4p-core' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
				'xlarge' => 'XLarge',
			)
		),
		'buttontype' => array(
			'type' => 'select',
			'label' => __( 'Button Type', 't4p-core' ),
			'desc' => __( 'Select the button\'s type.', 't4p-core' ),
			'options' => array(
				'flat' => 'Flat',
				'3d' => '3D',
			)
		),
		'buttonshape' => array(
			'type' => 'select',
			'label' => __( 'Button Shape', 't4p-core' ),
			'desc' => __( 'Select the button\'s shape.', 't4p-core' ),
			'options' => array(
				'square' => 'Square',
				'pill' => 'Pill',
				'round' => 'Round',
			)
		),		
		'buttoncolor' => array(
			'type' => 'select',
			'label' => __( 'Button Color', 't4p-core' ),
			'desc' => __( 'Choose the button color <br />Default uses theme option selection', 't4p-core' ),
			'options' => array(
				'' => 'Default',
				'green' => 'Green',
				'darkgreen' => 'Dark Green',
				'orange' => 'Orange',
				'blue' => 'Blue',
				'red' => 'Red',
				'pink' => 'Pink',
				'darkgray' => 'Dark Gray',
				'lightgray' => 'Light Gray',
			)
		),
		'title' => array(
			'type' => 'textarea',
			'label' => __( 'Tagline Title', 't4p-core' ),
			'desc' => __( 'Insert the title text', 't4p-core' ),
			'std' => 'Title'
		),
		'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Tagline Description', 't4p-core' ),
			'desc' => __( 'Insert the description text', 't4p-core' ),
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', 't4p-core' ),
			'desc' => __( 'Select the type on animation to use on the shortcode', 't4p-core' ),
			'options' => array(
				'0' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', 't4p-core' ),
			'desc' => __( 'Select the incoming direction for the animation', 't4p-core' ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 't4p-core' ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 't4p-core' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[tagline_box backgroundcolor="{{backgroundcolor}}" shadow="{{shadow}}" shadowopacity="{{shadowopacity}}" border="{{border}}" bordercolor="{{bordercolor}}" highlightposition="{{highlightposition}}" content_alignment="{{contentalignment}}" link="{{url}}" linktarget="{{target}}" button_size="{{buttonsize}}" button_shape="{{buttonshape}}" button_type="{{buttontype}}" buttoncolor="{{buttoncolor}}" button="{{button}}" title="{{title}}" description="{{description}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" class="{{class}}" id="{{id}}"][/tagline_box]',
	'popup_title' => __( 'Insert Tagline Box Shortcode', 't4p-core')
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonials Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['testimonials'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 't4p-core' ),
			'desc' => __( 'Controls the background color.  Leave blank for theme option selection.', 't4p-core' ),
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Text Color', 't4p-core' ),
			'desc' => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[testimonials backgroundcolor="{{backgroundcolor}}" textcolor="{{textcolor}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/testimonials]',
	'popup_title' => __( 'Insert Testimonials Shortcode', 't4p-core' ),

	'child_shortcode' => array(
		'params' => array(
			'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Name', 't4p-core' ),
				'desc' => __( 'Insert the name of the person.', 't4p-core' ),
			),
			'avatar' => array(
				'type' => 'select',
				'label' => __( 'Avatar', 't4p-core' ),
				'desc' => __( 'Choose which kind of Avatar to be displayed.', 't4p-core' ),
				'options' => array(
					'image' => 'Image',
					'none' => 'None'
				)
			),
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Custom Avatar', 't4p-core' ),
				'desc' => __( 'Upload a custom avatar image.', 't4p-core' ),
			),			
			'company' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Company', 't4p-core' ),
				'desc' => __( 'Insert the name of the company.', 't4p-core' ),
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Link', 't4p-core' ),
				'desc' => __( 'Add the url the company name will link to.', 't4p-core' ),
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Target', 't4p-core' ),
				'desc' => __( '_self = open in same window <br />_blank = open in new window.', 't4p-core' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __( 'Testimonial Content', 't4p-core' ),
				'desc' => __( 'Add the testimonial content', 't4p-core' ),
			)
		),
		'shortcode' => '[testimonial name="{{name}}" avatar="{{avatar}}" image="{{image}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
		'clone_button' => __( 'Add Testimonial', 't4p-core' )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Title Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(
		'size' => array(
			'type' => 'select',
			'label' => __( 'Title Size', 't4p-core' ),
			'desc' => __( 'Choose the title size, H1-H6', 't4p-core' ),
			'options' => t4p_shortcodes_range( 6, false )
		),
		'contentalign' => array(
			'type' => 'select',
			'label' => __( 'Title Alignment', 't4p-core' ),
			'desc' => __( 'Choose to align the heading left or right.', 't4p-core' ),
			'options' => array(
				'left' => 'Left',
				'right' => 'Right'
			)
		),
		'separator' => array(
			'type' => 'select',
			'label' => __( 'Separator', 't4p-core' ),
			'desc' => __( 'Choose the kind of the title separator you want to use.', 't4p-core' ),
			'options' => array(
				'single' => 'Single',
				'double' => 'Double',
				'underline' => 'Underline',			
			)
		),			
		'sepstyle' => array(
			'type' => 'select',
			'label' => __( 'Separator Style', 't4p-core' ),
			'desc' => __( 'Choose the style of the title separator.', 't4p-core' ),
			'options' => array(
				'solid' => 'Solid',
				'dashed' => 'Dashed',
				'dotted' => 'Dotted',			
			)
		),		
		'sepcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Separator Color', 't4p-core' ),
			'desc' => __( 'Controls the separator color.  Leave blank for theme option selection.', 't4p-core')
		),		
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Title', 't4p-core' ),
			'desc' => __( 'Insert the title text', 't4p-core' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[title size="{{size}}" content_align="{{contentalign}}" style_type="{{separator}} {{sepstyle}}" sep_color="{{sepcolor}}" class="{{class}}" id="{{id}}"]{{content}}[/title]',
	'popup_title' => __( 'Sharing Box Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Toggles Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['toggles'] = array(
	'no_preview' => true,
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),	
	),
	'shortcode' => '[accordian class="{{class}}" id="{{id}}"]{{child_shortcode}}[/accordian]',
	'popup_title' => __( 'Insert Toggles Shortcode', 't4p-core' ),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Title', 't4p-core' ),
				'desc' => __( 'Insert the toggle title', 't4p-core' ),
			),
			'open' => array(
				'type' => 'select',
				'label' => __( 'Open by Default', 't4p-core' ),
				'desc' => __( 'Choose to have the toggle open when page loads', 't4p-core' ),
				'options' => $reverse_choices
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __( 'Toggle Content', 't4p-core' ),
				'desc' => __( 'Insert the toggle content', 't4p-core' ),
			)
		),
		'shortcode' => '[toggle title="{{title}}" open="{{open}}"]{{content}}[/toggle]',
		'clone_button' => __( 'Add Toggle', 't4p-core')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Tooltip Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Tooltip Text', 't4p-core' ),
			'desc' => __( 'Insert the text that displays in the tooltip', 't4p-core' )
		),
		'placement' => array(
			'type' => 'select',
			'label' => __( 'Tooltip Position', 't4p-core' ),
			'desc' => __( 'Choose the display position.', 't4p-core' ),
			'options' => array(
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'Right' => 'Right',
			)
		),
		'trigger' => array(
			'type' => 'select',
			'label' => __( 'Tooltip Trigger', 't4p-core' ),
			'desc' => __( 'Choose action to trigger the tooltip.', 't4p-core' ),
			'options' => array(
				'hover' => 'Hover',
				'click' => 'Click',
			)
		),			
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 't4p-core' ),
			'desc' => __( 'Insert the text that will activate the tooltip hover', 't4p-core' )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[tooltip title="{{title}}" placement="{{placement}}" trigger="{{trigger}}" class="{{class}}" id="{{id}}"]{{content}}[/tooltip]',
	'popup_title' => __( 'Tooltip Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vimeo Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['vimeo'] = array(
	'no_preview' => true,
	'params' => array(

		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Video ID', 't4p-core' ),
			'desc' => __( 'For example the Video ID for <br />https://vimeo.com/78439312 is 78439312', 't4p-core' )
		),
		'width' => array(
			'std' => '600',
			'type' => 'text',
			'label' => __( 'Width', 't4p-core' ),
			'desc' => __( 'In pixels but only enter a number, ex: 600', 't4p-core' )
		),
		'height' => array(
			'std' => '350',
			'type' => 'text',
			'label' => __( 'Height', 't4p-core' ),
			'desc' => __( 'In pixels but enter a number, ex: 350', 't4p-core' )
		),
		'autoplay' => array(
			'type' => 'select',
			'label' => __( 'Autoplay Video', 't4p-core' ),
			'desc' =>  __( 'Set to yes to make video autoplaying', 't4p-core' ),
			'options' => $reverse_choices
		),
		'apiparams' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'AdditionalAPI Parameter', 't4p-core' ),
			'desc' => __( 'Use additional API parameter, for example &title=0 to disable title on video. VimeoPlus account may be required.', 't4p-core' )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[vimeo id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}" api_params="{{apiparams}}" class="{{class}}"]',
	'popup_title' => __( 'Vimeo Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Woo Featured Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['woofeatured'] = array(
	'no_preview' => true,
	'params' => array(

		'info' => array(
			'std' => 'No settings required. Insert the shortcode and your featured products will be pulled. Featured products are products that you have "Starred" in the WooCommerce settings.',
			'type' => 'info'
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[featured_products_slider class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Woocommerce Featured Products Slider Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	Woo Products Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['wooproducts'] = array(
	'params' => array(

		'picture_size' => array(
			'type' => 'select',
			'label' => __( 'Picture Size', 't4p-core' ),
			'desc' => __( 'fixed = width and height will be fixed <br />auto = width and height will adjust to the image.', 't4p-core' ),
			'options' => array(
				'fixed' => 'Fixed',
				'auto' => 'Auto'
			)
		),
		'cat_slug' => array(
			'type' => 'multiple_select',
			'label' => __( 'Categories', 't4p-core' ),
			'desc' => __( 'Select a category or leave blank for all', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'product_cat' )
		),
		'number_posts' => array(
			'std' => 5,
			'type' => 'select',
			'label' => __( 'Number of Products', 't4p-core' ),
			'desc' => 'Select the number of products to display',
			'options' => t4p_shortcodes_range( 20, false )
		),
		'show_cats' => array(
			'type' => 'select',
			'label' => __( 'Show Categories', 't4p-core' ),
			'desc' => 'Choose to show or hide the categories',
			'options' => $reverse_choices
		),
		'show_price' => array(
			'type' => 'select',
			'label' => __( 'Show Price', 't4p-core' ),
			'desc' => 'Choose to show or hide the price',
			'options' => $reverse_choices
		),
		'show_buttons' => array(
			'type' => 'select',
			'label' => __( 'Show Buttons', 't4p-core' ),
			'desc' => 'Choose to show or hide the icon buttons',
			'options' => $reverse_choices
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),			
	),
	'shortcode' => '[products_slider picture_size="{{picture_size}}" cat_slug="{{cat_slug}}" number_posts="{{number_posts}}" show_cats="{{show_cats}}" show_price="{{show_price}}" show_buttons="{{show_buttons}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Woocommerce Products Slider Shortcode', 't4p-core' ),
	'no_preview' => true,
);

/*-----------------------------------------------------------------------------------*/
/*	Youtube Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['youtube'] = array(
	'no_preview' => true,
	'params' => array(

		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Video ID', 't4p-core' ),
			'desc' => 'For example the Video ID for <br />http://www.youtube.com/RZRyQT1qedE is RZRyQT1qedE'
		),
		'width' => array(
			'std' => '600',
			'type' => 'text',
			'label' => __( 'Width', 't4p-core' ),
			'desc' => 'In pixels but only enter a number, ex: 600'
		),
		'height' => array(
			'std' => '350',
			'type' => 'text',
			'label' => __( 'Height', 't4p-core' ),
			'desc' => 'In pixels but only enter a number, ex: 350'
		),
		'autoplay' => array(
			'type' => 'select',
			'label' => __( 'Autoplay Video', 't4p-core' ),
			'desc' =>  __( 'Set to yes to make video autoplaying', 't4p-core' ),
			'options' => $reverse_choices
		),
		'apiparams' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'AdditionalAPI Parameter', 't4p-core' ),
			'desc' => 'Use additional API parameter, for example &rel=0 to disable related videos'
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),		
	),
	'shortcode' => '[youtube id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}" api_params="{{apiparams}}" class="{{class}}"]',
	'popup_title' => __( 'Youtube Shortcode', 't4p-core' )
);

/*-----------------------------------------------------------------------------------*/
/*	T4P Slider Config
/*-----------------------------------------------------------------------------------*/

$t4p_shortcodes['t4pslider'] = array(
	'no_preview' => true,
	'params' => array(
		'name' => array(
			'type' => 'select',
			'label' => __( 'Slider Name', 't4p-core' ),
			'desc' => __( 'This is the shortcode name that can be used in the post content area. It is usually all lowercase and contains only letters, numbers, and hyphens. ex: "t4pslider_slidernamehere"', 't4p-core' ),
			'options' => t4p_shortcodes_categories( 'slide-page' )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 't4p-core' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 't4p-core' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' )
		),
	),
	'shortcode' => '[t4pslider id="{{id}}" class="{{class}}" name="{{name}}"][/t4pslider]',
	'popup_title' => __( 'T4P Slider Shortcode', 't4p-core' )
);