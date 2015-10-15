<?php

// field config
$field_config = [
	'title' => [],
	'author' => [],
	'year' => [],
	'month' => [],
	'volume' => [],
	'number' => [],
	'series' => [],
	'address' => [],
	'organization' => [],
	'publisher' => [
		'required' => false,
	],
];

// default fields
foreach ($field_config as $input_type => $settings) {
	$input_type = elgg_extract('type', $settings, $input_type);
	unset($settings['type']);
	
	$settings = $settings + $vars;
	echo elgg_view("input/publications/{$input_type}", $settings);
}
