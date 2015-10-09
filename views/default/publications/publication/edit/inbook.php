<?php

$entity = elgg_extract('entity', $vars);

$required_text = elgg_echo("publications:forms:required");
$required = elgg_format_element('span', ['class' => ['elgg-quiet', 'mls']], $required_text);

$booktitle = '';
$book_editors = '';
$publish_location = '';
$publisher = '';
$page_from = '';
$page_to = '';

if ($entity instanceof Publication) {
	$booktitle = $entity->booktitle;
	$book_editors = $entity->book_editors;
	$publish_location = $entity->publish_location;
	$publisher = $entity->publisher;
	$page_from = $entity->page_from;
	$page_to = $entity->page_to;
}

// book title
$book_title_input = elgg_format_element('label', ['for' => 'publication-book-title'], elgg_echo('publication:booktitle') . $required);
$book_title_input .= elgg_view('input/text', [
	'name' => 'data[booktitle]',
	'value' => $booktitle,
	'id' => 'publication-book-title',
	'required' => true,
]);
echo elgg_format_element('div', [], $book_title_input);

// book editors
$book_editors_input = elgg_format_element('label', ['for' => 'publications-book-editors'], elgg_echo('publication:book_editors') . $required);
$book_editors_input .= elgg_view('input/publications/author', [
	'name' => 'book_editors',
	'value' => $book_editors,
	'id' => 'publications-book-editors'
]);
echo elgg_format_element('div', [], $book_editors_input);

// location
$location_input = elgg_format_element('label', ['for' => 'publication-publish-location'], elgg_echo('publication:publish_location') . $required);
$location_input .= elgg_view('input/text', [
	'name' => 'data[publish_location]',
	'value' => $publish_location,
	'id' => 'publication-publish-location',
	'required' => true,
]);
echo elgg_format_element('div', [], $location_input);

// publisher
$publisher_input = elgg_format_element('label', ['for' => 'publication-publisher'], elgg_echo('publication:publisher') . $required);
$publisher_input .= elgg_view('input/text', [
	'name' => 'data[publisher]',
	'value' => $publisher,
	'id' => 'publication-publisher',
	'required' => true,
]);
echo elgg_format_element('div', [], $publisher_input);

// page from
$page_from_input = elgg_format_element('label', ['for' => 'publication-page-from'], elgg_echo('publication:page_from') . $required);
$page_from_input .= elgg_view('input/text', [
	'name' => 'data[page_from]',
	'value' => $page_from,
	'id' => 'publication-page-from',
	'required' => true,
]);
echo elgg_format_element('div', [], $page_from_input);

// page to
$page_to_input = elgg_format_element('label', ['for' => 'publication-page-to'], elgg_echo('publication:page_to') . $required);
$page_to_input .= elgg_view('input/text', [
	'name' => 'data[page_to]',
	'value' => $page_to,
	'id' => 'publication-page-to',
	'required' => true,
]);
echo elgg_format_element('div', [], $page_to_input);
