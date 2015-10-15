<?php

$entity = elgg_extract('entity', $vars);

$required_text = elgg_echo("publications:forms:required");
$required = elgg_format_element('span', ['class' => ['elgg-quiet', 'mls']], $required_text);

$booktitle = '';
$book_editors = [];

if ($entity instanceof Publication) {
	$booktitle = $entity->booktitle;
	$book_editors = explode(',', $entity->book_editors);
}

// inbook field config
$field_config = [
	'author' => [
		'name' => 'book_editors',
		'value' => $book_editors,
		'id' => 'publications-book-editors',
		'label' => elgg_echo('publication:book_editors'),
	],
	'title' => [
		'name' => 'data[booktitle]',
		'value' => $booktitle,
		'id' => 'publications-book-title',
		'label' => elgg_echo('publication:booktitle'),
	],
	'pages' => [
		'required' => true,
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
