<?php

$label_text = elgg_echo('publication:attachment');
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => 'publications-attachment'], $label_text);

$params = [
	'id' => 'publications-attachment',
	'name' => 'attachment',
	'required' => (bool) elgg_extract('required', $vars, false),
];
$params = $params + $vars;

$input = elgg_view('input/file', $params);

$description = elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('publication:attachment:instruction'));

echo elgg_format_element('div', [], $label . $input . $description);
