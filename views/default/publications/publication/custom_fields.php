<?php

elgg_gatekeeper();

$guid = (int) get_input('guid');
$type = get_input('type');

$entity = false;
if (!empty($guid)) {
	elgg_entity_gatekeeper($guid, 'object', Publication::SUBTYPE);
	$entity = get_entity($guid);
	
	if (!$entity->canEdit()) {
		return;
	}
}

$supported_types = publications_get_types();
if (!in_array($type, $supported_types)) {
	echo elgg_echo('publication:type_not_supported');
	return;
}

if (elgg_view_exists("publications/publication/edit/$type")) {
	echo elgg_view("publications/publication/edit/$type", ['entity' => $entity]);
	return;
}
