<?php
	/**
	* @package Elgg
	* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	* @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
	* @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
	* @link http://grc.ucalgary.ca/
	*/

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");

	function publication_init() {
	
		// Load system configuration
		
		if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
			require_once(dirname(__FILE__) . "/vendors/bibtex/PARSEENTRIES.php");
			require_once(dirname(__FILE__) . "/vendors/bibtex/PARSECREATORS.php");
			
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
