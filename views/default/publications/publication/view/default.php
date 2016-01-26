<?php
/**
 * Default Fields
 */

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

$details = "<tr><td><label>" . elgg_echo('publication:doi') . ":</label></td><td>" . $entity->doi . "</td></tr>";
$details .= "<tr><td><label>" . elgg_echo('publication:url') . ":</label></td><td>" . elgg_view("output/url",['href'=>$entity->url]) . "</td></tr>";

echo $details;
