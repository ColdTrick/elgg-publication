<?php

$plugin = elgg_extract('entity', $vars);

$yesno_options = [
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
];

$noyes_options = array_reverse($yesno_options);

// $onoff_options = [
// 	"on" => elgg_echo("on"),
// 	"off" => elgg_echo("off")
// ];

// echo "<div>";
// echo elgg_echo('publication:modify') . " ";
// echo elgg_view("input/select", [
// 	"name" => "params[toggleinvites]",
// 	"options_values" => $onoff_options,
// 	"value" => strtolower($plugin->toggleinvites)
// ]);
// echo "</div>";

// echo "<div>";
// echo elgg_echo('publication:attachment:title') . " ";
// echo elgg_view("input/select", [
// 	"name" => "params[toggleattachment]",
// 	"options_values" => $onoff_options,
// 	"value" => strtolower($plugin->toggleattachment)
// ]);
// echo "</div>";

echo "<div>";
echo elgg_echo('publications:settings:enable_bibtex') . " ";
echo elgg_view("input/select", [
	"name" => "params[enable_bibtex]",
	"options_values" => $noyes_options,
	"value" => $plugin->enable_bibtex
]);
echo "</div>";