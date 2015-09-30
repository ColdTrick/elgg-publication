<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

elgg_register_title_button();

if (publications_bibtex_enabled()) {
	elgg_register_menu_item("title", [
		"name" => "bibtex_export",
		"text" => elgg_echo("publication:export"),
		"href" => "action/publications/export?type=all",
		"is_action" => true,
		"class" => "elgg-button elgg-button-action",
		"confirm" => elgg_echo("publication:export:confirm:all")
	]);
}

$title = elgg_echo('publication:everyone');
$listing = elgg_list_entities([
	'type' => 'object',
	'subtype' => Publication::SUBTYPE,
	'no_results' => elgg_echo("notfound"),
]);

// build page
$page_data = elgg_view_layout("content", [
	"title" => $title,
	"content" => $listing,
	"filter_context" => "all"
]);

// display the page
echo elgg_view_page($title, $page_data);
