<?php
class T4PSC_Clients {

    public static $parent_args;
    public static $child_args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

        add_filter( 't4p_attr_clients-shortcode', array( $this, 'attr' ) );

        add_shortcode( 'clients', array( $this, 'render_parent' ) );
        add_shortcode( 'client', array( $this, 'render_child' ) );

    }

    /**
     * Render the parent shortcode
     * @param  array $args    Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render_parent( $args, $content = '') {
       
		$defaults = T4PCore_Plugin::set_shortcode_defaults(
			array(
				'class'			=> '',
				'id'			=> '',
				'picture_size' 	=> 'fixed',
			), $args
		);	

        extract( $defaults );

        self::$parent_args = $defaults;
  

		$html = sprintf( '<div %s><div %s><div %s><ul>%s</ul></div><div %s><span %s></span><span %s></span></div></div></div>', T4PCore_Plugin::attributes( 'clients-shortcode' ), 
						 T4PCore_Plugin::attributes( 'es-carousel-wrapper t4p-carousel-small clients-carousel' ), T4PCore_Plugin::attributes( 'es-carousel' ), 
						 do_shortcode($content), T4PCore_Plugin::attributes( 'es-nav' ), T4PCore_Plugin::attributes( 'es-nav-prev' ), T4PCore_Plugin::attributes( 'es-nav-next' ) );

		return $html;

    }

    function attr() {

        $attr = array();

        $attr['class'] = 't4p-clients-slider clientslider-container';

        if( self::$parent_args['class'] ) {
            $attr['class'] .= ' ' . self::$parent_args['class'];
        }

        if( self::$parent_args['picture_size'] == 'auto' ) {
            $attr['class'] .= ' picture-size-auto';
        }

        if( self::$parent_args['id'] ) {
            $attr['id'] = self::$parent_args['id'];
        }

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
				'alt'        => '',
				'image'      => '',			
				'link'       => '',
				'linktarget' => '_self',
        	), $args 
        );

        extract( $defaults );

        self::$child_args = $defaults;

        $output = sprintf( '<img src="%s" alt="%s" />', $image, $alt );

        if( $link ) {
            $output = sprintf( '<a href="%s" target="%s">%s</a>', $link, $linktarget, $output );
        }

        $html = sprintf( '<li><div %s>%s</div></li>', T4PCore_Plugin::attributes( 'image' ), $output );

        return $html;

    }

}

new T4PSC_Clients();