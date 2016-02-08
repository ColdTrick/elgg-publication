<?php

// file
$file = elgg_format_element('label', ['for' => 'publications-bibtext-import'], elgg_echo('publication:bibtex'));
$file .= elgg_view('input/file', [
	'name' => 'bibtex_import',
	'id' => 'publications-bibtext-import',
]);

$import_behaviour = elgg_get_plugin_setting('bibtex_import_behaviour', 'publications', 'skip');
switch ($import_behaviour) {
	case 'update':
		$file .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('publication:bibtex:update:description'));
		break;
	case 'user_skip':
	case 'user_update':
		$options = [
			'name' => 'user_update_setting',
			'value' => 'update',
			'checked' => ($import_behaviour === 'user_update') ? true : false,
			'label' => elgg_echo('publication:bibtex:update'),
		];
		$file .= elgg_view('input/checkbox', $options);
		$file .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('publication:bibtex:user_update:description'));
		break;
	default:
		$file .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('publication:bibtex:skip:description'));
		break;
}

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
