<?php

$entity = elgg_extract('entity', $vars);

$value = '';
if ($entity instanceof Publication) {
	$value = $entity->school;
}

$label_text = elgg_echo('publication:school');
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-school'], $label_text);

$params = [
	'id' => 'publications-school',
	'name' => 'data[school]',
	'value' => $value,
	'required' => (bool) elgg_extract('required', $vars, false),
];
$params = $params + $vars;

$input = elgg_view('input/text', $params);

echo elgg_format_element('div', [], $label . $input);
