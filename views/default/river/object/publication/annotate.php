<?php

$statement = elgg_extract('statement', $vars);

$performed_by = $statement->getSubject();
$object = $statement->getObject();

$url = elgg_view('output/url', [
	'text' => $performed_by->name,
	'href' => $performed_by->getURL(),
]);

$string = elgg_echo('publication:river:posted', [$url]) . ' ';
$string .= elgg_echo('publication:river:annotate:create') . ' ';
$string .= elgg_view('output/url', [
	'text' => $object->title,
	'href' => $object->getURL(),
]);

echo $string;