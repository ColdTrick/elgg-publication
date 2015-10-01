<?php

$entity = elgg_extract("entity", $vars);

$details = "";
$authors_content = "";

$type = $entity->pubtype;

$authors = $entity->authors;
$authors = explode(',', $authors);

if (!(is_array($authors))) {
	$authors = [$authors];
}

if (!in_array($type, ["book", "article_book", "article_journal"])) {
	$type = "article_book";
}

foreach ($authors as $author) {
	if (!ctype_digit($author)) {
		$authors_content .= elgg_view('publications/authorinvite', [
			'exauthor' => $author,
			'publication_guid' => $entity->getGUID(),
			'canedit' => $entity->canEdit()
		]);
	} else {
		$user = get_entity($author);
		if (!empty($user)) {
			$authors_content .= elgg_view_entity($user, ["full_view" => false]);
		}
	}
}

$details .= "<table class='elgg-table mbm'>";

$details .= "<tr><td><label>" . elgg_echo("publication:type") . ":</label></td><td>" . elgg_echo("publications:type:" . $type) . "</td></tr>";

switch ($type) {
	case "article_book":

		$details .= "<tr><td><label>" . elgg_echo('publication:booktitle') . ":</label></td><td>" . $entity->booktitle . "</td></tr>";

		// book_editors
		if ($entity->book_editors) {
			$book_editors = $entity->book_editors;
			$book_editors = explode(',', $book_editors);
			$book_editors_content = "";
			if (!is_array($book_editors)) {
				$book_editors = [$book_editors];
			}
			
			foreach ($book_editors as $book_editor) {
				if (is_numeric($book_editor)) {
					// existing user
					$user = get_user($book_editor);
					if (!empty($user)) {
						$book_editors_content .= elgg_view_entity($user, ["full_view" => false]);
					}
				} else {
					// free text editor
					$book_editors_content .= elgg_view('publications/authorinvite', [
						'exauthor' => $book_editor,
						'publication_guid' => $entity->getGUID(),
						'canedit' => $entity->canEdit()
					]);
				}
			}
			
			$details .= "<tr><td><label>" . elgg_echo('publication:book_editors') . ":</label></td><td>" . $book_editors_content . "</td></tr>";
		}

		$details .= "<tr><td><label>" . elgg_echo('publication:publish_location') . ":</label></td><td>" . $entity->publish_location . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:publisher') . ":</label></td><td>" . $entity->publisher . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_from') . ":</label></td><td>" . $entity->page_from . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:page_to') . ":</label></td><td>" . $entity->page_to . "</td></tr>";

		break;
	case "article_journal":

		$details .= "<tr><td><label>" . elgg_echo('publication:journaltitle') . ":</label></td><td>" . $entity->journaltitle . "</td></tr>";
		$details .= "<tr><td><label>" . elgg_echo('publication:number') . ":</label></td><td>" . $entity->number . "</td></tr>";
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
	$details .= "<tr><td><label>" . elgg_echo('publication:uri') . ":</label></td><td>" . elgg_view("output/url", ["href" => $entity->uri]) . "</td></tr>";
}

/* Client specific data */
if ($entity->translation) {
	$details .= "<tr><td colspan='2'><label>" . elgg_echo('publications:details:translation') . "</label></td></tr>";
}

if ($entity->promotion) {
	$details .= "<tr><td colspan='2'><label>" . elgg_echo('publications:details:promotion') . "</label></td></tr>";
}

$details .= "</table>";

if (!empty($entity->attachment)) {
	$attachment = get_entity($entity->attachment);
	if (!empty($attachment)) {
		$details .= '<label>' .elgg_echo('publication:attachment:title'). ":</label> ";
		$details .= elgg_view("output/url", ["href" => $attachment->getURL(), "text" => $attachment->title]) . "<br /><br />";
	}
}

if ($authors) {
	echo elgg_view_module("info", elgg_echo('publication:authors'), $authors_content);
}

if ($entity->description) {
	echo elgg_view_module("info", elgg_echo('publication:abstract'), elgg_view('output/longtext', ['value' => $entity->description]));
}

$attached_file = $entity->attached_file;
if (!empty($attached_file)) {
	$download_link = elgg_view("output/url", [
		"text" => elgg_echo("publications:details:attachment:download"),
		"href" => "publications/download_attachment/{$entity->getGUID()}",
		"class" => "elgg-button elgg-button-action"
	]);
	echo elgg_view_module("info", elgg_echo('publication:attachment:title'), $download_link);
}


echo elgg_view_module("info", elgg_echo('publication:details'), $details);
