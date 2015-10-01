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
$access = (int) get_input('access_id');

$keywords = get_input('publicationkeywords');

$author_guids = get_input('authors');
$authors_order = get_input('authors_order');

$data = (array) get_input('data', []);

$uri = get_input('uri');
$type = get_input('type');
$year = get_input('year');
$translation = get_input('translation');
$promotion = get_input('promotion');

if (empty($title) || empty($type) || empty($authors_order) || empty($year)) {
	register_error(elgg_echo('publication:blank'));
	forward(REFERER);
}

$types = publications_get_types();
if (!in_array($type, $types)) {
	register_error(elgg_echo('publication:type_not_supported'));
	forward(REFERER);
}

// allow the validation of custom type data
$input_validation = elgg_trigger_plugin_hook("input_validation:$type", 'publications', [], true);
if ($input_validation !== true) {
	// input validation failed, errors should be set by the plugin hook
	forward(REFERER);
}

$new_entity = true;
if (!empty($guid)) {
	$publication = get_entity($guid);
	if (empty($publication)) {
		register_error(elgg_echo('InvalidParameterException:GUIDNotFound', [$guid]));
		forward('publications/all');
	}
	
	if (!($publication instanceof Publication) || !$publication->canEdit()) {
		forward('publications/all');
	}
	
	$new_entity = false;
} else {
	$publication = new Publication();
	$publication->owner_guid = elgg_get_logged_in_user_guid();
	$publication->container_guid = (int) get_input('container_guid', elgg_get_logged_in_user_guid());
	$publication->access_id = $access;
	$publication->title = $title;
	$publication->description = $abstract;
	
	if (!$publication->save()) {
		register_error(elgg_echo('publication:error'));
		forward(REFERER);
	}
}

$tagarray = string_to_tag_array($keywords);

$publication->access_id = $access;
$publication->title = $title;
$publication->description = $abstract;
if (!$publication->save()) {
	register_error(elgg_echo('publication:error'));
	forward(REFERER);
}

$publication->tags = $tagarray;
$publication->uri = $uri;
$publication->year = $year;
$publication->pubtype = $type;
$publication->translation = $translation;
$publication->promotion = $promotion;

$publication->deleteRelationships('author');

// save authors
if (!empty($author_guids)) {
	foreach ($author_guids as $author) {
		add_entity_relationship($publication->getGUID(), 'author', $author);
	}
}

$pauthors = implode(',', $authors_order);
$publication->authors = $pauthors;

// save custom data
foreach ($data as $key => $value) {
	$publication->$key = $value;
}

// trigger event to save other custom data
elgg_trigger_event('save:data', 'publications', $publication);

// files
$file_contents = get_uploaded_file('attachment');
if (!empty($file_contents)) {

	$fh = new ElggFile();
	$fh->owner_guid = $publication->getGUID();
	$file_name = $_FILES['attachment']['name'];
	$mime = $_FILES['attachment']['type'];
	$fh->setFilename($file_name);

	if ($fh->open('write')) {
		$fh->write($file_contents);
		$fh->close();

		$publication->attached_file = $file_name;
		$publication->attached_file_mime_type = $mime;
	}
}

$publication->save();
if ($new_entity) {
	elgg_create_river_item([
		'view' => 'river/object/publication/create',
		'action_type' => 'create',
		'subject_guid' => $publication->getOwnerGUID(),
		'object_guid' => $publication->getGUID(),
		'target_guid' => $publication->getContainerGUID(),
		'access_id' => $publication->access_id,
	]);
}

system_message(elgg_echo('publication:posted'));

/* todo: activate add_to_river on settings */
#add_to_river('river/object/publication/update','update',$_SESSION['user']->guid,$publication->guid);

forward($publication->getURL());
