<?php

elgg_gatekeeper();

if (!publications_bibtex_enabled()) {
	register_error(elgg_echo('publication:error:bibtext:enabled'));
	forward(REFERER);
}

$title = elgg_echo('publication:import');

elgg_push_breadcrumb($title);

// build page
$page_data = elgg_view_layout("content", [
	"title" => $title,
	"content" => elgg_view_form("publication/import"),
	"filter" => false
]);

// display the page
echo elgg_view_page($title, $page_data);
