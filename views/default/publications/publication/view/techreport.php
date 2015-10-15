<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

$details = "<tr><td><label>" . elgg_echo('publication:year') . ":</label></td><td>" . $entity->year . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:month') . ":</label></td><td>" . $entity->month . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:institution') . ":</label></td><td>" . $entity->institution . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:number') . ":</label></td><td>" . $entity->number . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:publish_location') . ":</label></td><td>" . $entity->publish_location . "</td></tr>";

echo $details;
