<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

// show authors
$authors = $entity->authors;
$authors = explode(',', $authors);
if (!(is_array($authors))) {
	$authors = [$authors];
}

$authors_content = '';
foreach ($authors as $author) {
	
	if (empty($author)) {
		continue;
	}
	
	if (!ctype_digit($author)) {
		$authors_content .= elgg_view('publications/authorinvite', [
			'exauthor' => $author,
			'publication_guid' => $entity->getGUID(),
			'canedit' => $entity->canEdit()
		]);
	} else {
		$user = get_entity($author);
		if (!empty($user)) {
			$authors_content .= elgg_view_entity($user, ['full_view' => false]);
		}
	}
}

if (!empty($authors_content)) {
	echo elgg_view_module('info', elgg_echo('publication:authors'), $authors_content);
}

// description
if ($entity->description) {
	echo elgg_view_module('info', elgg_echo('publication:abstract'), elgg_view('output/longtext', ['value' => $entity->description]));
}

// attached file
$attached_file = $entity->attached_file;
if (!empty($attached_file)) {
	$download_link = elgg_view('output/url', [
		'text' => elgg_echo('publications:details:attachment:download'),
		'href' => "publications/download_attachment/{$entity->getGUID()}",
		'class' => 'elgg-button elgg-button-action'
	]);

	echo elgg_view_module('info', elgg_echo('publication:attachment:title'), $download_link);
}

// type details
$type = strtolower($entity->pubtype);
$type_string = $type;
if (elgg_language_key_exists("publications:type:$type")) {
	$type_string = elgg_echo("publications:type:$type");
}

$details = '<table class="elgg-table mbm">';

$details .= '<tr>';
$details .= '<td><label>' . elgg_echo('publication:type') . ':</label></td>';
$details .= '<td>' . $type_string . '</td>';
$details .= '</tr>';

// type specific data
if (elgg_view_exists("publications/publication/view/$type")) {
	$details .= elgg_view("publications/publication/view/$type", $vars);
}

// extending the results
$details .= elgg_view('publications/publication/view/extend', $vars);

$details .= '</table>';

// show attachtment
if (!empty($entity->attachment)) {
	$attachment = get_entity($entity->attachment);
	if (!empty($attachment)) {
		$details .= '<label>' .elgg_echo('publication:attachment:title'). ':</label> ';
		$details .= elgg_view('output/url', [
			'href' => $attachment->getURL(),
			'text' => $attachment->title
		]) . '<br /><br />';
	}
}

echo elgg_view_module('info', elgg_echo('publication:details'), $details);
