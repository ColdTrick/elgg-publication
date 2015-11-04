<?php

$entity = elgg_extract('entity', $vars);


$id = elgg_extract('id', $vars, 'publications-title');
$name = elgg_extract('name', $vars, 'publicationtitle');

$default_value = '';
if ($entity instanceof Publication) {
	$default_value = $entity->title;
}

$value = elgg_extract('value', $vars, $default_value);

$label_text = elgg_extract('label', $vars, elgg_echo('title'));
if (elgg_extract('required', $vars, true)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => $id], $label_text);

$params = [
	'id' => $id,
	'name' => $name,
	'value' => $value,
	'required' => (bool) elgg_extract('required', $vars, true),
];
$params = $params + $vars;

$input = elgg_view('input/text', $params);

echo elgg_format_element('div', [], $label . $input);
