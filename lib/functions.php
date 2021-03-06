<?php

/**
 * Export a publication to Bibtex format
 *
 * @param ElggObject $publication the publication to export
 *
 * @return false|string
 */
function publications_get_bibtex(ElggObject $publication) {
	
	if (empty($publication) || !($publication instanceof Publication)) {
		return false;
	}
	
	$type = $publication->pubtype;

	//process authors
	$authors = explode(',', $publication->authors);
	$authors_str_arr = [];
	foreach ($authors as $author) {
		if (is_numeric($author)) {
			$author_entity = get_entity($author);
			$author_name = $author_entity->name;
		} else {
			$author_name = $author;
		}
		
		$authors_str_arr[] = $author_name;
	}
	
	$authors_str = implode(' and ', $authors_str_arr);
	if ($publication->description) {
		$abstract = strip_tags($publication->description);
	}
	
	if ($tags = $publication->tags) {
		if (!is_array($tags)) {
			$tags = [$tags];
		}
		
		$keywords = implode(',', $tags);
	}

	$result = "@$type{\n";
	$result .= "author={" . $authors_str . "},\n";

	if ($abstract) {
		$result .= "abstract={" . $abstract . "},\n";
	}
	if ($keywords) {
		$result .= "keywords={" . $keywords . "},\n";
	}

	$fields_array = [
		"title",
		"journal",
		"booktitle",
		"edition",
		"series",
		"volume",
		"number",
		"chapter",
		"year",
		"month",
		"pages",
		"publisher",
		"location",
		"institution",
		"organization",
		"school",
		"address",
		"howpublished",
		"note",
		"doi",
		"url",
		"uri",
		"issn",
		"isbn",
		"namekey"
	];

	foreach ($fields_array as $field) {
		if (!isset($publication->$field)) {
			continue;
		}
		$result .= "$field={" . $publication->$field . "},\n";
	}

	$result .= "}";

	return $result;
}

/**
 * Check if BibTex support is enabled
 *
 * @return bool
 */
function publications_bibtex_enabled() {
	static $enabled;
	
	if (!isset($enabled)) {
		$enabled = false;
		
		$plugin_settings = elgg_get_plugin_setting('enable_bibtex', 'publications');
		if ($plugin_settings === 'yes') {
			$enabled = true;
		}
	}
	
	return $enabled;
}

/**
 * Return the supported publication types
 *
 * @todo make this into a plugin hook
 *
 * @return array
 */
function publications_get_types() {
	
	$params = [
		'user' => elgg_get_logged_in_user_entity(),
	];
	
	return elgg_trigger_plugin_hook('register:types', 'publications', $params, []);
}

/**
 * Load the BibTex Browser library
 *
 * @return void
 */
function publications_load_bibtex_browser() {
	static $once;
	
	if (isset($once)) {
		return;
	}
	
	// load it as a library
	$_GET['library'] = 1;
	
	require_once(elgg_get_plugins_path() . 'publications/vendors/bibtexbrowser/bibtexbrowser.php');
}
