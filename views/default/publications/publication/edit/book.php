<?php

$entity = elgg_extract('entity', $vars);

$book_editors = [];
if ($entity instanceof Publication) {
	$book_editors = explode(',', $entity->book_editors);
}

// book field config
$field_config = [
	'author' => [
		'name' => 'book_editors',
		'value' => $book_editors,
		'id' => 'publications-book-editors',
		'label' => elgg_echo('publication:book_editors'),
	],
	'publisher' => [
		'required' => true,
	],
	'volume' => [],
	'number' => [],
	'series' => [],
	'address' => [],
	'edition' => [],
	'month' => [],
];

// default fields
foreach ($field_config as $input_type => $settings) {
	$settings = $settings + $vars;
	echo elgg_view("input/publications/{$input_type}", $settings);
}
