<?php

$entity = elgg_extract('entity', $vars);

$value = '';
if ($entity instanceof Publication) {
	$value = $entity->description;
}

$label_text = elgg_echo('publication:abstract');
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-description'], $label_text);

$params = [
	'id' => 'publications-description',
	'name' => 'data[description]',
	'value' => $value,
	'required' => (bool) elgg_extract('required', $vars, false),
];
$params = $params + $vars;

$input = elgg_view('input/longtext', $params);

echo elgg_format_element('div', [], $label . $input);
