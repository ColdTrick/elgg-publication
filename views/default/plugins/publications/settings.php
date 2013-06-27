<?php 

$yesno_options = array(
		"yes" => elgg_echo("option:yes"),
		"no" => elgg_echo("option:no")
);

$noyes_options = array_reverse($yesno_options);

// $onoff_options = array(
// 	"on" => elgg_echo("on"),
// 	"off" => elgg_echo("off")
// );

// echo "<div>";
// echo elgg_echo('publication:modify') . " ";
// echo elgg_view("input/dropdown", array("name" => "params[toggleinvites]", "options_values" => $onoff_options, "value" => strtolower($vars['entity']->toggleinvites)));
// echo "</div>";

// echo "<div>";
// echo elgg_echo('publication:attachment:title') . " ";
// echo elgg_view("input/dropdown", array("name" => "params[toggleattachment]", "options_values" => $onoff_options, "value" => strtolower($vars['entity']->toggleattachment)));
// echo "</div>";

echo "<div>";
echo elgg_echo('publications:settings:enable_bibtex') . " ";
echo elgg_view("input/dropdown", array("name" => "params[enable_bibtex]", "options_values" => $noyes_options, "value" => $vars['entity']->enable_bibtex));
echo "</div>";