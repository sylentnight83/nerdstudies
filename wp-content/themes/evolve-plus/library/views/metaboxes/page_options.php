<div class="t4p_metabox">
<h2>Portfolio options</h2>
<?php
$this->select(	'portfolio_full_width',
				'Portfolio: Full Width',
				array('yes' => 'Yes', 'no' => 'No'),
				''
			);
?>
<?php
$this->select(	'portfolio_sidebar_position',
				'Portfolio: Sidebar Position',
				array('right' => 'Right', 'left' => 'Left'),
				''
			);
?>
<?php
$types = get_terms('portfolio_category', 'hide_empty=0');
$types_array[0] = 'All categories';
if($types) {
	foreach($types as $type) {
		$types_array[$type->term_id] = $type->name;
	}
$this->multiple(	'portfolio_category',
				'Portfolio Type',
				$types_array,
				'Choose what portfolio category you want to display on this page. Leave blank for all categories.'
			);
}
?>
<?php
$this->select(	'portfolio_filters',
				'Show Portfolio Filters',
				array('yes' => 'Show', 'no' => 'Hide'),
				''
			);
?>
</div>