<?php
class T4PSC_SharingBox {

    public static $args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

        add_filter( 't4p_attr_sharingbox-shortcode', array( $this, 'attr' ) );
        add_filter( 't4p_attr_sharingbox-shortcode-tagline', array( $this, 'tagline_attr' ) );
        add_filter( 't4p_attr_sharingbox-shortcode-social-networks', array( $this, 'social_networks_attr' ) );
        add_filter( 't4p_attr_sharingbox-shortcode-icon', array( $this, 'icon_attr' ) );

        add_shortcode( 'sharing', array( $this, 'render' ) );

    }

    /**
     * Render the parent shortcode
     * @param  array $args    Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render( $args, $content = '') {
    	global $smof_data;
		global $evl_options;
		
		$defaults = T4PCore_Plugin::set_shortcode_defaults(
			array(
				'class' 				=> '',
				'id' 					=> '',			
				'backgroundcolor' 		=> strtolower( $smof_data['sharing_box_bg_color'] ).strtolower( $evl_options['evl_shortcode_sharing_box_bg_color'] ),
				'description'			=> '',
				'icon_colors'			=> strtolower( $smof_data['sharing_social_links_icon_color'] ).strtolower( $evl_options['evl_sharing_box_icon_color'] ),
				'box_colors'			=> strtolower( $smof_data['sharing_social_links_box_color'] ).strtolower( $evl_options['evl_sharing_box_box_color'] ),	
				'icons_boxed'			=> strtolower( $smof_data['sharing_social_links_boxed'] ).strtolower( $evl_options['evl_sharing_box_control_color'] ),
				'icons_boxed_radius'	=> strtolower( $smof_data['sharing_social_links_boxed_radius'] ).strtolower( $evl_options['evl_sharing_box_radius'] ),		
				'link' 					=> '',
				'pinterest_image' 		=> '',
				'social_networks'		=> $this->get_theme_options_settings(),
				'tagline' 				=> __( 'Share This', 't4p-core' ),
				'tagline_color'			=> strtolower( $smof_data['sharing_box_tagline_text_color'] ).strtolower( $evl_options['evl_shortcode_sharing_box_tagline_text_color'] ),
				'title' 				=> '',
				'tooltip_placement'		=> strtolower( $smof_data['sharing_social_links_tooltip_placement'] ).strtolower( $evl_options['evl_sharing_box_tooltip_position'] ),
			), $args
		);	

        extract( $defaults );

        self::$args = $defaults;

		$social_networks = explode( '|', $social_networks );	
		
		$icon_colors = explode( '|', $icon_colors );
		$num_of_icon_colors = count( $icon_colors );
		
		$box_colors = explode( '|', $box_colors );
		$num_of_box_colors = count( $box_colors );
		
		$args['icons_boxed_radius'] = isset($args['icons_boxed_radius']) ? $args['icons_boxed_radius'] : '';
		
		$icons = '';

		if( isset( $smof_data['social_sorter'] ) && $smof_data['social_sorter'] ) {
			$order = $smof_data['social_sorter'];
			$ordered_array = explode(',', $order);
			
			if( isset( $ordered_array ) && $ordered_array && is_array( $ordered_array ) ) {
				foreach( $social_networks as $reorder_social_network ) {
					$social_networks_old[$reorder_social_network] = $reorder_social_network;
				}
				$social_networks = array();
				foreach( $ordered_array as $key => $field_order ) {
					$field_order_number = str_replace(  'social_sorter_', '', $field_order );
					$find_the_field = $smof_data['social_sorter_' . $field_order_number];
					$field_name = str_replace( '_link', '', $smof_data['social_sorter_' . $field_order_number] );
					
					if( $field_name == 'google' ) {
						$field_name = 'googleplus';
					} elseif($field_name == 'email' ) {
						$field_name = 'mail';
					}

					if( ! isset( $social_networks_old[$field_name] ) ) {
						continue;
					}

					$social_networks[] = $social_networks_old[$field_name];
				}
			}
		}


		for( $i = 0; $i < count( $social_networks ); $i++ ) {
			if( $num_of_icon_colors == 1 ) {
				$icon_colors[$i] = $icon_colors[0];
			}
			
			
			if( $num_of_box_colors == 1 ) {
				$box_colors[$i] = $box_colors[0];
			}
			
			$icon_options = array( 
				'social_network' 	=> $social_networks[$i], 
				'icon_color' 		=> $i < count( $icon_colors ) ? $icon_colors[$i] : '',
				'box_color' 		=> $i < count( $box_colors ) ? $box_colors[$i] : '',
			);
		
			$icons .= sprintf( '<span class="t4p-icon-holder"><a %s></a></span>', T4PCore_Plugin::attributes( 'sharingbox-shortcode-icon', $icon_options ) );
		}
		
		
		
        $html = sprintf( '<style type="text/css">.t4p-sharing-box .t4p-icon-holder, .t4p-sharing-box .t4p-social-networks.boxed-icons a:after {border-radius:%s;}</style><div %s><h4 %s>%s</h4><div %s>%s</div></div>', $args['icons_boxed_radius'], T4PCore_Plugin::attributes( 'sharingbox-shortcode' ), T4PCore_Plugin::attributes( 'sharingbox-shortcode-tagline' ), 
        				 $tagline, T4PCore_Plugin::attributes( 'sharingbox-shortcode-social-networks' ), $icons );
				
		
		return $html;
		
    }

    function attr() {

        $attr = array();

        $attr['class'] = 'share-box t4p-sharing-box';
        
		if( self::$args['icons_boxed'] == 'yes' ) {
        	$attr['class'] .= ' boxed-icons';
        }
        
        if( self::$args['backgroundcolor'] ) {
        	$attr['style'] = sprintf( 'background-color:%s;', self::$args['backgroundcolor'] );
        }

        if( self::$args['class'] ) {
            $attr['class'] .= ' ' . self::$args['class'];
        }

        if( self::$args['id'] ) {
            $attr['id'] = self::$args['id'];
        }

		$attr['data-title'] = self::$args['title'];
		$attr['data-description'] = self::$args['description'];
		$attr['data-link'] = self::$args['link'];
		$attr['data-image'] = self::$args['pinterest_image'];

        return $attr;

    }
       
	function tagline_attr() {

		$attr['class'] = 'tagline';

		if( self::$args['tagline_color'] ) {
			$attr['style'] = sprintf( 'color:%s !important;', self::$args['tagline_color'] );
		}

        return $attr;

    }     
    
	function social_networks_attr() {

		$attr['class'] = 't4p-social-networks';
		
		if( self::$args['icons_boxed'] == 'yes' ) {
        	$attr['class'] .= ' boxed-icons';
        }		

        return $attr;

    }
    
	function icon_attr( $args ) {
		global $smof_data;
	
		$description = self::$args['description'];
		$link = self::$args['link'];
		$title = self::$args['title'];	

		$attr['class'] = sprintf( 't4p-social-network-icon t4p-tooltip t4p-%s t4p-icon-%s', $args['social_network'], $args['social_network'] );	
	
		$soical_link = '';
		switch( $args['social_network'] ) {
			case 'facebook':
				$soical_link = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;='.$link.'&p&#91;images&#93;&#91;0&#93;=http://www.gravatar.com/avatar/2f8ec4a9ad7a39534f764d749e001046.png&p&#91;title&#93;='.$title;
				break;
			case 'twitter':
				$soical_link = 'http://twitter.com/home?status='.$title.' '.$link;
				break;
			case 'linkedin':
				$soical_link = 'http://linkedin.com/shareArticle?mini=true&amp;url='.$link.'&amp;title='.$title;
				break;
			case 'reddit':
				$soical_link = 'http://reddit.com/submit?url='.$link.'&amp;title='.$title;
				break;
			case 'tumblr':
				$soical_link = 'http://www.tumblr.com/share/link?url='.urlencode($link).'&amp;name='.urlencode($title).'&amp;description='.urlencode($description);
				break;
			case 'googleplus':
				$soical_link = 'https://plus.google.com/share?url='.$link.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;';
				break;
			case 'pinterest':
				$soical_link = 'http://pinterest.com/pin/create/button/?url='.urlencode($link).'&amp;description='.urlencode($title).'&amp;media='.urlencode(self::$args['pinterest_image']);
				break;
			case 'mail':
				$soical_link = 'mailto:?subject='.$title.'&amp;body='.$link;
				break;
		}
		
		$attr['href'] = $soical_link;
		$attr['target'] = '_blank';
		
		if( $smof_data['nofollow_social_links'] ) {
			$attr['rel'] = 'nofollow';
		}

		$attr['style'] = '';
		if( $args['icon_color'] ) {
			$attr['style'] = sprintf( 'color:%s;', $args['icon_color'] );
		}
		
		if( isset( self::$args['icons_boxed'] ) && self::$args['icons_boxed'] == 'yes' && 
			$args['box_color']
		) {
			$attr['style'] .= sprintf( 'background-color:%s;border-color:%s;', $args['box_color'], $args['box_color'] );	
		}		
		
		if( self::$args['icons_boxed'] == 'yes' &&
			self::$args['icons_boxed_radius'] || self::$args['icons_boxed_radius'] == '0'
		) {
			if( self::$args['icons_boxed_radius'] == 'round' ) {
				self::$args['icons_boxed_radius'] = '50%';
			}
		
			$attr['style'] .= sprintf( 'border-radius:%s;', self::$args['icons_boxed_radius'] );
		}			
		
		$attr['data-placement'] = self::$args['tooltip_placement'];
		$attr['data-title'] = ucfirst( $args['social_network'] );
		if( self::$args['tooltip_placement'] != 'none' ) {
			$attr['data-toggle'] = 'tooltip';
		}	

        return $attr;

    } 
    
    function get_theme_options_settings() {
    	global $smof_data;	
		global $evl_options;
    	$social_media = '';
    	
			if( $smof_data['sharing_facebook'] || $evl_options['evl_sharing_facebook']) {
				$social_media .= 'facebook|';
			}

			if( $smof_data['sharing_twitter'] || $evl_options['evl_sharing_twitter'] ) {
				$social_media .= 'twitter|';
			}

			if( $smof_data['sharing_linkedin'] || $evl_options['evl_sharing_linkedin']) {
				$social_media .= 'linkedin|';
			}
			
			if( $smof_data['sharing_reddit'] || $evl_options['evl_sharing_reddit']) {
				$social_media .= 'reddit|';
			}
			
			if( $smof_data['sharing_tumblr'] || $evl_options['evl_sharing_tumblr']) {
				$social_media .= 'tumblr|';
			}
			
			if( $smof_data['sharing_google'] || $evl_options['evl_sharing_google']) {
				$social_media .= 'googleplus|';
			}
			
			if( $smof_data['sharing_pinterest'] || $evl_options['evl_sharing_pinterest'] ) {
				$social_media .= 'pinterest|';
			}

			if( $smof_data['sharing_email'] || $evl_options['evl_sharing_email']) {
				$social_media .= 'mail|';
			}
			
			$social_media = rtrim( $social_media, '|' );
			
			return $social_media;
    }
}

new T4PSC_SharingBox();