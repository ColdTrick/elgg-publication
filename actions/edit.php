<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$guid = (int) get_input('guid');
$title = get_input('publicationtitle');
$abstract = get_input('publicationabstract');
$access = get_input('access_id');
$keywords = get_input('publicationkeywords');
$author_guids = get_input('authors');

$author_text = get_input("authors_text");
$authors_order = get_input("authors_order");
$uri = get_input('uri');
$type = get_input('type');
$year = get_input('year');
$journaltitle = get_input('journaltitle');
$publisher = get_input('publisher');
$publish_location = get_input('publish_location');
$booktitle = get_input('booktitle');
$number = get_input('number');
$pages = get_input('pages');
$page_from = get_input('page_from');
$page_to = get_input('page_to');
$translation = get_input('translation');
$promotion = get_input('promotion');
$book_editors_guids = get_input("book_editors");

$book_editors_text = get_input("book_editors_text");

if (empty($author_guids) && empty($author_text)) {
	register_error(elgg_echo("publication:blankauthors"));
	forward(REFERER);
}

if (!in_array($type, ["book", "article_book", "article_journal"])) {
	$type = "article_book";
}

if (empty($title) || empty($type)) {
	register_error(elgg_echo("publication:blank"));
	forward(REFERER);
}

switch ($type) {
	case "article_book":
		if (empty($booktitle) || empty($publish_location) || empty($publisher) || empty($page_from) || empty($page_to) || (empty($book_editors_guids) && empty($book_editors_text))) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}
		
		break;
	case "article_journal":
		if (empty($journaltitle) || empty($number) || empty($page_from) || empty($page_to)) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}
		
		break;
	case "book":
	default:
		if (empty($publish_location) || empty($publisher) || empty($pages)) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}

		break;
}

$publication = get_entity($guid);
if (empty($publication)) {
	register_error(elgg_echo("InvalidParameterException:GUIDNotFound", [$guid]));
	forward("publications/all");
}

if (($publication->getSubtype() !== "publication") || $publication->canEdit()) {
	forward("publications/all");
}

// files
$file_contents = get_uploaded_file("attachment");
if (!empty($file_contents)) {
	
	$fh = new ElggFile();
	$fh->owner_guid = $publication->getGUID();
	$file_name = $_FILES["attachment"]["name"];
	$mime = $_FILES["attachment"]["type"];
	$fh->setFilename($file_name);
	
	if ($fh->open("write")) {
		$fh->write($file_contents);
		$fh->close();
		
		$publication->attached_file = $file_name;
		$publication->attached_file_mime_type = $mime;
	}
}

$tagarray = string_to_tag_array($keywords);

$publication->access_id = $access;
$publication->title = $title;
$publication->description = $abstract;
if (!$publication->save()) {
	register_error(elgg_echo("publication:error"));
	forward(REFERER);
}

$publication->tags = $tagarray;

$publication->uri = $uri;
$publication->year = $year;
$publication->pubtype = $type;
$publication->journaltitle = $journaltitle;
$publication->booktitle = $booktitle;
$publication->publisher = $publisher;
$publication->publish_location = $publish_location;
$publication->number = $number;
$publication->pages = $pages;
$publication->page_from = $page_from;
$publication->page_to = $page_to;
$publication->translation = $translation;
$publication->promotion = $promotion;

$publication->clearRelationships();

// save authors
if (!empty($author_guids)) {
	foreach ($author_guids as $author) {
		add_entity_relationship($publication->getGUID(), 'author', $author);
	}
}

if (!empty($author_guids) && !empty($author_text)) {
	$pauthors = array_merge($author_guids, $author_text);
} elseif (!empty($author_guids)) {
	$pauthors  = $author_guids;
} elseif (!empty($author_text)) {
	$pauthors = $author_text;
} else {
	$pauthors = [];
}
$pauthors = implode(',', $authors_order);
$publication->authors = $pauthors;

// save book editors
if (!empty($book_editors_guids)) {
	foreach ($book_editors_guids as $book_editor) {
		add_entity_relationship($publication->getGUID(), 'book_editor', $book_editor);
	}
}

if (!empty($book_editors_guids) && !empty($book_editors_text)) {
	$pbook_editors = array_merge($book_editors_guids, $book_editors_text);
} elseif (!empty($book_editors_guids)) {
	$pbook_editors  = $book_editors_guids;
} elseif (!empty($book_editors_text)) {
	$pbook_editors = $book_editors_text;
} else {
	$pbook_editors = [];
}

$pbook_editors = implode(',', $pbook_editors);

$publication->book_editors = $pbook_editors;

system_message(elgg_echo("publication:posted"));

/* todo: activate add_to_river on settings */
#add_to_river('river/object/publication/update','update',$_SESSION['user']->guid,$publication->guid);

forward($publication->getURL());
