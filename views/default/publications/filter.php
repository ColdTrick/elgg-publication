<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 */

// create selection array

$selector = $vars["selector"];

// todo: enable correct filtering "owned"

$options = array (
	"publications-filter=all" => elgg_echo("publications:select:all"),
	//"publications-filter=owned" => elgg_echo("publications:select:owned"),
	"publications-filter=assigned" => elgg_echo("publications:select:assigned")
);

$params = array(
	'id' => 'publications-filter-selector',
	'options_values' => $options,
	'value' => 'publications-filter='.$selector
);

echo elgg_view('input/select', $params);
