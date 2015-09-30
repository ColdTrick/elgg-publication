<?php

elgg_gatekeeper();

$title = elgg_echo('publication:import');

elgg_push_breadcrumb($title);

// build page
$page_data = elgg_view_layout("content", [
	"title" => $title,
	"content" => elgg_view("publication/forms/import"),
	"filter" => false
]);

// display the page
echo elgg_view_page($title, $page_data);
