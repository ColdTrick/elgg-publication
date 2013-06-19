<?php
	$widget = $vars["entity"];
	
	$count = sanitise_int($widget->num_display, false);
	if(empty($count)){
		$count = 4;
	}
	
?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[num_display]", "value" => $count, "options" => range(1,9))); ?>
</div>