<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

$details = "<tr><td><label>" . elgg_echo('publication:year') . ":</label></td><td>" . $entity->year . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:month') . ":</label></td><td>" . $entity->month . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:volume') . ":</label></td><td>" . $entity->volume . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:number') . ":</label></td><td>" . $entity->number . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:series') . ":</label></td><td>" . $entity->series . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:publish_location') . ":</label></td><td>" . $entity->publish_location . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:organization') . ":</label></td><td>" . $entity->organization . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:publisher') . ":</label></td><td>" . $entity->publisher . "</td></tr>";

echo $details;
