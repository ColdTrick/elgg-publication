<?php

if (!publications_bibtex_enabled()) {
	register_error(elgg_echo('publication:error:bibtext:enabled'));
	forward(REFERER);
}

// Get input data
$data = get_uploaded_file("bibtex_import");
if (empty($data)) {
	register_error(elgg_echo("publication:bibtex:fileerror"));
	forward(REFERER);
}

// parse BibTex file
$parse = new PARSEENTRIES();
$parse->loadBibtexString($data);
$parse->extractEntries();

list($preamble, $strings, $entries, $undefinedStrings) = $parse->returnArrays();

if (empty($entries)) {
	register_error(elgg_echo('publication:bibtex:blank'));
	forward(REFERER);
}

foreach ($entries as $entry) {
	$found_name = false;
	$authors = [];
	$creator = new PARSECREATORS();
	$creatorArray = $creator->parse($entry['author']);
	foreach ($creatorArray as $author) {
		$name = "";
		foreach ($author as $a) {
			$name .= trim($a) . " ";
		}
		$name = trim($name);
		$authors[] = $name;
	}
	$authors = implode(',',$authors);

	//get all current publication and check for duplication
	$options = [
		'types' => 'object',
		'subtypes' => Publication::SUBTYPE,
		'limit'=> false
	];
	$all_pubs = new ElggBatch('elgg_get_entities', $options);
	foreach ($all_pubs as $cpubs) {
		if ($cpubs->title == $entry['title']) {
			$found_name = true;
			break;
		}
	}
	
	if (empty($found_name) && !empty($entry['title'])) {
		$publication = new ElggObject();
		$publication->subtype = "publication";
		$publication->owner_guid = elgg_get_logged_in_user_guid();
		$publication->container_guid = (int) get_input('container_guid', elgg_get_logged_in_user_guid());
		$publication->access_id = ACCESS_LOGGED_IN;
		$publication->title = $entry['title'];
		$publication->description = $entry['abstract'];
		$publication->save();
		$publication->pubtype = strtoupper($entry['bibtexEntryType']);
		
		$tagarray = string_to_tag_array($entry['keywords']);
		if (is_array($tagarray)) {
			$publication->tags = $tagarray;
		}
		
		$publication->authors = $authors;
		$skip_keys = [
			'author',
			'keywords',
			'type',
			'abstract',
			'title',
			'bibtexEntryType',
		];
		
		foreach ($entry as $key => $value) {
			if (in_array($key, $skip_keys)) {
				continue;
			}
			
			$publication->$key = $value;
		}
	}
}

system_message("BibTex imported sucessfully");
forward("publications/all");
