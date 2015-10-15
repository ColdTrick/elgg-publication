<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

if ($entity->uri) {
	echo '<tr>';
	echo '<td><label>' . elgg_echo('publication:uri') . ':</label></td>';
	echo '<td>' . elgg_view('output/url', [
		'href' => $entity->uri
	]) . '</td>';
	echo '</tr>';
}

/* Client specific data */
if ($entity->translation) {
	echo '<tr>';
	echo '<td colspan="2"><label>' . elgg_echo('publications:details:translation') . '</label></td>';
	echo '</tr>';
}

if ($entity->promotion) {
	echo '<tr>';
	echo '<td colspan="2"><label>' . elgg_echo('publications:details:promotion') . '</label></td>';
	echo '</tr>';
}
