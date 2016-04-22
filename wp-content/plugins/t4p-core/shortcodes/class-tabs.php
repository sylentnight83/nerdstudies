<?php
class T4PSC_Tabs {

	private $tabs_counter = 1;
	private $tab_ids = array();
	private $active = false;

	public static $parent_args;
	public static $child_args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

		add_filter( 't4p_attr_tabs-shortcode', array( $this, 'attr' ) );
		add_filter( 't4p_attr_tabs-shortcode-link', array( $this, 'link_attr' ) );
		add_filter( 't4p_attr_tabs-shortcode-tab', array( $this, 'tab_attr' ) );

		add_shortcode( 'tabs', array( $this, 'render_parent' ) );
		add_shortcode( 'tab', array( $this, 'render_child' ) );

		add_shortcode( 't4p_tabs', array( $this, 't4p_tabs' ) );
		add_shortcode( 't4p_tab', array( $this, 't4p_tab' ) );

    }

    /**
     * Render the parent shortcode
     * @param  array $args     Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render_parent( $args, $content = '') {
    	global $smof_data;
		global $evl_options;

		$defaults = T4PCore_Plugin::set_shortcode_defaults(
			array(
				'class' 			=> '',
				'id' 				=> '',
				'backgroundcolor' 	=> $smof_data['tabs_bg_color'].$evl_options['evl_shortcode_tabs_bg_color'],
				'inactivecolor' 	=> $smof_data['tabs_inactive_color'].$evl_options['evl_shortcode_tabs_inactive_color'],
				'justified'			=> 'yes',
				'layout' 			=> 'horizontal',
			), $args
		);

		extract( $defaults );

		self::$parent_args = $defaults;

		unset( $this->tab_ids );

		$justified_class = '';
		if( $justified == 'yes' &&
			$layout != 'vertical'
		) {
			$justified_class = ' nav-justified';
		}
		
		$styles = sprintf( '.t4p-tabs.t4p-tabs-%s .nav-tabs li a{border-top-color:%s;background-color:%s;}', $this->tabs_counter, 
						   self::$parent_args['inactivecolor'], self::$parent_args['inactivecolor'] );	
		$styles .= sprintf( '.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a,.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a:hover,.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a:focus{background-color:%s;border-right-color:%s;}', 
							$this->tabs_counter, $this->tabs_counter, $this->tabs_counter, self::$parent_args['backgroundcolor'], self::$parent_args['backgroundcolor'] );
 		$styles .= sprintf( '.t4p-tabs.t4p-tabs-%s .nav,.t4p-tabs.t4p-tabs-%s .nav-tabs,.t4p-tabs.t4p-tabs-%s .tab-content .tab-pane{border-color:%s;}', $this->tabs_counter, $this->tabs_counter, $this->tabs_counter, self::$parent_args['inactivecolor'] );
		$styles = sprintf( '<style>%s</style>', $styles );
		
		$html = sprintf( '<div %s>%s<div %s><ul %s>', T4PCore_Plugin::attributes( 'tabs-shortcode' ), $styles, T4PCore_Plugin::attributes( 'nav' ), T4PCore_Plugin::attributes( 'nav-tabs'.$justified_class ) );

		$is_first_tab = true;
		foreach ($args as $key => $tab) {

			if( substr( $key, 0, 3 ) === "tab" ) {
				self::$parent_args['key'] = $this->tab_ids[$key] = uniqid('tab-');

				if( $is_first_tab ) {
					$html .= sprintf( '<li %s><a %s>%s</a></li>', T4PCore_Plugin::attributes( 'active' ), T4PCore_Plugin::attributes( 'tabs-shortcode-link' ), $tab );
					$is_first_tab = false;
				} else {
					$html .= sprintf( '<li><a %s>%s</a></li>', T4PCore_Plugin::attributes( 'tabs-shortcode-link' ), $tab );
				}
			}
		}
		$html .= '';
		$html .= sprintf( '</ul></div><div %s>%s</div></div>', T4PCore_Plugin::attributes( 'tab-content' ), do_shortcode($content) );

		$this->tabs_counter++;
		$this->active = false;

        return $html;

    }

	function attr() {

        $attr = array();

        $attr['class'] = sprintf( 't4p-tabs t4p-tabs-%s', $this->tabs_counter );

        if( self::$parent_args['justified'] != 'yes' ) {
			$attr['class'] .= ' nav-not-justified';
		}

        if( self::$parent_args['class'] ) {
            $attr['class'] = ' ' .self::$parent_args['class'];
        }

        if( self::$parent_args['layout'] == 'vertical' ) {
            $attr['class'] .= ' vertical-tabs';
        } else {
        	$attr['class'] .= ' horizontal-tabs';
        }

        if( self::$parent_args['id'] ) {
            $attr['id'] = self::$parent_args['id'];
        }

        return $attr;

    }

	function link_attr() {

        $attr = array();

        $attr['class'] = 'tab-link';
        $attr['href'] = '#' . self::$parent_args['key'];
        $attr['data-toggle'] = 'tab';

        return $attr;

    }

    /**
     * Render the child shortcode
     * @param  array $args     Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render_child( $args, $content = '') {

		$defaults = T4PCore_Plugin::set_shortcode_defaults(
			array(
				'id'	=> '',
			), $args
		);

		extract( $defaults );

		self::$child_args = $defaults;

		$html = sprintf( '<div %s>%s</div>', T4PCore_Plugin::attributes( 'tabs-shortcode-tab' ), do_shortcode( $content ) );

        return $html;

    }

	function tab_attr() {

		$attr = array();

		if( ! isset( $this->active ) ) {
			$this->active = false;
		}

		if( ! $this->active ) {
			$attr['class'] = 'tab-pane fade in active';
			$this->active = true;
		} else {
			$attr['class'] = 'tab-pane fade';
		}

		$attr['id'] = $this->tab_ids['tab'.self::$child_args['id']];

		return $attr;

    }

    function t4p_tabs( $atts, $content = null ) {
		$content = preg_replace('/tab\][^\[]*/','tab]', $content);
		$content = preg_replace('/^[^\[]*\[/','[', $content);

		$preg_match_all = preg_match_all( '/t4p_tab title="([^\"]+)"/i', $content, $matches );

		$tabs = '';
		if($matches[1]) {
			foreach($matches[1] as $key => $title) {
				$sanitized_title = hash("adler32", $title, false);
				$sanitized_title = str_replace('-', '_', $sanitized_title);
				$tabs .= 'tab' . $sanitized_title . '="' . $title . '" ';
			}
		}
		
		$justified = isset($atts['justified']) ? $atts['justified'] : '';
		$class = isset($atts['class']) ? $atts['class'] : '';
		$id = isset($atts['id']) ? $atts['id'] : '';

		$shortcode_wrapper = '[tabs ' . $tabs . ' layout="' . $atts['layout'] . '" justified="' . $justified . '" backgroundcolor="' . $atts['backgroundcolor'] . '" inactivecolor="' . $atts['inactivecolor'] . '" class="' . $class . '" id="' . $id . '"]';
		$shortcode_wrapper .= $content;
		$shortcode_wrapper .= '[/tabs]';

		return do_shortcode($shortcode_wrapper);
    }

    function t4p_tab( $atts, $content = null) {
		$sanitized_title = hash("adler32", $atts['title'], false);
		$sanitized_title = str_replace('-', '_', $sanitized_title);
		$shortcode_wrapper = '[tab id="' . $sanitized_title . '"]' . do_shortcode($content) . '[/tab]';

		return do_shortcode($shortcode_wrapper);
    }

}

new T4PSC_Tabs();