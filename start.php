<?php
/**
* @package Elgg
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
* @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
* @link http://grc.ucalgary.ca/
*/

@include_once(dirname(__FILE__) . '/vendor/autoload.php');

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/events.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/page_handlers.php');

elgg_register_event_handler('init', 'system', 'publication_init');

function publication_init() {
	
	// extend javascript
	elgg_extend_view('js/elgg', 'js/publications/site');
	elgg_extend_view('css/elgg', 'css/publications/site');
	
	// ajax views
	elgg_register_ajax_view('publications/publication/custom_fields');
	
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
	elgg_register_plugin_hook_handler('register', 'menu:title', 'publication_register_menu_title');
// 	elgg_register_plugin_hook_handler('action','register','publication_custom_register');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'publication_write_permission_check');
	
	// custom publication types
	elgg_register_plugin_hook_handler('register:types', 'publications', ['\ColdTrick\Publications\Types', 'registerTypeBibTex']);
	
	elgg_register_plugin_hook_handler('all', 'publications', ['\ColdTrick\Publications\Types', 'validateRequiredAuthors']);
	elgg_register_plugin_hook_handler('all', 'publications', ['\ColdTrick\Publications\Types', 'validateRequiredAuthorsEditors']);
	elgg_register_plugin_hook_handler('input_validation:article', 'publications', ['\ColdTrick\Publications\Types', 'validateInputArticle']);
	elgg_register_plugin_hook_handler('input_validation:book', 'publications', ['\ColdTrick\Publications\Types', 'validateInputBook']);
	elgg_register_plugin_hook_handler('input_validation:inbook', 'publications', ['\ColdTrick\Publications\Types', 'validateInputInBook']);
	elgg_register_plugin_hook_handler('input_validation:incollection', 'publications', ['\ColdTrick\Publications\Types', 'validateInputInCollection']);
	elgg_register_plugin_hook_handler('input_validation:inproceedings', 'publications', ['\ColdTrick\Publications\Types', 'validateInputInProceedings']);
	elgg_register_plugin_hook_handler('input_validation:mastersthesis', 'publications', ['\ColdTrick\Publications\Types', 'validateInputMastersThesis']);
	elgg_register_plugin_hook_handler('input_validation:phdhesis', 'publications', ['\ColdTrick\Publications\Types', 'validateInputPhdThesis']);
	elgg_register_plugin_hook_handler('input_validation:proceedings', 'publications', ['\ColdTrick\Publications\Types', 'validateInputProceedings']);
	elgg_register_plugin_hook_handler('input_validation:techreport', 'publications', ['\ColdTrick\Publications\Types', 'validateInputTechreport']);
	
	elgg_register_event_handler('save:data', 'publications', ['\ColdTrick\Publications\Types', 'saveeAuthors']);
	elgg_register_event_handler('save:data', 'publications', ['\ColdTrick\Publications\Types', 'saveBookEditors']);
	
	// register event handlers
	elgg_register_event_handler('login', 'user', 'publication_login_check');
	elgg_register_event_handler('upgrade', 'system', ['\ColdTrick\Publications\Upgrade', 'setClassHandler']);
	elgg_register_event_handler('upgrade', 'system', ['\ColdTrick\Publications\Upgrade', 'updateArticleBook']);
	elgg_register_event_handler('upgrade', 'system', ['\ColdTrick\Publications\Upgrade', 'updateArticleJournal']);
	
	// Make sure the publication initialisation function is called on initialisation
	elgg_register_event_handler('pagesetup', 'system', 'publication_pagesetup');
	elgg_register_event_handler('create', 'user', 'publication_create_user');
	
	// Register actions
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

