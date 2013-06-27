<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$page_owner_entity = elgg_get_page_owner_entity();

$title = elgg_echo('publication:user', array($page_owner_entity->name));

elgg_register_title_button();

if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
	elgg_register_menu_item("title", array(
			"name" => "bibtex_export",
			"text" => elgg_echo("publication:export"),
			"href" => "action/publications/export?type=user&user_guid=" . $page_owner_entity->getGUID(),
			"is_action" => true,
			"class" => "elgg-button elgg-button-action",
			"confirm" => elgg_echo("publication:export:confirm:user", array($page_owner_entity->name))
	));
}

elgg_push_breadcrumb($page_owner_entity->name);

$options = array(
	"type" => "object",
	"subtype" => "publication",
	"relationship" => "author",
	"relationship_guid" => $page_owner_entity->getGUID(),
	"inverse_relationship" => true,
	"full_view" => false
);

$authored = elgg_list_entities_from_relationship($options);
if (!$authored) {
	$authored = elgg_echo("notfound");
}

$options = array(
	"type" => "object",
	"subtype" => "publication",
	"owner_guid" => $page_owner_entity->getGUID(),
	"full_view" => false
);

$catalogued = elgg_list_entities($options);
if (!$catalogued) {
	$catalogued = elgg_echo("notfound");
}

$listing = elgg_view_module("info", elgg_echo('publication:authored:your'), $authored);
$listing .= elgg_view_module("info", elgg_echo('publication:catalogued:your'), $catalogued);

$sidebar = "";

if(elgg_is_logged_in()){
	if ($page_owner_entity instanceof ElggUser) {
		$sidebar .= elgg_view("publication/import");
	}
}

// build page
$page_data = elgg_view_layout("content", array(
	"title" => $title,
	"content" => $listing,
	"filter_context" => "mine",
	"sidebar" => $sidebar
));

// display the page
echo elgg_view_page($title, $page_data);
