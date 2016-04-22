<?php

class T4PSC_Button {

    private $button_counter = 1;
    public static $args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

        add_filter('t4p_attr_button-shortcode', array($this, 'attr'));
        add_filter('t4p_attr_button-shortcode-icon-divder', array($this, 'icon_divider_attr'));
        add_filter('t4p_attr_button-shortcode-icon', array($this, 'icon_attr'));
        add_filter('t4p_attr_button-shortcode-button-text', array($this, 'button_text_attr'));

        add_shortcode('button', array($this, 'render'));
    }

    /**
     * Render the shortcode
     * @param  array $args    Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render($args, $content = '') {
        global $smof_data;
        global $evl_options;

        $defaults = T4PCore_Plugin::set_shortcode_defaults(
                        array(
                    'class' => '',
                    'id' => '',
                    'accent_color' => strtolower($smof_data['button_accent_color']) . strtolower($evl_options['evl_shortcode_button_accent_color']),
                    'accent_hover_color' => strtolower($smof_data['button_accent_hover_color']) . strtolower($evl_options['evl_shortcode_button_accent_hover_color']),
                    'bevel_color' => strtolower($smof_data['button_bevel_color']) . strtolower($evl_options['evl_shortcode_button_bevel_color']),
                    'border_width' => strtolower($smof_data['button_border_width']) . strtolower($evl_options['evl_shortcode_button_border_width']),
                    'color' => 'default',
                    'gradient_colors' => strtolower($smof_data['button_gradient_top_color']) . strtolower($evl_options['evl_shortcode_button_gradient_top_color']) . '|' . strtolower($smof_data['button_gradient_bottom_color']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_color']),
                    'icon' => '',
                    'icon_divider' => 'no',
                    'icon_position' => 'left',
                    'link' => '',
                    'modal' => '',
                    'shape' => strtolower($smof_data['button_shape']) . strtolower($evl_options['evl_shortcode_button_shape']),
                    'size' => strtolower($smof_data['button_size']) . strtolower($evl_options['evl_shortcode_button_size']),
                    'target' => '_self',
                    'shadow' => strtolower($smof_data['button_text_shadow']) . strtolower($evl_options['evl_shortcode_button_shadow']),
                    'title' => '',
                    'type' => strtolower($smof_data['button_type']) . strtolower($evl_options['evl_shortcode_button_type']),
                    'animation_type' => '',
                    'animation_direction' => 'down',
                    'animation_speed' => '',
                    // Combined in accent_color
                    'border_color' => '',
                    'icon_color' => '',
                    'text_color' => '',
                    // Combined in accent_hover_color
                    'border_hover_color' => '',
                    'icon__hover_color' => '',
                    'text_hover_color' => '',
                    // Combined with gradient_colors
                    'gradient_hover_colors' => strtolower($smof_data['button_gradient_top_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_top_hover_color']) . '|' . strtolower($smof_data['button_gradient_bottom_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_hover_color']),
                        ), $args
        );

        if ($defaults['color'] == 'default') {
            $defaults['accent_color'] = strtolower($smof_data['button_accent_color']) . strtolower($evl_options['evl_shortcode_button_accent_color']);
            $defaults['accent_hover_color'] = strtolower($smof_data['button_accent_hover_color']) . strtolower($evl_options['evl_shortcode_button_accent_hover_color']);
            $defaults['bevel_color'] = strtolower($smof_data['button_bevel_color']) . strtolower($evl_options['evl_shortcode_button_bevel_color']);
            $defaults['gradient_colors'] = strtolower($smof_data['button_gradient_top_color']) . strtolower($evl_options['evl_shortcode_button_gradient_top_color']) . '|' . strtolower($smof_data['button_gradient_bottom_color']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_color']);
            $defaults['gradient_hover_colors'] = strtolower($smof_data['button_gradient_top_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_top_hover_color']) . '|' . strtolower($smof_data['button_gradient_bottom_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_hover_color']);
            // By Jerry | 04/04/2015
            $defaults['border_color'] = strtolower($smof_data['button_border_color']) . strtolower($evl_options['evl_shortcode_button_border_color']);
            $defaults['border_color_hover'] = strtolower($smof_data['button_border_color_hover']) . strtolower($evl_options['evl_shortcode_button_border_hover_color']);
        }

        // Combined variable settings
        $old_border_color = $defaults['border_color'];
        $old_text_color = $defaults['text_color'];

        $defaults['border_color'] = $defaults['icon_color'] = $defaults['text_color'] = $defaults['accent_color'];
        $defaults['border_hover_color'] = $defaults['icon_hover_color'] = $defaults['text_hover_color'] = $defaults['accent_hover_color'];
        //$defaults['gradient_hover_colors'] = $defaults['gradient_hover_colors']; // See below for array reverting

        if ($old_border_color) {
            $defaults['border_color'] = $old_border_color;
        }

        if ($old_text_color) {
            $defaults['text_color'] = $old_border_color;
        }

        if ($defaults['modal']) {
            $defaults['link'] = '#';
        }

        extract($defaults);

        self::$args = $defaults;

        $styles = '';
        if (( $color == 'custom' || $color == 'default' ) &&
                (
                $bevel_color ||
                $accent_color ||
                $accent_hover_color ||
                $border_width ||
                $gradient_colors
                )
        ) {

            $general_styles = $button_3d_styles = $hover_styles = $gradient_styles = $gradient_hover_styles = '';
            $styles = '<style>';

            if ($type == '3d' &&
                    $bevel_color
            ) {
                if ($size == 'small') {
                    $button_3d_add = 0;
                } elseif ($size == 'medium') {
                    $button_3d_add = 1;
                } elseif ($size == 'large') {
                    $button_3d_add = 2;
                } elseif ($size == 'xlarge') {
                    $button_3d_add = 3;
                }

                $button_3d_shadow_part_1 = 'inset 0px 1px 0px #fff,';

                $button_3d_shadow_part_2 = sprintf('0px %spx 0px %s,', 2 + $button_3d_add, $bevel_color);

                $button_3d_shadow_part_3 = sprintf('1px %spx %spx 3px rgba(0,0,0,0.3)', 4 + $button_3d_add, 4 + $button_3d_add);
                if ($size == 'small') {
                    $button_3d_shadow_part_3 = str_replace('3px', '2px', $button_3d_shadow_part_3);
                }
                $button_3d_shadow = $button_3d_shadow_part_1 . $button_3d_shadow_part_2 . $button_3d_shadow_part_3;

                $button_3d_styles = sprintf('-webkit-box-shadow: %s;-moz-box-shadow: %s;box-shadow: %s;', $button_3d_shadow, $button_3d_shadow, $button_3d_shadow);

                if ($gradient_hover_colors) {

                    // checking for deprecated separators: ;
                    if (strpos($gradient_hover_colors, ';')) {
                        $grad_hover_colors = explode(';', $gradient_hover_colors);
                    } else {
                        $grad_hover_colors = explode('|', $gradient_hover_colors);
                    }
                }
                $grad_hover_colors_trim = substr($grad_hover_colors[1], 1);
                $bevel_color_hover = '#' . t4p_hexdarker($grad_hover_colors_trim);

                if (!$bevel_color_hover) {
                    $bevel_color_hover = '#' . t4p_hexdarker($smof_data['button_gradient_bottom_color_hover']);
                }

                $button_3d_shadow_hover_part_1 = 'inset 0px 1px 0px #fff,';

                $button_3d_shadow_hover_part_2 = sprintf('0px %spx 0px %s,', 2 + $button_3d_add, $bevel_color_hover);

                $button_3d_shadow_hover_part_3 = sprintf('1px %spx %spx 3px rgba(0,0,0,0.3)', 4 + $button_3d_add, 4 + $button_3d_add);
                if ($size == 'small') {
                    $button_3d_shadow_hover_part_3 = str_replace('3px', '2px', $button_3d_shadow_hover_part_3);
                }
                $button_3d_shadow_hover = $button_3d_shadow_hover_part_1 . $button_3d_shadow_hover_part_2 . $button_3d_shadow_hover_part_3;

                $button_3d_styles_hover = sprintf('-webkit-box-shadow: %s;-moz-box-shadow: %s;box-shadow: %s;', $button_3d_shadow_hover, $button_3d_shadow_hover, $button_3d_shadow_hover);
            }

            if ($shadow == 'no') {
                $general_styles .= 'text-shadow:none;';
                if ($type != '3d') {
                    $general_styles .= '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow: none;';
                }
            }

            if ($border_width) {
                $general_styles .= sprintf('border-width:%s;', $border_width);
                $hover_styles .= sprintf('border-width:%s;', $border_width);
            }

            if ($accent_color) {
                if (!$old_text_color) {
                    $general_styles .= sprintf('color:%s;', $accent_color . '!important');					
                }
                if (!$old_border_color) {
                    $general_styles .= sprintf('border-color:%s;', $border_color);
                }
            }

            if ($old_border_color && isset($args['border_color'])) {
                $general_styles .= sprintf('border-color:%s;', $args['border_color']);
            }

            if ($old_text_color) {
                $general_styles .= sprintf('color:%s;', $old_text_color . '!important');
            }

            if ($accent_hover_color && !$old_border_color) {
                $hover_styles .= sprintf('border-color:%s;', $accent_hover_color);
            } elseif ($accent_color && !$old_border_color) {
                $hover_styles .= sprintf('border-color:%s;', $accent_color);
            }

            if ($accent_hover_color && !$old_text_color) {
                $hover_styles .= sprintf('color:%s;', $accent_hover_color . '!important');
            }

            if ($accent_color && !$old_text_color) {
                $general_styles .= sprintf('color:%s;', $accent_color . '!important');
            }

            if ($old_border_color && isset($args['border_hover_color'])) {
                $hover_styles .= sprintf('border-color:%s;', $args['border_hover_color']);
            }

            if ($old_text_color) {
                $hover_styles .= sprintf('color:%s;', $old_text_color);
            }

            // Apply general styles
            if ($general_styles) {
                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
            }

            // Apply 3d styles
            if ($button_3d_styles) {
                $styles .= sprintf('.t4p-button.button-%s.button-3d{%s}.button-%1$s.button-3d:active{%2$s}', $this->button_counter, $button_3d_styles);
            }

            // Apply hover styles
            if ($hover_styles) {
                $styles .= sprintf('.t4p-button.button-%s:hover,.t4p-button.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $hover_styles);
            }

            // Apply 3d hover styles
            if (isset($button_3d_styles_hover) && $button_3d_styles_hover) {
                $styles .= sprintf('.t4p-button.button-%s.button-3d:hover{%s}.button-%1$s.button-3d:hover{%2$s}.button-%1$s.button-3d:focus{%2$s}.button-%1$s.button-3d:active{%2$s}', $this->button_counter, $button_3d_styles_hover);
            }

            if ($gradient_colors) {
                // checking for deprecated separators: ;
                if (strpos($gradient_colors, ';')) {
                    $grad_colors = explode(';', $gradient_colors);
                } else {
                    $grad_colors = explode('|', $gradient_colors);
                }

                if (count($grad_colors) == 1 ||
                        $grad_colors[1] == ''
                ) {
                    $gradient_styles = "background: {$grad_colors[0]};";
                } else {
                    $gradient_styles = "background: {$grad_colors[0]};
					background-image: -webkit-gradient( linear, left bottom, left top, from( {$grad_colors[1]} ), to( {$grad_colors[0]} ) );
					background-image: -webkit-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} );
					background-image:    -moz-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} );
					background-image:      -o-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} );
					background-image: linear-gradient( to top, {$grad_colors[1]}, {$grad_colors[0]} );";
                }

                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $gradient_styles);
            }

            if ($gradient_hover_colors) {

                // checking for deprecated separators: ;
                if (strpos($gradient_hover_colors, ';')) {
                    $grad_hover_colors = explode(';', $gradient_hover_colors);
                } else {
                    $grad_hover_colors = explode('|', $gradient_hover_colors);
                }

                // For combination of gradient_hover_colors and gradient_hover_colors
                //$grad_hover_colors = array_reverse( $grad_hover_colors );

                if (count($grad_hover_colors) == 1 ||
                        $grad_hover_colors[1] == ''
                ) {
                    $gradient_hover_styles = "background: {$grad_hover_colors[0]};";
                } else {
                    $gradient_hover_styles .=
                            "background: {$grad_hover_colors[0]};
					background-image: -webkit-gradient( linear, left bottom, left top, from( {$grad_hover_colors[1]} ), to( {$grad_hover_colors[0]} ) );
					background-image: -webkit-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} );
					background-image:    -moz-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} );
					background-image:      -o-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} );
					background-image: linear-gradient( to top, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} );";
                }

                $styles .= sprintf('.t4p-button.button-%s:hover,.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $gradient_hover_styles);
            }

            $styles .= '</style>';
        } else {
            if ($shadow == 'no') {
                $styles = '<style>';
                $general_styles = 'text-shadow:none;';
                if ($type != '3d') {
                    $general_styles .= 'box-shadow: none;';
                }
                if ($general_styles) {
                    $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
                }
                $styles .= '</style>';
            }
        }

        /**
         * If color is not "default" or "custom"
         * Right now just "border color" fix applied,
         * later can be added any aditional data
         *
         * @by jerry
         * @date 04/04/2015
         * @since 1.3.0
         */
        if ($color !== 'default' || $color !== 'custom') {
            $styles .= '<style>';

            // If accent color set, let's apply it. | Else default border color from style.css will be aplied.
            if (isset($args['accent_color']) && $args['accent_color']) {
                $general_styles .= sprintf('color:%s;', $args['accent_color'] . '!important');
            }

            // If accent hover color set, let's apply it. | Else default border hover color from theme options will be applied.
            if (isset($args['accent_hover_color']) && $args['accent_hover_color']) {
                $hover_styles .= sprintf('color:%s;', $args['accent_hover_color'] . '!important');
            }

            // If border color set, let's apply it. | Else default border color from style.css will be aplied.
            if (isset($args['border_color']) && $args['border_color']) {
                $general_styles .= sprintf('border-color:%s;', $args['border_color']);
            }

            // If border hover color set, let's apply it. | Else default border hover color from theme options will be applied.
            if (isset($args['border_hover_color']) && $args['border_hover_color']) {
                $hover_styles .= sprintf('border-color:%s;', $args['border_hover_color']);
            }

            // Apply general style
            if (isset($general_styles) && $general_styles) {
                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
            }

            // Apply hover style
            if (isset($hover_styles) && $hover_styles) {
                $styles .= sprintf('.t4p-button.button-%s:hover,.t4p-button.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $hover_styles);
            }

            $styles .= '</style>';
        }

        $icon_html = '';
        if ($icon) {
            $icon_html = sprintf('<i %s></i>', T4PCore_Plugin::attributes('button-shortcode-icon'));

            if ($icon_divider == 'yes') {
                $icon_html = sprintf('<span %s>%s</span>', T4PCore_Plugin::attributes('button-shortcode-icon-divder'), $icon_html);
            }
        }

        $button_text = sprintf('<span %s>%s</span>', T4PCore_Plugin::attributes('button-shortcode-button-text'), do_shortcode($content));

        if ($icon_position == 'left') {

            $inner_content = $icon_html . $button_text;
        } else {
            $inner_content = $button_text . $icon_html;
        }

        $html = sprintf('%s<a %s>%s</a>', $styles, T4PCore_Plugin::attributes('button-shortcode'), $inner_content);

        $this->button_counter++;

        return $html;
    }

    function attr() {

        $attr['class'] = sprintf('btn-default button %3$s button %4$s t4p-button button-%s button-%s button-%s button-%s button-%s buttonshadow-%s', self::$args['type'], self::$args['shape'], self::$args['size'], self::$args['color'], $this->button_counter, self::$args['shadow']);

        if (self::$args['animation_type']) {
            $animations = T4PCore_Plugin::animations(array(
                        'type' => self::$args['animation_type'],
                        'direction' => self::$args['animation_direction'],
                        'speed' => self::$args['animation_speed'],
            ));

            $attr = array_merge($attr, $animations);

            $attr['class'] .= ' ' . $attr['animation_class'];
        }

        $attr['type'] = 'button';
        $attr['target'] = self::$args['target'];
        $attr['title'] = self::$args['title'];
        $attr['href'] = self::$args['link'];

        if (self::$args['modal']) {
            $attr['data-toggle'] = 'modal';
            $attr['data-target'] = '.' . self::$args['modal'];
        }

        if (self::$args['class']) {
            $attr['class'] .= ' ' . self::$args['class'];
        }

        if (self::$args['id']) {
            $attr['id'] = self::$args['id'];
        }

        return $attr;
    }

    function icon_divider_attr() {

        $attr = array();

        $attr['class'] = sprintf('button-icon-divider-%s', self::$args['icon_position']);

        return $attr;
    }

    function icon_attr() {

        $attr = array();

        $attr['class'] = sprintf('fa %s', T4PCore_Plugin::font_awesome_name_handler(self::$args['icon']));

        if (self::$args['icon_divider'] != 'yes') {
            $attr['class'] .= sprintf(' button-icon-%s', self::$args['icon_position']);
        }

        if (self::$args['icon_color'] != self::$args['accent_color']) {
            $attr['style'] = sprintf('color:%s;', self::$args['icon_color']);
        }

        return $attr;
    }

    function button_text_attr() {

        $attr = array();

        if (self::$args['icon'] &&
                self::$args['icon_divider'] == 'yes'
        ) {
            $attr['class'] = sprintf('t4p-button-text-%s', self::$args['icon_position']);
        } else {
            $attr['class'] = 't4p-button-text';
        }

        return $attr;
    }

}

new T4PSC_Button();