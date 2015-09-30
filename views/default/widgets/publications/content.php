<?php

/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$widget = $vars["entity"];

//the number of publications to display
$number = (int) $widget->num_display;
if ($number < 1) {
	$number = 4;
}

$publications = elgg_list_entities_from_relationship([
	"type" => "object",
	"subtype" => "publication",
	"relationship" => "author",
	"relationship_guid" => $widget->getOwnerGUID(),
	"inverse_relationship" => true,
	"limit" => $number,
]);

if (empty($publications)) {
	return;
}

echo elgg_format_element('div', ['id' => 'publicationwidget'], $publications);
