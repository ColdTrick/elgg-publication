<?php

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
 * Add a menu item in the title to the import page
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return void|ElggMenuItem[]
 */
function publication_register_menu_title($hook, $type, $return_value, $params) {
	
	if (!elgg_is_logged_in() || !elgg_in_context("publications")) {
		return;
	}
	
	if (!publications_bibtex_enabled()) {
		return;
	}
	
	
	$add_found = false;
	foreach ($return_value as $menu_item) {
		if ($menu_item->getName() !== 'add') {
			continue;
		}
		
		$add_found = true;
		break;
	}
	
	if (!$add_found) {
		return;
	}
	
	// 	import
	$return_value[] = ElggMenuItem::factory([
		"name" => "import",
		"text" => elgg_echo("publication:import"),
		"href" => "publications/import",
		"link_class" => "elgg-button elgg-button-action",
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
	
	if (!empty($return_value)) {
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
	
	if (empty($entity) || !($entity instanceof Publication)) {
		return;
	}
	
	if (check_entity_relationship($entity->getGUID(), "author", $user->getGUID())) {
		return true;
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
	if (empty($entity) || !($entity instanceof Publication)) {
		return;
	}
	
	return false;
}
