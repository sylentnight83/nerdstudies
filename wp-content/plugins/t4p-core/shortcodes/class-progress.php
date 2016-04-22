<?php
class T4PSC_Progressbar {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 't4p_attr_progressbar-shortcode', array( $this, 'attr' ) );
		add_filter( 't4p_attr_progressbar-shortcode-content', array( $this, 'content_attr' ) );
		add_filter( 't4p_attr_progressbar-shortcode-span', array( $this, 'span_attr' ) );
		
		add_shortcode('progress', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;
		global $evl_options;

		$defaults =	T4PCore_Plugin::set_shortcode_defaults(
			array(
				'class'				=> '',
				'id'				=> '',
				'animated_stripes'	=> 'no',
				'filledcolor' 		=> '',
				'percentage'		=> '70',
				'striped'			=> 'no',
				'textcolor'			=> '',
				'unfilledcolor' 	=> '',
				'unit' 				=> '',
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;

		if( ! $filledcolor ) {
			self::$args['filledcolor'] = $evl_options['evl_shortcode_progress_filled_color'].$smof_data['progressbar_filled_color'];
		}
		
		if( ! $textcolor ) {
			self::$args['textcolor'] = $evl_options['evl_shortcode_progress_text_color'].$smof_data['progressbar_text_color'];
		}		

		if( ! $unfilledcolor ) {
			self::$args['unfilledcolor'] = $evl_options['evl_shortcode_progress_unfilled_color'].$smof_data['progressbar_unfilled_color'];
		}
		
		$html = sprintf( '<div %s><div %s></div><span %s>%s %s%s</div>', T4PCore_Plugin::attributes( 'progressbar-shortcode' ), T4PCore_Plugin::attributes( 'progressbar-shortcode-content' ),
						  T4PCore_Plugin::attributes( 'progressbar-shortcode-span' ), $content, $percentage, $unit );

		return $html;

	}

	function attr() {
	
		$attr = array();
		
		$attr['style'] = sprintf( 'background-color:%s;', self::$args['unfilledcolor'] );

		$attr['class'] = 't4p-progressbar t4p-progress-bar progress-bar';
		
		if( self::$args['striped'] == "yes" ) {
			$attr['class'] .= ' progress-striped';
		}
		
		if( self::$args['animated_stripes'] == "yes" ) {
			$attr['class'] .= ' active';
		}			

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}

	function content_attr() {
	
		$attr = array();

		$attr['class'] = 't4p-progress progress-bar-content progress';
		
		$attr['style'] = sprintf( 'width:%s%%;background-color:%s;', 0, self::$args['filledcolor'] );

		$attr['role'] = 'progressbar';
		$attr['aria-valuemin'] = '0';
		$attr['aria-valuemax'] = '100';
		

		$attr['aria-valuenow'] = self::$args['percentage'];

		return $attr;

	}
	
	function span_attr() {
	
		$attr = array();

		$attr['class'] = 'progress-title sr-only';
		
		$attr['style'] = sprintf( 'color:%s;', self::$args['textcolor'] );

		return $attr;

	}	

}

new T4PSC_Progressbar();