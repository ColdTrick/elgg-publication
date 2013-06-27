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
$journal = get_input('journal');
$publisher = get_input('publisher');
$booktitle = get_input('booktitle');
$school = get_input('school');
$institution = get_input('institution');
$volume = get_input('volume');
$number = get_input('number');
$pages = get_input('number');
$month = get_input('month');
$note = get_input('note');
$series = get_input('series');
$address = get_input('address');
$edition = get_input('edition');
$organization = get_input('organization');
$type_field = get_input('type_field');

if (empty($author_guids) && empty($author_text)) {
	register_error(elgg_echo("publication:blankauthors"));
	forward(REFERER);
}
$attachment = get_input('attachment_guid');

// Convert string of tags into a preformatted array
$tagarray = string_to_tag_array($keywords);

// Make sure the title / description aren't blank
if (empty($title)) {
	register_error(elgg_echo("publication:blank"));
	forward($_SERVER['HTTP_REFERER']);
}


if($type == 'ARTICLE'){
	if(empty($journal) || empty($year)){
		register_error(elgg_echo("publication:blankdefault"));
		forward($_SERVER['HTTP_REFERER']);
	}
}else if($type =='INPROCEEDINGS'){
	if(empty($booktitle) || empty($year)){
		register_error(elgg_echo("publication:blankdefault"));
		forward($_SERVER['HTTP_REFERER']);
	}
}else if($type =='BOOK'){
	if(empty($publisher) || empty($year)){
		register_error(elgg_echo("publication:blankdefault"));
		forward($_SERVER['HTTP_REFERER']);
	}
}else if($type =='PHDTHESIS' || $type == 'MASTERSTHESIS'){
	if(empty($school) || empty($year)){
		register_error(elgg_echo("publication:blankdefault"));
		forward($_SERVER['HTTP_REFERER']);
	}
}else if($type == 'TECHREPORT'){
	if(empty($institution) || empty($year)){
		register_error(elgg_echo("publication:blankdefault"));
		forward($_SERVER['HTTP_REFERER']);
	}
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
	forward($_SERVER['HTTP_REFERER']);
}
if (is_array($tagarray)) {
	$publication->tags = $tagarray;
}

$publication->uri = $uri;
$publication->year = $year;
$publication->pubtype = $type;
$publication->journal = $journal;
$publication->booktitle = $booktitle;
$publication->school = $school;
$publication->institution = $institution;
$publication->volume = $volume;
$publication->number = $number;
$publication->pages = $pages;
$publication->month = $month;
$publication->note = $note;
$publication->series = $series;
$publication->address = $address;
$publication->edition = $edition;
$publication->organization = $organization;
$publication->type_field = $type_field;
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

$publication->attachment = $attachment;

system_message(elgg_echo("publication:posted"));
add_to_river('river/object/publication/create','create', $_SESSION['user']->guid, $publication->guid);
	
$page_owner = get_entity($publication->container_guid);
if ($page_owner instanceof ElggUser) {
	forward("publications/" . $page_owner->username);
} else if ($page_owner instanceof ElggGroup) {
	forward("publications/group/" . $page_owner->getGUID() . "/all");
}
