<?php
/**
* @package Elgg
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
* @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
* @link http://grc.ucalgary.ca/
*/

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/events.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/page_handlers.php');

elgg_register_event_handler('init', 'system', 'publication_init');

function publication_init() {
	
	// register vendor classes for autoload
	elgg_register_classes(dirname(__FILE__) . '/vendors/bibtex/');
	
	// extend javascript
	elgg_extend_view('js/elgg', 'js/publications/site');
	elgg_extend_view('css/elgg', 'css/publications/site');
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('publications', 'publication_page_handler');
	
	// Add a new widget
	elgg_register_widget_type('publications', elgg_echo('publications:widget'), elgg_echo('publications:widget:description'));
	
	// Register granular notification for this type
	elgg_register_notification_event('object', Publication::SUBTYPE, ['create']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:' . Publication::SUBTYPE, ['\ColdTrick\Publications\Notifications', 'createPublication']);
	
	// Register entity type for search
	elgg_register_entity_type('object', Publication::SUBTYPE);
	
	// add group option
	add_group_tool_option('publication', elgg_echo('publication:enablepublication'), true);
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'publication_register_menu_owner_block');
	elgg_register_plugin_hook_handler('register', 'menu:filter', 'publication_register_menu_filter');
	elgg_register_plugin_hook_handler('register', 'menu:page', 'publication_register_menu_page');
// 	elgg_register_plugin_hook_handler('action','register','publication_custom_register');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'publication_write_permission_check');
	
	// register event handlers
	elgg_register_event_handler('login', 'user', 'publication_login_check');
	elgg_register_event_handler('upgrade', 'system', ['\ColdTrick\Publications\Upgrade', 'upgrade']);
	
	// Make sure the publication initialisation function is called on initialisation
	elgg_register_event_handler('pagesetup', 'system', 'publication_pagesetup');
	elgg_register_event_handler('create', 'user', 'publication_create_user');
	
	// Register actions
	elgg_register_action('publications/add', dirname(__FILE__) . '/actions/add.php');
	elgg_register_action('publications/edit', dirname(__FILE__) . '/actions/edit.php');
	elgg_register_action('publications/delete', dirname(__FILE__) . '/actions/delete.php');
// 	elgg_register_action('publications/invite', dirname(__FILE__) . '/actions/invite.php');
	
	elgg_register_action('publications/import', dirname(__FILE__) . '/actions/import.php');
	elgg_register_action('publications/export', dirname(__FILE__) . '/actions/export.php');
	
}

function publication_pagesetup() {
	
	// add site menu item
	elgg_register_menu_item('site', [
		'name' => 'publications',
		'text' => elgg_echo('publications'),
		'href' => 'publications/all'
	]);
}

