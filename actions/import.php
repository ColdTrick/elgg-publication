<?php

if (!publications_bibtex_enabled()) {
	register_error(elgg_echo('publication:error:bibtext:enabled'));
	forward(REFERER);
}

// Get input data
$data = get_uploaded_file('bibtex_import');
if (empty($data)) {
	register_error(elgg_echo('publication:bibtex:fileerror'));
	forward(REFERER);
}

$forward_to_edit = (bool) get_input('forward_to_edit', 1);

$entries = \AudioLabs\BibtexParser\BibtexParser::parse_string($data);
if (empty($entries)) {
	register_error(elgg_echo('publication:bibtex:blank'));
	forward(REFERER);
}

$dbprefix = elgg_get_config('dbprefix');
$exists_options = [
	'type' => 'object',
	'subtype' => Publication::SUBTYPE,
	'count' => true,
	'joins' => ["JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid"],
];

$entity_attributes = [
	'guid',
	'type',
	'subtype',
	'owner_guid',
	'site_guid',
	'container_guid',
	'access_id',
	'time_created',
	'time_updated',
	'last_action',
	'enabled',
	'title',
	'description',
];
$processed_entry_fields = [
	'raw',
	'type',
	'title',
	'reference',
	'lines',
	'pages',
	'author',
	'journal',
];

// a bibtex file can have multiple entries
$count = 0;
$duplicates = 0;
$forward_url = REFERER;
foreach ($entries as $entry) {
	
	$type = elgg_extract('type', $entry);
	
	// check if publication already exists in the system
	$title = elgg_extract('title', $entry);
	$title = \AudioLabs\BibtexParser\BibtexParser::cleanup($title);
	if (empty($title)) {
		// no title, can't continue
		continue;
	}
	
	$exists_options['wheres'] = ['oe.title = "' . sanitize_string($title) . '"'];
	if (elgg_get_entities($exists_options)) {
		// this item already exitst
		$duplicates++;
		continue;
	}
	
	$publication = new Publication();
	$publication->access_id = ACCESS_LOGGED_IN;
	$publication->title = $title;
	$publication->description = elgg_extract('reference', $entry);
	if (!$publication->save()) {
		// unable to save
		continue;
	}
	
	// set forwarding
	$count++;
	if ($forward_to_edit) {
		$forward_url = "publications/edit/{$publication->getGUID()}";
	} else {
		$forward_url = $publication->getURL();
	}
	
	// start handling some custom fields
	// start/end page
	$pages = elgg_extract('pages', $entry);
	$pages = \AudioLabs\BibtexParser\BibtexParser::cleanup($pages);
	if (is_array($pages)) {
		$publication->page_from = elgg_extract('start', $pages);
		$publication->page_to = elgg_extract('end', $pages);
	} else {
		$publication->page_from = $pages;
	}
	
	// authors
	$authors = elgg_extract('author', $entry);
	$authors = \AudioLabs\BibtexParser\BibtexParser::cleanup($authors);
	if (!empty($authors)) {
		$new_authors = [];
		foreach ($authors as $author) {
			$new_authors[] = trim(str_ireplace(',', '', $author), '"');
		}
		
		$publication->authors = implode(',', $new_authors);
	}
	$publication->addAuthor(elgg_get_logged_in_user_guid());
	
	// journal
	$journal = elgg_extract('journal', $entry);
	$journal = \AudioLabs\BibtexParser\BibtexParser::cleanup($journal);
	if (!empty($journal)) {
		$publication->journaltitle = $journal;
	}
	
	// handle all other fields from the bibtex file
	foreach ($entry as $field_name => $field_value) {
		
		if (in_array($field_name, $entity_attributes)) {
			// reserved entity attributes
			continue;
		}
		
		if (in_array($field_name, $processed_entry_fields)) {
			// already handled this custom
			continue;
		}
		
		$field_value = \AudioLabs\BibtexParser\BibtexParser::cleanup($field_value);
		$publication->$field_name = $field_value;
	}
	
	$publication->save();
}

if (empty($count) && empty($duplicates)) {
	// no imports, no duplicates
	register_error(elgg_echo('publication:action:import:error:none'));
	forward(REFERER);
} elseif ($count === 1) {
	// single imported
	system_message(elgg_echo('publication:action:import:success:single'));
	forward($forward_url);
} else {
	// multiple imports
	if (!empty($count) && !empty($duplicates)) {
		system_message(elgg_echo('publication:action:import:success:multiple_duplicates', [$count, $duplicates]));
	} elseif (!empty($count)) {
		system_message(elgg_echo('publication:action:import:success:multiple', [$count]));
	} elseif (!empty($duplicates)) {
		system_message(elgg_echo('publication:action:import:success:duplicates', [$duplicates]));
	}
	forward('publications/all');
}
