<?php 

$form_body = "<label>" . elgg_echo("publication:bibtex") . "</label><br />";
$form_body .= elgg_view("input/file", array("name" => "bibtex_import")) . "<br />";
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("import")));

echo elgg_view("input/form", array("action" => "action/publications/import", "body" => $form_body, "enctype" => "multipart/form-data"));
