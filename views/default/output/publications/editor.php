<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof Publication)) {
	return;
}

// book_editors
if (empty($entity->book_editors)) {
	return;
}

$book_editors = $entity->book_editors;
$book_editors = explode(',', $book_editors);

if (!is_array($book_editors)) {
	$book_editors = [$book_editors];
}

$book_editors_content = "";

foreach ($book_editors as $book_editor) {
	if (empty($book_editor)) {
		continue;
	}

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

echo  "<tr>";
echo "<td><label>" . elgg_echo('publication:book_editors') . ":</label></td>";
echo "<td>" . $book_editors_content . "</td>";
echo "</tr>";
