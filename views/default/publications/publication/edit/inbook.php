<?php

$entity = elgg_extract('entity', $vars);

$booktitle = '';
$book_editors = [];

if ($entity instanceof Publication) {
	$booktitle = $entity->booktitle;
	$book_editors = explode(',', $entity->book_editors);
}

// inbook field config
$field_config = [
	'title' => [],
	'author' => [
		'required' => true,
	],
	'year' => [],
	'month' => [],
	'editor' => [
		'type' => 'author',
		'name' => 'book_editors',
		'value' => $book_editors,
		'id' => 'publications-book-editors',
		'label' => elgg_echo('publication:book_editors'),
	],
	'booktitle' => [
		'type' => 'title',
		'name' => 'data[booktitle]',
		'value' => $booktitle,
		'id' => 'publications-book-title',
		'label' => elgg_echo('publication:booktitle'),
	],
	'pages' => [
		'required' => false,
	],
	'chapter' => [],
	'publisher' => [
		'required' => true,
	],
	'volume' => [],
	'number' => [],
	'series' => [],
	'address' => [],
	'edition' => [],
];

// default fields
foreach ($field_config as $input_type => $settings) {
	$input_type = elgg_extract('type', $settings, $input_type);
	unset($settings['type']);
	
	$settings = $settings + $vars;
	echo elgg_view("input/publications/{$input_type}", $settings);
}
