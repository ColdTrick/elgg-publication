<?php

	// only when logged in, cant use gatekeeper() because of AJAX call
	if (!($user = elgg_get_logged_in_user_entity())) {
		return;
	}
	
	$q = sanitize_string(get_input("q"));
	$current_users = get_input("user_guids");
	$limit = (int) get_input("limit", 50);
	
	$result = array();
	
	if (!empty($q)) {
		// show hidden (unvalidated) users
		$hidden = access_get_show_hidden_status();
		access_show_hidden_entities(true);
	
		$dbprefix = elgg_get_config("dbprefix");
		$site = elgg_get_site_entity();
		
		// find existing users
		$query_options = array(
			"type" => "user",
			"limit" => $limit,
			"joins" => array("JOIN " . $dbprefix . "users_entity u ON e.guid = u.guid"),
			"wheres" => array(
				"(u.name LIKE '%" . $q . "%' OR u.username LIKE '%" . $q . "%' OR u.email LIKE '%" . $q . "%')",
				"(u.banned = 'no')"
			),
			"order_by" => "u.name asc",
			"relationship" => "member_of_site",
			"relationship_guid" => $site->getGUID(),
			"inverse_relationship" => true
		);
	
		// filter empty values
		if (!empty($current_users)) {
			foreach($current_users as $index => $guid) {
				if (empty($guid)) {
					unset($current_users[$index]);
				}
			}
		}
		
		if (!empty($current_users)) {
			$query_options["wheres"][] = "(e.guid NOT IN (" . implode(", ", $current_users) . "))";
		}
	
		// by default return the plain text so a name can always be added
		$result[] = array(
			"type" => "text",
			"value" => $q,
			"content" => $q
		);
		
		if($users = elgg_get_entities_from_relationship($query_options)){
			
			foreach($users as $user){
				$result[] = array(
					"type" => "user",
					"value" => $user->getGUID(),
					"content" => "<img src='" . $user->getIconURL("tiny") . "' /> " . $user->name,
					"name" => $user->name
				);
			}
		}
		
		// restore hidden users
		access_show_hidden_entities($hidden);
	}
	
	header("Content-Type: application/json");
	echo json_encode(array_values($result));
	exit();
	