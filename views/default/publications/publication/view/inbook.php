<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

$details = "<tr><td><label>" . elgg_echo('publication:booktitle') . ":</label></td><td>" . $entity->booktitle . "</td></tr>";

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

echo $details;
