<?php

	/**
	 * Remove the friends tab from the filter menu (only for publications)
	 *
	 * @param string $hook
	 * @param string $type
	 * @param array $return_value
	 * @param array $params
	 * @return array
	 */
	function publication_register_menu_filter($hook, $type, $return_value, $params) {
		
		if (elgg_in_context("publications")) {
			foreach ($return_value as $index => $menu_item) {
				if ($menu_item->getName() == "friend") {
					unset($return_value[$index]);
				}
			}
			
			return $return_value;
		}
	}
	
	/**
	 *	Add a menu item to the owner block to the publications
	 *
	 * @param string $hook
	 * @param string $type
	 * @param array $return_value
	 * @param array $params
	 * @return array
	 */
	function publication_register_menu_owner_block($hook, $type, $return_value, $params) {
		
		if (!empty($params) && is_array($params)) {
			if ($entity = elgg_extract("entity", $params)) {
				
				if (elgg_instanceof($entity, "user")) {
					// User
					$return_value[] = ElggMenuItem::factory(array(
						"name" => "publications",
						"text" => elgg_echo("publications"),
						"href" => "publications/owner/" . $entity->username,
					));
				} elseif (elgg_instanceof($entity, "group")) {
					// Group
					if($entity->publications_enable != "no") {
						$return_value[] = ElggMenuItem::factory(array(
							"name" => "publications",
							"text" => elgg_echo("publication:group"),
							"href" => "publications/group/" . $entity->getGUID() . "/all"
						));
						
					}
				}
			}
		}
			
		return $return_value;
	}
	
	/**
	 * Add a menu item in the sidebar to the import page
	 *
	 * @param string $hook
	 * @param string $type
	 * @param array $return_value
	 * @param array $params
	 * @return array
	 */
	function publication_register_menu_page($hook, $type, $return_value, $params) {
		
		if (elgg_is_logged_in() && elgg_in_context("publications")) {
			// 	import
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "bibtex_import",
				"text" => elgg_echo("publication:import"),
				"href" => "publications/import",
				"section" => "bibtex",
			));
		}
	
		return $return_value;
	}
	
	/**
	 * Grant write permissions to publication authors
	 *
	 * @param string $hook
	 * @param string $entity_type
	 * @param bool $returnvalue
	 * @param string $params
	 * @return boolean
	 */
	function publication_write_permission_check($hook, $entity_type, $returnvalue, $params){
		$result = $returnvalue;
		
		if (!$result && !empty($params) && is_array($params)) {
			$entity = elgg_extract("entity", $params);
			$user = elgg_extract("user", $params);
			
			if (!empty($entity) && !empty($user) && elgg_instanceof($entity, "object", "publication") && elgg_instanceof($user, "user")) {
				if (check_entity_relationship($entity->getGUID(), "author", $user->getGUID())) {
					$result = true;
				}
			}
		}
		
		return $result;
	}
	
	/* replaced register plugin when we have a an invited author */
	/*function publication_custom_register($hook,$entity_type,$ret,$params){
		global $CONFIG;
		// Get variables
		$publication = get_input('publication');
		$author = get_input('author');
		if(!($author && $publication)) return;
		$username = get_input('username');
		$password = get_input('password');
		$password2 = get_input('password2');
		$email = get_input('email');
		$name = get_input('name');
		$friend_guid = (int) get_input('friend_guid',0);
		$invitecode = get_input('invitecode');
		$admin = get_input('admin');
		if (is_array($admin)) $admin = $admin[0];


		if (!$CONFIG->disable_registration){
			// For now, just try and register the user
			try {
				if (((trim($password)!="") && (strcmp($password, $password2)==0)) && ($guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode))) {
					$new_user = get_entity($guid);
					if (($guid) && ($admin)){
						admin_gatekeeper();
						$new_user->admin = 'yes';
					}
					// Send user validation request on register only
					global $registering_admin;
					if (!$registering_admin)
							request_user_validation($guid);

					if (!$new_user->admin)
							$new_user->disable('new_user', false);
					system_message(sprintf(elgg_echo("registerok"),$CONFIG->sitename));
					forward(); // Forward on success, assume everything else is an error...
				} else {
					register_error(elgg_echo("registerbad"));
				}
			} catch (RegistrationException $r) {
				register_error($r->getMessage());
			}
		}
		else
				register_error(elgg_echo('registerdisabled'));

		$qs = explode('?',$_SERVER['HTTP_REFERER']);
		$qs = $qs[0];
		$qs .= "?u=" . urlencode($username) . "&e=" . urlencode($email) . "&n=" . urlencode($name) . "&friend_guid=" . $friend_guid . "&invidecode=". $invitecode ."&author=". urlencode($author) . "&publication=".$publication;
		forward($qs);
	}*/
	
	/**
	 * Custom message when a publication is created
	 *
	 * @param string $hook
	 * @param string $entity_type
	 * @param string $returnvalue
	 * @param array $params
	 * @return string
	 */
	function publication_notify_message($hook, $entity_type, $returnvalue, $params) {
		$result = $returnvalue;
		
		if (!empty($params) && is_array($params)) {
			$entity = elgg_extract("entity", $params);
			$method = elgg_extract("method", $params);
			
			if (!empty($entity) && elgg_instanceof($entity, "object", "publication")) {
				$owner = $entity->getOwnerEntity();
				$title = $entity->title;
				
				if ($method == "sms") {
					$result = $owner->name . ' via publication: ' . $title;
				} elseif ($method == "email") {
					$result = $owner->name . ' via publication: ' . $title . "\n\n" . $entity->description . "\n\n" . $entity->getURL();
				}
			}
		}
		
		return $result;
	}

	/**
	 * Disable commenting on publications
	 *
	 * @param string $hook
	 * @param string $entity_type
	 * @param string $returnvalue
	 * @param array $params
	 * @return string
	 */
	function publication_permissions_check_comment($hook, $entity_type, $returnvalue, $params) {
		$result = $returnvalue;
		
		if (!empty($params) && is_array($params)) {
			$entity = elgg_extract("entity", $params);
			if (!empty($entity) && elgg_instanceof($entity, "object", "publication")) {
				$result = false;
			}
		}
		
		return $result;
	}
	
	