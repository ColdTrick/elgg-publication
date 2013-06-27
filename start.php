<?php
	/**
	* @package Elgg
	* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	* @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
	* @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
	* @link http://grc.ucalgary.ca/
	*/

	function publication_init() {
	
		// Load system configuration
		
		if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
			require_once(dirname(__FILE__) . "/lib/PARSEENTRIES.php");
			require_once(dirname(__FILE__) . "/lib/PARSECREATORS.php");		    		
			require_once(dirname(__FILE__) . "/lib/export_helper.php");
			
			elgg_register_plugin_hook_handler("register", "menu:page", "publication_register_menu_page");
			
			elgg_register_action("publications/import", elgg_get_plugins_path() . "publications/actions/import.php");
			elgg_register_action("publications/export", elgg_get_plugins_path() . "publications/actions/export.php");
			
		}
		
		// extend javascript
		elgg_extend_view("js/elgg", "js/publications/site");
		
		// Extend hover-over menu	
		elgg_extend_view('profile/menu/links','publication/menu');
		elgg_extend_view('account/forms/register','publication/register');
				
		// Register a page handler, so we can have nice URLs
		elgg_register_page_handler('publications','publication_page_handler');
		
		// Register a URL handler for publication posts
		elgg_register_entity_url_handler('object','publication', 'publication_url');
		
		// Add a new widget
		elgg_register_widget_type('publications',elgg_echo("publications:widget"),elgg_echo("publications:widget:description"));
		
		// Register granular notification for this type
		if (is_callable('register_notification_object')) {
			register_notification_object('object', 'publication', elgg_echo('publication:newpost'));
		}
		
		// Listen to notification events and supply a more useful message
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'publication_notify_message');
		
		// Listen for new pingbacks
		elgg_register_event_handler('create', 'object', 'publication_incoming_ping');
		
		// Register entity type
		elgg_register_entity_type('object','publication');
			
		add_group_tool_option('publication', elgg_echo('publication:enablepublication'), true);	
		
		// menu setup hooks
		elgg_register_plugin_hook_handler("register", "menu:owner_block", "publication_register_menu_owner_block");
		elgg_register_plugin_hook_handler("register", "menu:filter", "publication_register_menu_filter");
	}
		
	function publication_register_menu_filter($hook, $type, $return_value, $params) {
		if(elgg_in_context("publications")) {
			foreach($return_value as $index => $menu_item) {
				if($menu_item->getName() == "friend"){
					unset($return_value[$index]);
				}
			}	
			
			return $return_value;
		}
	}
	
	function publication_register_menu_owner_block($hook, $type, $return_value, $params) {
		if (elgg_instanceof($params['entity'], 'user')) {
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "publications",
				"text" => elgg_echo("publications"),
				"href" => "publications/owner/" . $params["entity"]->username,
					
			));
		} elseif (elgg_instanceof($params['entity'], 'group')) {
			if($params['entity']->publications_enable != "no") {
				$url = '/publications/group/' . $params['entity']->getGUID() . "/all";
				$item = new ElggMenuItem('publications', elgg_echo('publication:group'), $url);
				$return_value[] = $item;
			}
		}
			
		return $return_value;
	}
	
	function publication_register_menu_page($hook, $type, $return_value, $params) {
		if (elgg_is_logged_in()) {
			// 	import
			$return_value[] = ElggMenuItem::factory(array(
					"name" => "bibtex_import",
					"text" => elgg_echo("publication:import"),
					"href" => "publications/import",
					"section" => "bibtex",
					"context" => "publications"
			));
		}
		
		return $return_value;
	}
	
	//extend the create user function to include additional information
	//for invited authors	
	function publication_create_user($event, $object_type, $object){
		foreach ($_POST as $key=>$value) {
			if ($key == 'author') {
				$author = $value;
			}
			if ($key == 'publication') {
				$publication = $value;
			}
		}
		
		if ($author && $publication) {
			create_metadata($object->guid, 'exauthor_name', $author, "", $object->guid, ACCESS_PUBLIC);	
			create_metadata($object->guid, 'firstpublication', $publication, "", $object->guid, ACCESS_PUBLIC);	
		}
	}

	/* Updates author's list when an invited author registers */
	function publication_login_check($event, $object_type, $object){
		$user = elgg_get_logged_in_user_entity();
		if($user->firstpublication && $user->exauthor_name){
			$exauthor_name = $user->exauthor_name;
			$pub = get_entity($user->firstpublication);
			add_entity_relationship($user->firstpublication, 'author', $user->guid);
			remove_metadata($user->guid, 'firstpublication');
			remove_metadata($user->guid, 'exauthor_name');
			$authors = $pub->authors;
			$authors = explode(',',$authors);
			
			foreach ($authors as $key=>$value) {
				if ($value == $exauthor_name) {
					$authors[$key] = $user->guid;
				}
			}
			$authors = implode(',',$authors);
			$pub->authors = $authors;
		}
	}

	/* adds write rights to publication authors */
	function publication_write_permission_check($hook, $entity_type, $returnvalue, $params){
		if ($params['entity']->getSubtype() == 'publication') {
			if ($user_guid = $params['user']->guid){
				if (check_entity_relationship($params['entity']->guid, 'author', $user_guid)) {
					return true;
				}
			}
		}
	}

	/* replaced register plugin when we have a an invited author */
// 	function publication_custom_register($hook,$entity_type,$ret,$params){
// 		global $CONFIG;
// 		// Get variables
// 		$publication = get_input('publication');
// 		$author = get_input('author');
// 		if(!($author && $publication)) return;
// 		$username = get_input('username');
// 		$password = get_input('password');
// 		$password2 = get_input('password2');
// 		$email = get_input('email');
// 		$name = get_input('name');
// 		$friend_guid = (int) get_input('friend_guid',0);
// 		$invitecode = get_input('invitecode');
// 		$admin = get_input('admin');
// 		if (is_array($admin)) $admin = $admin[0];


// 		if (!$CONFIG->disable_registration){
// 			// For now, just try and register the user
// 			try {
// 				if (((trim($password)!="") && (strcmp($password, $password2)==0)) && ($guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode))) {
// 					$new_user = get_entity($guid);
// 					if (($guid) && ($admin)){
// 						admin_gatekeeper();
// 						$new_user->admin = 'yes';
// 					}
// 					// Send user validation request on register only
// 					global $registering_admin;
// 					if (!$registering_admin)
// 						request_user_validation($guid);

// 					if (!$new_user->admin)
// 						$new_user->disable('new_user', false);
// 					system_message(sprintf(elgg_echo("registerok"),$CONFIG->sitename));
// 					forward(); // Forward on success, assume everything else is an error...
// 				} else {
// 					register_error(elgg_echo("registerbad"));
// 				}
// 			} catch (RegistrationException $r) {
// 				register_error($r->getMessage());
// 			}
// 		}
// 		else
// 			register_error(elgg_echo('registerdisabled'));

// 		$qs = explode('?',$_SERVER['HTTP_REFERER']);
// 		$qs = $qs[0];
// 		$qs .= "?u=" . urlencode($username) . "&e=" . urlencode($email) . "&n=" . urlencode($name) . "&friend_guid=" . $friend_guid . "&invidecode=". $invitecode ."&author=". urlencode($author) . "&publication=".$publication;
// 		forward($qs);
// 	}

	
	function publication_pagesetup() {
		// Set up menu for logged in users
		if (elgg_is_logged_in()) {
			elgg_register_menu_item("site", array(
					"name" => "publications",
					"text" => elgg_echo("publications"),
					"href" => "publications/" . elgg_get_logged_in_user_entity()->username
			));
		} else {
			// And for logged out users
			elgg_register_menu_item("site", array(
					"name" => "publications",
					"text" => elgg_echo("publications"),
					"href" => "mod/publications/everyone.php"
			));
		}
	}

	function publication_page_handler($page) {
		
		// push all blogs breadcrumb
		elgg_push_breadcrumb(elgg_echo("publication:everyone"), "publications/all");
		
		switch($page[0]){
			case "all":
				include(dirname(__FILE__) . "/pages/all.php");
				break;
			case "group":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(__FILE__) . "/pages/group.php");
				break;
			case "owner":
				include(dirname(__FILE__) . "/pages/owner.php");
				break;
			case "add":
				include(dirname(__FILE__) . "/pages/edit.php");
				break;
			case "edit":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(__FILE__) . "/pages/edit.php");
				break;
			case "view":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(__FILE__) . "/pages/view.php");
				break;
			case "import":
				if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
					include(dirname(__FILE__) . "/pages/import.php");
					break;
				}
			default:
				forward("publications/all");
				break;
		}
		
		return true;	
	}

	function publication_notify_message($hook, $entity_type, $returnvalue, $params){
		$entity = $params['entity'];
		$to_entity = $params['to_entity'];
		$method = $params['method'];
		if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'publication')){
			$descr = $entity->description;
			$title = $entity->title;
			if ($method == 'sms') {
				$owner = $entity->getOwnerEntity();
				return $owner->username . ' via publication: ' . $title;
			}
			if ($method == 'email') {
				$owner = $entity->getOwnerEntity();
				return $owner->username . ' via publication: ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
			}
		}
		return null;
	}

	function publication_url($entity) {
		return elgg_get_site_url() . "publications/view/" . $entity->getGUID() . "/" . elgg_get_friendly_title($entity->title);
	}

	// write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'publication_write_permission_check');
	elgg_register_event_handler('login','user','publication_login_check');
	
	// Make sure the publication initialisation function is called on initialisation
	elgg_register_event_handler('init','system','publication_init');
	elgg_register_event_handler('pagesetup','system','publication_pagesetup');
	elgg_register_event_handler('create','user','publication_create_user');
	
// 	elgg_register_plugin_hook_handler('action','register','publication_custom_register');

	// Register actions
	elgg_register_action("publications/add", elgg_get_plugins_path() . "publications/actions/add.php");
	elgg_register_action("publications/edit", elgg_get_plugins_path() . "publications/actions/edit.php");
	elgg_register_action("publications/delete", elgg_get_plugins_path() . "publications/actions/delete.php");
// 	elgg_register_action("publications/invite", elgg_get_plugins_path() . "publications/actions/invite.php");
