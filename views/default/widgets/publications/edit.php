<?php

$widget = $vars["entity"];

$count = (int) $widget->num_display;
if ($count < 1) {
	$count = 4;
}
	
?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/select", ["name" => "params[num_display]", "value" => $count, "options" => range(1, 9)]); ?>
</div>