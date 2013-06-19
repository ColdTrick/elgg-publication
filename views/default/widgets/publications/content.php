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
if (!$number) {
	$number = 4;
}

$publications = elgg_get_entities_from_relationship(array(
		"type" => "object",
		"subtype" => "publication",
		"relationship" => "author",
		"relationship_guid" => $widget->owner_guid,
		"inverse_relationship" => true,
		"full_view" => false,
		"limit" => $number
	));

if($publications){

	echo "<div id=\"publicationwidget\">";

	foreach($publications as $publication){
		echo elgg_view_entity($publication);
	}
	echo "</div>";
}
