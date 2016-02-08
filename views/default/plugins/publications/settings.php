<?php

$plugin = elgg_extract('entity', $vars);

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
];

$noyes_options = array_reverse($yesno_options);

$bibtex_import_behaviour = [
	'skip' => elgg_echo('publications:settings:bibtex_import_behaviour:skip'),
	'update' => elgg_echo('publications:settings:bibtex_import_behaviour:update'),
	'user_skip' => elgg_echo('publications:settings:bibtex_import_behaviour:user_skip'),
	'user_update' => elgg_echo('publications:settings:bibtex_import_behaviour:user_update'),
];

// $onoff_options = [
// 	'on' => elgg_echo('on'),
// 	'off' => elgg_echo('off')
// ];

// echo '<div>';
// echo elgg_echo('publication:modify') . ' ';
// echo elgg_view('input/select', [
// 	'name' => 'params[toggleinvites]',
// 	'options_values' => $onoff_options,
// 	'value' => strtolower($plugin->toggleinvites)
// ]);
// echo '</div>';

// echo '<div>';
// echo elgg_echo('publication:attachment:title') . ' ';
// echo elgg_view('input/select', [
// 	'name' => 'params[toggleattachment]',
// 	'options_values' => $onoff_options,
// 	'value' => strtolower($plugin->toggleattachment)
// ]);
// echo '</div>';

$bibtex = elgg_echo('publications:settings:enable_bibtex') . ' ';
$bibtex .= elgg_view('input/select', [
	'name' => 'params[enable_bibtex]',
	'options_values' => $noyes_options,
	'value' => $plugin->enable_bibtex,
]);
echo elgg_format_element('div', [], $bibtex);

$import_behaviour = elgg_echo('publications:settings:bibtex_import_behaviour') . ' ';
$import_behaviour .= elgg_view('input/select', [
	'name' => 'params[bibtex_import_behaviour]',
	'options_values' => $bibtex_import_behaviour,
	'value' => $plugin->bibtex_import_behaviour,
]);
echo elgg_format_element('div', [], $import_behaviour);

