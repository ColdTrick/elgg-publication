<?php

// article field config
$field_config = [
	'journal' => [
		'required' => true,
	],
	'volume' => [
		'required' => true,
	],
	'number' => [],
	'pages' => [],
	'month' => [],
];

// default fields
foreach ($field_config as $input_type => $settings) {
	$settings = $settings + $vars;
	echo elgg_view("input/publications/{$input_type}", $settings);
}
