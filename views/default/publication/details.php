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

if (!in_array($type, array("book", "article_book", "article_journal"))) {
	$type = "article_book";
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

$details .= "<tr><td><label>" . elgg_echo("publication:type") . ":</label></td><td>" . elgg_echo("publications:type:" . $type) . "</td></tr>";

switch ($type) {
	case "article_book":

		$details .= "<tr><td><label>" . elgg_echo('publication:booktitle') . ":</label></td><td>" . $entity->booktitle . "</td></tr>";

		// book_editors


		$details .= "<tr><td><label>" . elgg_echo('publication:publish_location') . ":</label></td><td>" . $entity->publish_location . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:publisher') . ":</label></td><td>" . $entity->publisher . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_from') . ":</label></td><td>" . $entity->page_from . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_to') . ":</label></td><td>" . $entity->page_to . "</td></tr>";

		break;
	case "article_journal":

		$details .= "<tr><td><label>" . elgg_echo('publication:journaltitle') . ":</label></td><td>" . $entity->journaltitle . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:volume') . ":</label></td><td>" . $entity->volume . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_from') . ":</label></td><td>" . $entity->page_from . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_to') . ":</label></td><td>" . $entity->page_to . "</td></tr>";

		break;
	case "book":
	default:
		$details .= "<tr><td><label>" . elgg_echo('publication:publish_location') . ":</label></td><td>" . $entity->publish_location . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:publisher') . ":</label></td><td>" . $entity->publisher . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:pages') . ":</label></td><td>" . $entity->pages . "</td></tr>";

		break;
}

if ($entity->uri) {
	$details .= "<tr><td><label>" . elgg_echo('publication:uri') . ":</label></td><td>" . elgg_view("output/url", array("value" => $entity->uri)) . "</td></tr>";
}

$details .= "<tr><td><label>" . elgg_echo('publications:details:translation') . ":</label></td><td>";
if ($entity->translation) {
	$details .= elgg_echo("option:yes");
} else {
	$details .= elgg_echo("option:no");
}
$details .= "</td></tr>";

$details .= "<tr><td><label>" . elgg_echo('publications:details:promotion') . ":</label></td><td>";
if ($entity->promotion) {
	$details .= elgg_echo("option:yes");
} else {
	$details .= elgg_echo("option:no");
}
$details .= "</td></tr>";

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

if ($attached_file = $entity->attached_file) {
	$download_link = elgg_view("output/url", array("text" => elgg_echo("publications:details:attachment:download"), "href" => "publications/download_attachment/" . $entity->getGUID(), "class" => "elgg-button elgg-button-action"));
	echo elgg_view_module("info", elgg_echo('publication:attachment:title'), $download_link);
}


echo elgg_view_module("info", elgg_echo('publication:details'), $details);
