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

// import behaviour
$import_behaviour = elgg_get_plugin_setting('bibtex_import_behaviour', 'publications', 'skip');
// default: skip
$skip_duplicates = true;
switch ($import_behaviour) {
	case 'update':
		// always update
		$skip_duplicates = false;
		break;
	case 'user_skip':
	case 'user_update':
		// user can shoose to update/skip
		$user_update_setting = get_input('user_update_setting');
		$skip_duplicates = ($user_update_setting !== 'update');
		break;
}

// load lib
publications_load_bibtex_browser();

$parser = new BibDataBase();
$parser->load($_FILES['bibtex_import']['tmp_name']);
$entries = $parser->getEntries();
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
	'x-bibtex-type',
	'key',
	'title',
	'timestamp',
	'lines',
	'pages',
	'author',
	'_author',
	'editor',
	'journal',
];

// a bibtex file can have multiple entries
$count = 0;
$duplicates = 0;
$forward_url = REFERER;

$ia = elgg_set_ignore_access(true);

foreach ($entries as $ref => $entry) {
	$publication = false;
	
	if (!($entry instanceof BibEntry)) {
		continue;
	}
	
	$type = $entry->getType();
	$type = strtolower($type);
	
	// check if publication already exists in the system
	$title = $entry->getTitle();
	if (empty($title)) {
		// no title, can't continue
		continue;
	}
	
	$exists_options['wheres'] = ['oe.title = "' . sanitize_string($title) . '"'];
	$existing_count = elgg_get_entities($exists_options);
	if (!empty($existing_count) && $skip_duplicates) {
		// this item already exitst
		$duplicates++;
		continue;
	} elseif (!empty($existing_count) && !$skip_duplicates) {
		// fetch existing
		$options = $exists_options;
		$options['count'] = false;
		
		$publications = elgg_get_entities($options);
		$publication = $publications[0];
	} else {
		// create new
		$publication = new Publication();
		$publication->access_id = ACCESS_LOGGED_IN;
		$publication->title = $title;
		if (!$publication->save()) {
			// unable to save
			continue;
		}
	}
	
	if (!($publication instanceof Publication)) {
		// something went wrong
		continue;
	}
	
	$publication->bibtext_reference = $ref;
	$publication->pubtype = $type;
	
	// set forwarding
	$count++;
	if ($forward_to_edit) {
		$forward_url = "publications/edit/{$publication->getGUID()}";
	} else {
		$forward_url = $publication->getURL();
	}
	
	// start handling some custom fields
	// start/end page
	$pages = $entry->getPages();
	if (is_array($pages)) {
		$publication->page_from = elgg_extract('0', $pages);
		$publication->page_to = elgg_extract('1', $pages);
	} else {
		$publication->page_from = $pages;
	}
	
	// authors
	$authors = $entry->getRawAuthors();
	if (!empty($authors)) {
		$new_authors = [];
		foreach ($authors as $author) {
			if (strtolower($author) === 'unknown') {
				continue;
			}
			
			$new_authors[] = trim(str_ireplace(',', '', $author), '"');
		}
		
		// filter duplicate authors (from previous import)
		$new_authors = array_unique($new_authors);
		
		$publication->authors = implode(',', $new_authors);
	}
	
	// editors
	$editors = $entry->getEditors();
	if (!empty($editors)) {
		$new_editors = [];
		foreach ($editors as $editor) {
			if (strtolower($editor) === 'unknown') {
				continue;
			}
			
			$new_editors[] = trim(str_ireplace(',', '', $editor), '"');
		}
		
		// filter duplicate editors (from previous import)
		$new_editors = array_unique($new_editors);
		
		$publication->book_editors = implode(',', $new_editors);
	}
	
	// journal
	$journal = $entry->getField('journal');
	if (!empty($journal)) {
		$publication->journaltitle = $journal;
	}
	
	// handle all other fields from the bibtex file
	$other_fields = $entry->getFields();
	foreach ($other_fields as $field_name => $field_value) {
		
		if (in_array($field_name, $entity_attributes)) {
			// reserved entity attributes
			continue;
		}
		
		if (in_array($field_name, $processed_entry_fields)) {
			// already handled this custom
			continue;
		}
		
		$publication->$field_name = $field_value;
	}
	
	$publication->save();
}

// restore access
elgg_set_ignore_access($ia);

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
		register_error(elgg_echo('publication:action:import:success:multiple_duplicates', [$count, $duplicates]));
	} elseif (!empty($count)) {
		system_message(elgg_echo('publication:action:import:success:multiple', [$count]));
	} elseif (!empty($duplicates)) {
		register_error(elgg_echo('publication:action:import:success:duplicates', [$duplicates]));
	}
	$user = elgg_get_logged_in_user_entity();
	forward("publications/owner/{$user->username}");
}
