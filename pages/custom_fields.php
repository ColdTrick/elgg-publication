<?php

// TODO: remove this as a seperate ajax loaded page and embed it into the edit form

gatekeeper();

$guid = get_input('guid');
$type = get_input('type', "book");
$entity = get_entity($guid);

if($entity){
	if (!$entity->canEdit()) {
		exit();
	}

	$journaltitle = $entity->journaltitle;
	$publisher = $entity->publisher;
	$publish_location = $entity->publish_location;
	$booktitle = $entity->booktitle;
	$book_editors = $entity->book_editors;
	$volume = $entity->volume;
	$page_from = $entity->page_from;
	$page_to = $entity->page_to;
	$pages = $entity->pages;

} else {
	$journaltitle = '';
	$publisher = '';
	$publish_location = '';
	$booktitle = '';
	$book_editors = '';
	$volume = '';
	$pages = '';
	$page_from = '';
	$page_to = '';
}

$required_text = elgg_echo("publications:forms:required");

$custom_field = "";

switch ($type) {
	case "article_book":
		$custom_field .= "<div><label>" . elgg_echo('publication:booktitle') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text', array('name' => 'booktitle', 'value' => $booktitle)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:book_editors') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/author_autocomplete', array('name' => 'book_editors', 'value' => $book_editors, 'id' => 'publications-book-editors')) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:publish_location') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text', array('name' => 'publish_location', 'value' => $publish_location)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:publisher') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text', array('name' => 'publisher', 'value' => $publisher)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:page_from') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text', array('name' => 'page_from', 'value' => $page_from)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:page_to') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text', array('name' => 'page_to', 'value' => $page_to)) . "</div>";

		break;
	case "article_journal":
		$custom_field .= "<div><label>" . elgg_echo('publication:journaltitle') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'journaltitle', 'value' => $journaltitle)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:volume') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'volume', 'value' => $volume)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:page_from') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'page_from', 'value' => $page_from)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:page_to') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'page_to', 'value' => $page_to)) . "</div>";

		break;
	case "book":
	default:
		$custom_field .= "<div><label>" . elgg_echo('publication:publish_location') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'publish_location', 'value' => $publish_location)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:publisher') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'publisher', 'value' => $publisher)) . "</div>";

		$custom_field .= "<div><label>" . elgg_echo('publication:pages') . "<span class='elgg-quiet mls'>$required_text</span></label><br/>";
		$custom_field .= elgg_view('input/text',array('name' => 'pages', 'value' => $pages)) . "</div>";

		break;
}

echo $custom_field;
exit();