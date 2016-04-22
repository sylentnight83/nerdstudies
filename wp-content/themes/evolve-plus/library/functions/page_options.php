<div class='t4p_metabox'>
    <h2 style="margin-top:0;"><?php _e('Post options', 'evolve'); ?></h2>
    <?php
    $this->evolve_select('full_width', __('Full Width', 'evolve'), array(
        'no' => __('No', 'evolve'),
        'yes' => __('Yes', 'evolve'),
            ), ''
    );
    ?>       
    <h2 style="margin-top:0;"><?php _e('Slider Options', 'evolve'); ?></h2>
    <?php
    $this->evolve_select('slider_type', __('Slider Type', 'evolve'), array(
        'no' => __('No Slider', 'evolve'),
        'layer' => __('LayerSlider', 'evolve'),
        'rev' => __('Revolution Slider', 'evolve'),
        'flex' => __('FlexSlider', 'evolve'),
        'parallax' => __('Parallax Slider', 'evolve'),
        'posts' => __('Posts Slider', 'evolve'),
        'bootstrap' => __('Bootstrap Slider', 'evolve')
            ), ''
    );
    ?>    
    <?php
    global $wpdb;
    $slides_array[0] = __('Select a slider', 'evolve');
// Table name
    $table_name = $wpdb->prefix . "layerslider";

// Get sliders
    $sliders = $wpdb->get_results("SELECT * FROM $table_name
									WHERE flag_hidden = '0' AND flag_deleted = '0'
									ORDER BY date_c ASC");

    if (!empty($sliders)):
        foreach ($sliders as $key => $item):
            $slides[$item->id] = '';
        endforeach;
    endif;

    if (isset($slides) && $slides) {
        foreach ($slides as $key => $val) {
            $slides_array[$key] = 'LayerSlider #' . ($key);
        }
    }
    $this->evolve_select('slider', __('Select LayerSlider', 'evolve'), $slides_array, ''
    );
    ?>

    <?php
    global $wpdb;
    $revsliders[0] = __('Select a slider', 'evolve');
    if (function_exists('rev_slider_shortcode')) {
        $get_sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders');
        if ($get_sliders) {
            foreach ($get_sliders as $slider) {
                $revsliders[$slider->alias] = $slider->title;
            }
        }
    }
    $this->evolve_select('revslider', __('Select Revolution Slider', 'evolve'), $revsliders, ''
    );
    ?>
    <?php
    $slides_array = array();
    $slides = array();
    $slides_array[0] = __('Select a slider', 'evolve');
    $slides = get_terms('slide-page');
    if ($slides && !isset($slides->errors)) {
        $slides = is_array($slides) ? $slides : unserialize($slides);
        foreach ($slides as $key => $val) {
            $slides_array[$val->slug] = $val->name;
        }
    }
    $this->evolve_select('wooslider', __('Select FlexSlider', 'evolve'), $slides_array, ''
    );
    ?>
    <h2 style="margin-top:0;"><?php _e('Widget Options', 'evolve'); ?></h2>
    <?php
    $this->evolve_select('widget_page', __('Enable Header Widgets', 'evolve'), array(
        'no' => __('No', 'evolve'),
        'yes' => __('Yes', 'evolve')
            ), ''
    );
    ?>
    <h2 style="margin-top:0;"><?php _e('Page title options', 'evolve'); ?></h2>
    <?php
    $this->evolve_select('page_title', __('Page Title', 'evolve'), array(
        'yes' => __('Show', 'evolve'),
        'no' => __('Hide', 'evolve'),
            ), ''
    );
    ?>
    <?php
    $this->evolve_select('page_breadcrumb', __('Page Breadcrumb', 'evolve'), array(
        'yes' => __('Show', 'evolve'),
        'no' => __('Hide', 'evolve'),
            ), ''
    );
    ?>
</div>
