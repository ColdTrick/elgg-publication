<?php

$entity = elgg_extract('entity', $vars);

$value = '';
if ($entity instanceof Publication) {
	$value = $entity->pubtype;
}

$label = elgg_format_element('label', ['for' => 'publications-type-selector'], elgg_echo('publication:type'));

$types = publications_get_types();
$type_options = [];
foreach ($types as $type_option) {
	$type_label = $type_option;
	if (elgg_language_key_exists("publications:type:{$type_option}")) {
		$type_label = elgg_echo("publications:type:{$type_option}");
	}
	$type_options[$type_option] = $type_label;
}

$params = [
	'id' => 'publications-type-selector',
	'name' => 'type',
	'value' => $value,
	'options_values' => $type_options,
];
$params = $params + $vars;

$input = '<br />';
$input .= elgg_view('input/select', $params);

echo elgg_format_element('div', [], $label . $input);
echo elgg_format_element('div', ['id' => 'pub_custom_fields'], '');
