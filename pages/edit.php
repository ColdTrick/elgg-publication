<?php
        /**
         * @package Elgg
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
         * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
         * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
         * @link http://grc.ucalgary.ca/
         */

	gatekeeper();
		
	$entity = false;
	
	$guid = (int) get_input('guid');
	if ($guid) {
		if($entity = get_entity($guid)){
			if (elgg_instanceof($entity, "object", "publication") && $entity->canEdit()){
				$title = elgg_echo('publication:edit', array($entity->title));
				$form = elgg_view("publication/forms/edit", array('entity' => $entity));
			} else {
				register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
				forward("publications/all");
			}
		}
	} else {
		$title = elgg_echo('publication:add');
		$form = elgg_view("publication/forms/edit");
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
	
	// build page
	$page_data = elgg_view_layout("content", array(
			"title" => $title,
			"content" => $form,
			"filter" => false
	));
	
	// display the page
	echo elgg_view_page($title, $page_data);
