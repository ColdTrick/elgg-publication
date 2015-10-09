<?php

$entity = elgg_extract('entity', $vars);

$value = '';
if ($entity instanceof Publication) {
	$value = $entity->title;
}

$label_text = elgg_echo('title');
if (elgg_extract('required', $vars, true)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-title'], $label_text);

$params = [
	'id' => 'publications-title',
	'name' => 'publicationtitle',
	'value' => $value,
	'required' => (bool) elgg_extract('required', $vars, true),
];
$params = $params + $vars;

$input = elgg_view('input/text', $params);

echo elgg_format_element('div', [], $label . $input);
