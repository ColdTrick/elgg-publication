<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$guid = (int) get_input('guid');

if ($entity = get_entity($guid)) {
	$content = elgg_view_entity($entity, array("full_view" => true));
	$title = $entity->title;
	$content .= elgg_view_comments($entity);
} else {
	register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
	forward("publications/all");
}

if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
	elgg_register_menu_item("title", array(
			"name" => "bibtex_export",
			"text" => elgg_echo("publication:export"),
			"href" => "action/publications/export?type=single&guid=" . $entity->getGUID(),
			"is_action" => true,
			"class" => "elgg-button elgg-button-action",
			"confirm" => elgg_echo("publication:export:confirm:single")
	));
}

$page_owner_entity = elgg_get_page_owner_entity();
if ($page_owner_entity instanceof ElggGroup) {
	elgg_push_breadcrumb($page_owner_entity->name, "publications/group/" . $page_owner_entity->getGUID());
} else {
	elgg_push_breadcrumb($page_owner_entity->name, "publications/owner/" . $page_owner_entity->username);
}

elgg_push_breadcrumb($title);

// build page
$page_data = elgg_view_layout("content", array(
	"title" => $title,
	"content" => $content,
	"filter" => false
));

// display the page
echo elgg_view_page($title, $page_data);
