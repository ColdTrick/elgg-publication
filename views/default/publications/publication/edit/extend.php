<?php

$entity = elgg_extract("entity", $vars);

$uri = '';
$translation = 0;
$promotion = 0;
if ($entity instanceof Publication) {
	$uri = $entity->uri;
	$translation = (int) $entity->translation;
	$promotion = (int) $entity->promotion;
}

// uri
$uri_label = elgg_format_element('label', ['for' => 'publications-uri'], elgg_echo('publication:uri'));
$uri_input = elgg_view('input/text', [
	'id' => 'publications-uri',
	'name' => 'data[uri]',
	'value' => $uri,
]);
echo elgg_format_element('div', [], $uri_label . $uri_input);

// translation
$translation_input = elgg_view('input/checkbox', [
	'name' => 'data[translation]',
	'value' => 1,
	'checked' => ($translation === 1),
	'label' => elgg_echo('publication:translation'),
]);
$translation_input .= '<br />';

// promotion
$promotion_input = elgg_view('input/checkbox', [
	'name' => 'data[promotion]',
	'value' => 1,
	'checked' => ($promotion === 1),
	'label' => elgg_echo('publication:promotion'),
]);
echo elgg_format_element('div', [], $translation_input . $promotion_input);
