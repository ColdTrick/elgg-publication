<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$page_owner_entity = elgg_get_page_owner_entity();
if (!($page_owner_entity instanceof ElggUser)) {
	forward(REFERER);
}

$title = elgg_echo('publication:user', [$page_owner_entity->name]);

elgg_register_title_button();

if (publications_bibtex_enabled()) {
// 	elgg_register_menu_item('title', [
// 		'name' => 'bibtex_export',
// 		'text' => elgg_echo('publication:export'),
// 		'href' => 'action/publications/export?type=user&user_guid=' . $page_owner_entity->getGUID(),
// 		'is_action' => true,
// 		'class' => 'elgg-button elgg-button-action',
// 		'confirm' => elgg_echo('publication:export:confirm:user', [$page_owner_entity->name])
// 	]);
}

elgg_push_breadcrumb($page_owner_entity->name);

$dbprefix = elgg_get_config('dbprefix');
$options = [
	'type' => 'object',
	'subtype' => Publication::SUBTYPE,
	'wheres' => [
		"(e.owner_guid = {$page_owner_entity->getGUID()} OR e.guid IN (
			SELECT guid_one
			FROM {$dbprefix}entity_relationships
			WHERE guid_two = {$page_owner_entity->getGUID()}
			AND relationship IN ('author', 'book_editor')
		))"
	],
	'order_by_metadata' => array (
		'name'		=> 'year',
		'direction'	=> 'DESC',
		'as'		=> 'integer'
		),
	/* order by title */
	/*
	'joins' => array("INNER JOIN {$dbprefix}objects_entity o ON (e.guid = o.guid)"),
	'order_by' => 'o.title',
	*/
	'no_results' => elgg_echo('notfound'),
];

$listing = elgg_list_entities_from_metadata($options);

// build page

// filter context
$viewer = elgg_get_logged_in_user_guid();

if($viewer == $page_owner_entity->getGUID()) {
	$page_data = elgg_view_layout('content', [
		'title' => $title,
		'content' => $listing,
		'filter_context' => 'mine',
	]);

} else {
	$page_data = elgg_view_layout('content', [
		'title' => $title,
		'content' => $listing,
		'filter_context' => false,
	]);
}

// display the page
echo elgg_view_page($title, $page_data);
