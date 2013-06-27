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
		
		foreach ($_POST as $key => $value) {
			if ($key == "author") {
				$author = get_input($key);
			} elseif ($key == "publication") {
				$publication = get_input($key);
			}
		}
	
		if ($author && $publication) {
			create_metadata($object->getGUID(), "exauthor_name", $author, "", $object->getGUID(), ACCESS_PUBLIC);
			create_metadata($object->getGUID(), "firstpublication", $publication, "", $object->getGUID(), ACCESS_PUBLIC);
		}
	}
	
	/**
	 * Updates author's list when an invited author registers
	 *
	 * @param string $event
	 * @param string $object_type
	 * @param ElggUser $object
	 */
	function publication_login_check($event, $object_type, $object) {
		
		if($object->firstpublication && $object->exauthor_name){
			$exauthor_name = $object->exauthor_name;
			$pub = get_entity($object->firstpublication);
			
			add_entity_relationship($object->firstpublication, 'author', $object->getGUID());
			
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
	}