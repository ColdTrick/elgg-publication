<?php
if ($guid = get_input("guid")) {
	if ($entity = get_entity($guid)) {
		if (elgg_instanceof($entity, "object", "publication")) {
			if ($file_name = $entity->attached_file) {
				$fh = new ElggFile();
				$fh->owner_guid = $entity->getGUID();
				
				$fh->setFilename($file_name);
			
				//fix for IE https issue
				header('Pragma: public');
				if ($mime = $entity->attached_file_mime_type) {
					header('Content-Type: '. $mime);
				}
				
				header('Content-Disposition: Attachment; filename=' . $file_name);
					
				echo $fh->grabFile();
				exit();				
			}			
		}
	}
}

forward();