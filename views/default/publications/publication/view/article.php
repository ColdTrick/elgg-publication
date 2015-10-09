<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

$details = "<tr><td><label>" . elgg_echo('publication:journaltitle') . ":</label></td><td>" . $entity->journaltitle . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:number') . ":</label></td><td>" . $entity->number . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:page_from') . ":</label></td><td>" . $entity->page_from . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:page_to') . ":</label></td><td>" . $entity->page_to . "</td></tr>";

echo $details;
