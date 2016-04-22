<?php
class T4PSC_Popover {

	private $popover_counter = 1;

    public static $args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

	add_filter( 't4p_attr_popover-shortcode', array( $this, 'attr' ) );
	add_shortcode('popover', array( $this, 'render' ) );

    }

    /**
     * Render the shortcode
     * @param  array $args     Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
	function render( $args, $sc_content = '') {
		global $smof_data;
		global $evl_options;

		$defaults = T4PCore_Plugin::set_shortcode_defaults(
			array(
				'class' 			=> '',
				'id' 				=> '',
				'animation' 		=> false,
				'content'			=> '',
				'content_bg_color'	=> $smof_data['popover_content_bg_color'].$evl_options['evl_shortcode_popover_content_bg_color'],
				'delay'				=> '',
				'placement' 		=> strtolower( $smof_data['popover_placement'] ).strtolower( $evl_options['evl_shortcode_popover_position'] ),
				'title' 			=> '',
				'title_bg_color'	=> $smof_data['popover_heading_bg_color'].$evl_options['evl_shortcode_popover_heading_bg_color'],
				'bordercolor'		=> $smof_data['popover_border_color'].$evl_options['evl_shortcode_popover_border_color'],
				'textcolor'			=> $smof_data['popover_text_color'].$evl_options['evl_shortcode_popover_text_color'],
				'trigger'			=> 'click',
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;
		
		if( $placement == 'bottom' ) {
			$arrow_color = $title_bg_color;
		} else {
			$arrow_color = $content_bg_color;
		}
		
		$styles = sprintf( '<style>.popover-%s.%s .arrow{border-%s-color:%s;}.popover-%s{border-color:%s;}.popover{background-color:%s;}.popover-%s .popover-title{background-color:%s;color:%s;border-color:%s;}.popover-%s .popover-content{background-color:%s;color:%s;}.popover-%s.%s .arrow:after{border-%s-color:%s;}</style>', 
						   $this->popover_counter, $placement, $placement, $bordercolor, $this->popover_counter, $bordercolor, $bordercolor, $this->popover_counter, $title_bg_color, $textcolor, $bordercolor, $this->popover_counter, $content_bg_color, $textcolor, $this->popover_counter, $placement, $placement, $arrow_color );
	
		$html = sprintf( '<span %s>%s%s</span>', T4PCore_Plugin::attributes( 'popover-shortcode' ), $styles, do_shortcode( $sc_content ) );

		$this->popover_counter++;

        return $html;

	}

	function attr() {

		$attr['class'] = sprintf( 't4p-popover popover-%s', $this->popover_counter );

        if( self::$args['class'] ) {
            $attr['class'] .= ' ' . self::$args['class'];
        }

        if( self::$args['id'] ) {
            $attr['id'] = self::$args['id'];
        }

		$attr['data-animation'] = self::$args['animation'];
		$attr['data-class'] = sprintf( 'popover-%s', $this->popover_counter );
		$attr['data-container'] = sprintf( 'popover-%s', $this->popover_counter );
		$attr['data-content'] = self::$args['content'];
		$attr['data-delay'] = self::$args['delay'];
		$attr['data-placement'] = strtolower( self::$args['placement'] );
		$attr['data-title'] = self::$args['title'];
		$attr['data-toggle'] = 'popover';
		$attr['data-trigger'] = self::$args['trigger'];

        return $attr;

    }

}

new T4PSC_Popover();