<?php

$entity = elgg_extract("entity", $vars);

$details = "";
$authors_content = "";

$type = $entity->pubtype;

$authors = $entity->authors;
$authors = explode(',',$authors);

if(!(is_array($authors))) {
	$authors = array($authors);
}

foreach($authors as $author){
	if(!ctype_digit($author)) {
		$authors_content .= elgg_view('publication/authorinvite', array('exauthor' => $author, 'publication_guid' => $entity->getGUID(), 'canedit' => $entity->canEdit()));
	} else {
		if ($user = get_entity($author)) {
			$authors_content .= elgg_view_entity($user, array("full_view" => false));
		}
	}
}

$details .= "<table class='elgg-table mbm'>";

$details .= "<tr><td><label>" . elgg_echo("publication:type") . ":</label></td><td>" . $type . "</td></tr>";

if($type == 'ARTICLE'){
	$field_title = 'Journal';
	$field_text = $entity->journal;
} else if($type == 'INPROCEEDINGS') {
	$field_title = 'Booktitle';
	$field_text = $entity->booktitle;
} else if($type == 'BOOK') {
	$field_title = 'Publisher';
	$field_text = $entity->publisher;
} else if($type == 'PHDTHESIS' || $type == 'MASTERSTHESIS') {
	$field_title = 'School';
	$field_text = $entity->school;
} else if($type == 'TECHREPORT') {
	$field_title = 'Institution';
	$field_text = $entity->institution;
}

$details .= "<tr><td><label>" . $field_title . ":</label></td><td>" . $field_text . "</td></tr>";

if (!empty($entity->month)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:month") . ":</label></td><td>" . $entity->month . "</td></tr>";
}

if (!empty($entity->year)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:year") . ":</label></td><td>" . $entity->year . "</td></tr>";
}

if (!empty($entity->organization)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:organization") . ":</label></td><td>" . $entity->organization . "</td></tr>";
}

if (!empty($entity->edition)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:edition") . ":</label></td><td>" . $entity->edition . "</td></tr>";
}

if (!empty($entity->type_field)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:type_field") . ":</label></td><td>" . $entity->type_field . "</td></tr>";
}

if (!empty($entity->volume)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:volume") . ":</label></td><td>" . $entity->volume . "</td></tr>";
}

if (!empty($entity->number)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:number") . ":</label></td><td>" . $entity->number . "</td></tr>";
}

if (!empty($entity->series)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:series") . ":</label></td><td>" . $entity->series . "</td></tr>";
}

if (!empty($entity->address)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:address") . ":</label></td><td>" . $entity->address . "</td></tr>";
}

if (!empty($entity->pages)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:pages") . ":</label></td><td>" . $entity->pages . "</td></tr>";
}

if (!empty($entity->uri)) {
	$uri = elgg_view("output/url", array("href" => $entity->uri, "target" => "_blank"));
	$details .= "<tr><td><label>" . elgg_echo("publication:uri") . ":</label></td><td>" . $uri . "</td></tr>";
}

if (!empty($entity->url)) {
	$url = elgg_view("output/url", array("href" => $entity->url, "target" => "_blank"));
	$details .= "<tr><td><label>" . elgg_echo("publication:url") . ":</label></td><td>" . $url . "</td></tr>";
}

if (!empty($entity->doi)) {
	$details .= "<tr><td><label>" . elgg_echo("publication:doi") . ":</label></td><td>" . $entity->doi . "</td></tr>";
}

$details .= "</table>";

if(!empty($entity->attachment)){
	if ($attachment = get_entity($entity->attachment)) {
		$details .= '<label>' .elgg_echo('publication:attachment:title'). ":</label> ". elgg_view("output/url", array("href" => $attachment->getUrl(), "text" => $attachment->title)) . "<br /><br />";
	}
}

if ($authors) {
	echo elgg_view_module("info", elgg_echo('publication:authors'), $authors_content);
}

if ($entity->description) {
	echo elgg_view_module("info", elgg_echo('publication:abstract'), elgg_view('output/longtext', array('value' => $entity->description)));
}

echo elgg_view_module("info", elgg_echo('publication:details'), $details);
