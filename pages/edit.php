<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

elgg_gatekeeper();
	
$entity = false;
$title = elgg_echo('publication:add');
$form_view = "publication/forms/edit";

$guid = (int) get_input('guid');
if (!empty($guid)) {
	$entity = get_entity($guid);
	if (empty($entity) || !elgg_instanceof($entity, "object", "publication") || !$entity->canEdit()) {
		register_error(elgg_echo("InvalidParameterException:GUIDNotFound", [$guid]));
		forward("publications/all");
	}
		
	$title = elgg_echo('publication:edit', [$entity->title]);
	$form_view = "publication/forms/edit";
	
	elgg_set_page_owner_guid($entity->getContainerGUID());
}

$page_owner_entity = elgg_get_page_owner_entity();
if ($page_owner_entity instanceof ElggGroup) {
	elgg_push_breadcrumb($page_owner_entity->name, "publications/group/" . $page_owner_entity->getGUID());
} else {
	elgg_push_breadcrumb($page_owner_entity->name, "publications/owner/" . $page_owner_entity->username);
}

if ($entity) {
	elgg_push_breadcrumb($entity->title, $entity->getURL());
}

elgg_push_breadcrumb($title);

$form = elgg_view($form_view, ['entity' => $entity]);

// build page
$page_data = elgg_view_layout("content", [
	"title" => $title,
	"content" => $form,
	"filter" => false
]);

// display the page
echo elgg_view_page($title, $page_data);
