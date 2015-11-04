<?php

// file
$file = elgg_format_element('label', ['for' => 'publications-bibtext-import'], elgg_echo('publication:bibtex'));
$file .= elgg_view('input/file', [
	'name' => 'bibtex_import',
	'id' => 'publications-bibtext-import',
]);
echo elgg_format_element('div', [], $file);

// description
echo elgg_view('output/longtext', [
	'value' => elgg_echo('publication:bibtex:description'),
]);

// forward after upload
// $forwarding = elgg_view('input/checkbox', [
// 	'name' => 'forward_to_edit',
// 	'checked' => true,
// 	'value' => 1,
// 	'default' => 0,
// 	'label' => elgg_echo('publication:import:forward'),
// ]);
// $forwarding .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('publication:import:forward:description'));
// echo elgg_format_element('div', [], $forwarding);

// buttons
$buttons = elgg_view('input/submit', [
	'value' => elgg_echo('import'),
]);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $buttons);
