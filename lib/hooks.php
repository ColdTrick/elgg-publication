<?php

/**
 * Remove the friends tab from the filter menu (only for publications)
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return void|ElggMenuItem[]
 */
function publication_register_menu_filter($hook, $type, $return_value, $params) {
	
	if (!elgg_in_context("publications")) {
		return;
	}
	
	foreach ($return_value as $index => $menu_item) {
		if ($menu_item->getName() == "friend") {
			unset($return_value[$index]);
		}
	}
	
	return $return_value;
}

/**
 *	Add a menu item to the owner block to the publications
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return void|ElggMenuItem[]
 */
function publication_register_menu_owner_block($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity)) {
		return;
	}
	
	if ($entity instanceof ElggUser) {
		// User
		$return_value[] = ElggMenuItem::factory([
			"name" => "publications",
			"text" => elgg_echo("publications"),
			"href" => "publications/owner/{$entity->username}",
		]);
	} elseif ($entity instanceof ElggGroup) {
		// Group
		if ($entity->publications_enable === "no") {
			// publications not enabled
			return;
		}
		
		$return_value[] = ElggMenuItem::factory([
			"name" => "publications",
			"text" => elgg_echo("publication:group"),
			"href" => "publications/group/{$entity->getGUID()}/all",
		]);
	}
		
	return $return_value;
}

/**
 * Add a menu item in the sidebar to the import page
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return void|ElggMenuItem[]
 */
function publication_register_menu_page($hook, $type, $return_value, $params) {
	
	if (!elgg_is_logged_in() || !elgg_in_context("publications")) {
		return;
	}
	
	// 	import
	$return_value[] = ElggMenuItem::factory([
		"name" => "bibtex_import",
		"text" => elgg_echo("publication:import"),
		"href" => "publications/import",
		"section" => "bibtex",
	]);
	
	return $return_value;
}

/**
 * Grant write permissions to publication authors
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param bool   $return_value current return value
 * @param array  $params       supplied params
 *
 * @return void|true
 */
function publication_write_permission_check($hook, $type, $return_value, $params){
	$result = $returnvalue;
	
	if (!empty($returnvalue)) {
		// already allowed
		return;
	}
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract("entity", $params);
	$user = elgg_extract("user", $params);
	
	if (!($user instanceof ElggUser)) {
		return;
	}
	
	if (empty($entity) || !elgg_instanceof($entity, "object", "publication")) {
		return;
	}
	
	if (check_entity_relationship($entity->getGUID(), "author", $user->getGUID())) {
		return true;
	}
}

/**
 * Custom message when a publication is created
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param string $return_value current return value
 * @param array  $params       supplied params
 *
 * @return void|string
 */
function publication_notify_message($hook, $type, $return_value, $params) {
	$result = $returnvalue;
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract("entity", $params);
	$method = elgg_extract("method", $params);
	
	if (empty($entity) || !elgg_instanceof($entity, "object", "publication")) {
		return;
	}
	
	$owner = $entity->getOwnerEntity();
	$title = $entity->title;
	
	if ($method == "sms") {
		return $owner->name . ' via publication: ' . $title;
	} elseif ($method == "email") {
		return $owner->name . ' via publication: ' . $title . "\n\n" . $entity->description . "\n\n" . $entity->getURL();
	}
}

/**
 * Disable commenting on publications
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param bool   $return_value current return value
 * @param array  $params       supplied params
 *
 * @return void|false
 */
function publication_permissions_check_comment($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "object", "publication")) {
		return;
	}
	
	return false;
}
