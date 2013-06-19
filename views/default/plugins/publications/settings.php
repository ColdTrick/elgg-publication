<?php 

$onoff_options = array(
	"on" => elgg_echo("on"),
	"off" => elgg_echo("off")
);

echo "<div>";
echo elgg_echo('publication:modify') . " ";
echo elgg_view("input/dropdown", array("name" => "params[toggleinvites]", "options_values" => $onoff_options, "value" => strtolower($vars['entity']->toggleinvites)));
echo "</div>";

echo "<div>";
echo elgg_echo('publication:attachment:title') . " ";
echo elgg_view("input/dropdown", array("name" => "params[toggleattachment]", "options_values" => $onoff_options, "value" => strtolower($vars['entity']->toggleattachment)));
echo "</div>";
