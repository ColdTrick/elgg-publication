<?php

/**
 * Extend the create user function to include additional information
 * for invited authors
 *
 * @param string $event
 * @param string $object_type
 * @param ElggUser $object
 */
function publication_create_user($event, $object_type, $object) {
	
	$author = get_input($key);
	$publication = get_input($key);
	
	if (empty($author) || empty($publication)) {
		return;
	}
	
	create_metadata($object->getGUID(), "exauthor_name", $author, "", $object->getGUID(), ACCESS_PUBLIC);
	create_metadata($object->getGUID(), "firstpublication", $publication, "", $object->getGUID(), ACCESS_PUBLIC);
}

/**
 * Updates author's list when an invited author registers
 *
 * @param string $event
 * @param string $object_type
 * @param ElggUser $object
 */
function publication_login_check($event, $object_type, $object) {
	
	if (empty($object->firstpublication) || empty($object->exauthor_name)) {
		return;
	}
	
	$exauthor_name = $object->exauthor_name;
	$pub = get_entity($object->firstpublication);
	if (empty($pub) || ($pub->getSubtype() !== 'publication')) {
		return;
	}
	
	add_entity_relationship($pub->getGUID(), 'author', $object->getGUID());
	
	unset($object->firstpubication);
	unset($object->exauthor_name);
	
	$authors = $pub->authors;
	$authors = explode(',', $authors);
		
	foreach ($authors as $key => $value) {
		if ($value == $exauthor_name) {
			$authors[$key] = $object->getGUID();
		}
	}
	$authors = implode(',', $authors);
	
	$pub->authors = $authors;
}
