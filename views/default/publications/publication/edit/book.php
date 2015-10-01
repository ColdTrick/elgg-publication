<?php

$entity = elgg_extract('entity', $vars);

$required_text = elgg_echo("publications:forms:required");
$required = elgg_format_element('span', ['class' => ['elgg-quiet', 'mls']], $required_text);

$publish_location = '';
$publisher = '';
$pages = '';

if ($entity instanceof Publication) {
	$publish_location = $entity->publish_location;
	$publisher = $entity->publisher;
	$pages = $entity->pages;
}

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

// pages
$pages_input = elgg_format_element('label', ['for' => 'publication-pages'], elgg_echo('publication:pages') . $required);
$pages_input .= elgg_view('input/text', [
	'name' => 'data[pages]',
	'value' => $pages,
	'id' => 'publication-pages',
	'required' => true,
]);
echo elgg_format_element('div', [], $pages_input);
