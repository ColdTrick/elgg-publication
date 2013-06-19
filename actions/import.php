<?php

// Get input data
if ($data = get_uploaded_file("bibtex_import")) {

	//parse BibTex file
	$parse = new PARSEENTRIES();
	$parse->loadBibtexString($data);
	$parse->extractEntries();
	list($preamble,$strings,$entries,$undefinedStrings) = $parse->returnArrays();
	
	if(empty($entries)){
		register_error(elgg_echo('publication:bibtex:blank'));
		forward(REFERER);
	}
	
	foreach($entries as $entry){
		$found_name = false;
		$authors = array();
		$creator = new PARSECREATORS();
		$creatorArray = $creator->parse($entry['author']);
		foreach($creatorArray as $author){
			$name = "";
			foreach($author as $a){
				$name .= trim($a) . " ";
			}
			$name = trim($name);
			$authors[] = $name;
		}
		$authors = implode(',',$authors);
	
		//get all current publication and check for duplication
		$all_pubs = elgg_get_entities(array('types'=>'object', 'subtypes'=>'publication', 'limit'=> false)); // TODO possible performance issues with largere database
		foreach($all_pubs as $cpubs){
			if($cpubs->title == $entry['title']){
				$found_name = true;
				break;
			}
		}
		if($found_name == false && !(empty($entry['title']))){
			$publication = new ElggObject();
			$publication->subtype = "publication";
			$publication->owner_guid = elgg_get_logged_in_user_guid();
			$publication->container_guid = (int)get_input('container_guid', elgg_get_logged_in_user_guid());
			$publication->access_id = ACCESS_LOGGED_IN;
			$publication->title = $entry['title'];
			$publication->description = $entry['abstract'];
			$publication->save();
			$publication->pubtype = strtoupper($entry['bibtexEntryType']);
			if(is_array($tagarray = string_to_tag_array($entry['keywords']))) {
				$publication->tags = $tagarray;
			}
			
			$publication->authors = $authors;
			
			foreach(array_keys($entry) as $key){
				if($key != 'author' || $key = 'keywords' || $key != 'type' || $key != 'abstract' || $key != 'title'){
					$publication->$key = $entry[$key];
				}
			}
		}
	}
	
	system_message("BibTex imported sucessfully");
	forward("publications/all");

} else {
	register_error(elgg_echo("publication:bibtex:fileerror"));
	forward(REFERER);
}