<div class='t4p_metabox'>
    <h2 style="margin-top:0;">Portfolio options</h2>
    <?php
    $this->select('width', 'Width (Content Columns for Featured Image)', array('full' => 'Full Width', 'half' => 'Half Width'), ''
    );

    $this->select('sidebar', 'Show Sidebar', array('no' => 'No', 'yes' => 'Yes'), ''
    );
	sidebar_generator::edit_form(); 
	
    $this->select('sidebar_position', 'Page: Sidebar Position', array('default' => 'Default', 'right' => 'Right', 'left' => 'Left'), ''
    );
    $this->select('project_desc_title', 'Show Project Description Title', array('yes' => 'Yes', 'no' => 'No'), ''
    );
    $this->select('project_details', 'Show Project Details', array('yes' => 'Yes', 'no' => 'No'), ''
    );
    ?>    
    <?php
    $this->text('project_url', 'Project URL', ''
    );
    ?>
    <?php
    $this->text('project_url_text', 'Project URL Text', ''
    );
    ?>    
    <?php
    $this->text('fimg_width', 'Featured Image Width', '(in pixels or percentage, e.g.: 100% or 100px.  Or Use "auto" for automatic resizing if you added either width or height)'
    );
    ?>
    <?php
    $this->text('fimg_height', 'Featured Image Height', '(in pixels or percentage, e.g.: 100% or 100px.  Or Use "auto" for automatic resizing if you added either width or height)'
    );
    ?>
    <?php
    $this->select('image_rollover_icons', 'Image Rollover Icons', array('linkzoom' => 'Link + Zoom', 'link' => 'Link', 'zoom' => 'Zoom', 'no' => 'No Icons'), ''
    );
    ?>
    <?php
    $this->text('link_icon_url', 'Link Icon URL', 'Leave blank for post URL'
    );
    ?>
    <?php
    $this->select('link_icon_target', 'Open Link Icon URL In New Window', array('no' => 'No', 'yes' => 'Yes'), ''
    );
    ?>
    <?php
    $this->select('related_posts', 'Show Related Posts', array('default' => 'Default', 'yes' => 'Show', 'no' => 'Hide'), ''
    );
    ?>    
</div>