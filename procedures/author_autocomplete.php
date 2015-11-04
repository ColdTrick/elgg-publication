<?php

// only when logged in, cant use gatekeeper() because of AJAX call
$user = elgg_get_logged_in_user_entity();
if (empty($user)) {
	return;
}

$q = sanitize_string(get_input("q"));
$current_users = get_input("user_guids");
$limit = (int) get_input("limit", 50);

$result = [];

if (!empty($q)) {
	// show hidden (unvalidated) users
	$hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	$dbprefix = elgg_get_config("dbprefix");
	$site = elgg_get_site_entity();
	
	// find existing users
	$query_options = [
		"type" => "user",
		"limit" => $limit,
		"joins" => ["JOIN " . $dbprefix . "users_entity u ON e.guid = u.guid"],
		"wheres" => [
			"(u.name LIKE '%" . $q . "%' OR u.username LIKE '%" . $q . "%' OR u.email LIKE '%" . $q . "%')",
			"(u.banned = 'no')"
		],
		"order_by" => "u.name asc",
		"relationship" => "member_of_site",
		"relationship_guid" => $site->getGUID(),
		"inverse_relationship" => true
	];

	// filter empty values
	if (!empty($current_users)) {
		foreach ($current_users as $index => $guid) {
			$guid = sanitize_int($guid, false);
			if (empty($guid)) {
				unset($current_users[$index]);
			}
		}
	}
	
	if (!empty($current_users)) {
		$query_options["wheres"][] = "(e.guid NOT IN (" . implode(", ", $current_users) . "))";
	}

	// by default return the plain text so a name can always be added
	$result[] = [
		"type" => "text",
		"value" => $q,
		"content" => $q
	];
	
	$users = new ElggBatch('elgg_get_entities_from_relationship', $query_options);
	foreach($users as $user){
		$result[] = [
			"type" => "user",
			"value" => $user->getGUID(),
			"content" => "<img src='" . $user->getIconURL("tiny") . "' /> " . $user->name,
			"name" => $user->name
		];
	}
	
	// restore hidden users
	access_show_hidden_entities($hidden);
}

header("Content-Type: application/json");
echo json_encode(array_values($result));
exit();
