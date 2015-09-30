<?php

$guid = (int) get_input("guid");
if (empty($guid)) {
	forward(REFERER);
}

$entity = get_entity($guid);
if (empty($entity) || !elgg_instanceof($entity, "object", "publication")) {
	forward(REFERER);
}

$file_name = $entity->attached_file;
if (empty($file_name)) {
	forward(REFERER);
}

$fh = new ElggFile();
$fh->owner_guid = $entity->getGUID();
$fh->setFilename($file_name);

//fix for IE https issue
header('Pragma: public');
$mime = $entity->attached_file_mime_type;
if (!empty($mime)) {
	header('Content-Type: '. $mime);
}

header('Content-Disposition: Attachment; filename=' . $file_name);
	
echo $fh->grabFile();
exit();
