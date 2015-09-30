<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$page_owner_entity = elgg_get_page_owner_entity();

$title = elgg_echo('publication:user', [$page_owner_entity->name]);

elgg_register_title_button();

if (publications_bibtex_enabled()) {
	elgg_register_menu_item("title", [
		"name" => "bibtex_export",
		"text" => elgg_echo("publication:export"),
		"href" => "action/publications/export?type=user&user_guid=" . $page_owner_entity->getGUID(),
		"is_action" => true,
		"class" => "elgg-button elgg-button-action",
		"confirm" => elgg_echo("publication:export:confirm:user", [$page_owner_entity->name])
	]);
}

elgg_push_breadcrumb($page_owner_entity->name);

$options = [
	"type" => "object",
	"subtype" => "publication",
	"relationship" => "author",
	"relationship_guid" => $page_owner_entity->getGUID(),
	"inverse_relationship" => true,
	"full_view" => false,
	"no_results" => elgg_echo("notfound"),
];

$authored = elgg_list_entities_from_relationship($options);

$options = [
	"type" => "object",
	"subtype" => "publication",
	"owner_guid" => $page_owner_entity->getGUID(),
	"no_results" => elgg_echo("notfound"),
];

$catalogued = elgg_list_entities($options);

$listing = elgg_view_module("info", elgg_echo('publication:authored:your'), $authored);
$listing .= elgg_view_module("info", elgg_echo('publication:catalogued:your'), $catalogued);

$sidebar = "";
if (elgg_is_logged_in() && ($page_owner_entity instanceof ElggUser)) {
	$sidebar .= elgg_view("publication/import");
}

// build page
$page_data = elgg_view_layout("content", [
	"title" => $title,
	"content" => $listing,
	"filter_context" => "mine",
	"sidebar" => $sidebar
]);

// display the page
echo elgg_view_page($title, $page_data);
