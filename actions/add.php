<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

// Get input data
$title = get_input('publicationtitle');
$abstract = get_input('publicationabstract');
$keywords = get_input('publicationkeywords');

$access = get_input('access_id');

$author_guids = get_input('authors');
$author_text = get_input("authors_text");
$uri = get_input('uri');
$type = get_input('type');
$year = get_input('year');
$journaltitle = get_input('journaltitle');
$publisher = get_input('publisher');
$publish_location = get_input('publish_location');
$booktitle = get_input('booktitle');
$volume = get_input('volume');
$pages = get_input('pages');
$page_from = get_input('page_from');
$page_to = get_input('page_to');
$translation = get_input('translation');
$promotion = get_input('promotion');

if (empty($author_guids) && empty($author_text)) {
	register_error(elgg_echo("publication:blankauthors"));
	forward(REFERER);
}

// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($keywords);

// Make sure the title / description aren't blank
if (empty($title) || empty($type)) {
	register_error(elgg_echo("publication:blank"));
	forward(REFERER);
}

switch($type) {
	case "article_book":
		if(empty($booktitle) || empty($publish_location) || empty($publisher) || empty($page_from) || empty($page_to)) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}

		break;
	case "article_journal":
		if(empty($journaltitle) || empty($volume) || empty($page_from) || empty($page_to)) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}

		break;
	case "book":
	default:
		if(empty($publish_location) || empty($publisher) || empty($pages)) {
			register_error(elgg_echo("publication:blankdefault"));
			forward(REFERER);
		}

		break;
}

$publication = new ElggObject();
$publication->subtype = "publication";
$publication->owner_guid = $_SESSION['user']->getGUID();
$publication->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
$publication->access_id = $access;
$publication->title = $title;
$publication->description = $abstract;
if (!$publication->save()) {
	register_error(elgg_echo("publication:error"));
	forward(REFERER);
}
if (is_array($tagarray)) {
	$publication->tags = $tagarray;
}

$publication->uri = $uri;
$publication->year = $year;
$publication->pubtype = $type;
$publication->journaltitle = $journaltitle;
$publication->booktitle = $booktitle;
$publication->publisher = $publisher;
$publication->publish_location = $publish_location;
$publication->volume = $volume;
$publication->pages = $pages;
$publication->page_from = $page_from;
$publication->page_to = $page_to;
$publication->translation = $translation;
$publication->promotion = $promotion;
$publication->clearRelationships();

if (!empty($author_guids)) {
	foreach ($author_guids as $author) {
		add_entity_relationship($publication->getGUID(), 'author', $author);
	}
}

//files
if($file_contents = get_uploaded_file("attachment")){
	$fh = new ElggFile();
	$fh->owner_guid = $publication->getGUID();
	$file_name = $_FILES["attachment"]["name"];
	$mime = $_FILES["attachment"]["type"];
	$fh->setFilename($file_name);

	if($fh->open("write")){
		$fh->write($file_contents);
		$fh->close();

		$publication->attached_file = $file_name;
		$publication->attached_file_mime_type = $mime;
	}
}

if (!empty($author_guids) && !empty($author_text)) {
	$pauthors = array_merge($author_guids, $author_text);
} elseif (!empty($author_guids)) {
	$pauthors  = $author_guids;
} elseif (!empty($author_text)) {
	$pauthors = $author_text;
} else {
	$pauthors = array();
}
$pauthors = implode(',', $pauthors);
$publication->authors = $pauthors;

system_message(elgg_echo("publication:posted"));
add_to_river('river/object/publication/create','create', $_SESSION['user']->guid, $publication->guid);

$page_owner = get_entity($publication->container_guid);
if ($page_owner instanceof ElggUser) {
	forward("publications/" . $page_owner->username);
} else if ($page_owner instanceof ElggGroup) {
	forward("publications/group/" . $page_owner->getGUID() . "/all");
}
