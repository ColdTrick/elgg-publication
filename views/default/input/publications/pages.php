<?php

$entity = elgg_extract('entity', $vars);

$page_from = '';
$page_to = '';
if ($entity instanceof Publication) {
	$page_from = $entity->page_from;
	$page_to = $entity->page_to;
}

// page from
$label_text = elgg_echo('publication:page_from');
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-page-from'], $label_text);

$params = [
	'id' => 'publications-page-from',
	'name' => 'data[page_from]',
	'value' => $page_from,
	'required' => (bool) elgg_extract('required', $vars, false),
];
$params = $params + $vars;

$input = elgg_view('input/text', $params);

echo elgg_format_element('div', [], $label . $input);

// page to
$label_text = elgg_echo('publication:page_to');
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-page-to'], $label_text);

$params = [
	'id' => 'publications-page-to',
	'name' => 'data[page_to]',
	'value' => $page_to,
	'required' => (bool) elgg_extract('required', $vars, false),
];
$params = $params + $vars;

$input = elgg_view('input/text', $params);

echo elgg_format_element('div', [], $label . $input);
