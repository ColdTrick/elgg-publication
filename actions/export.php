<?php

$download_type = get_input('type');
if ($download_type == 'single') {
	$guid = get_input('guid');
	$pub = get_entity($guid);
	$output = getBibTex($pub);
} else if($download_type == 'user') {
	$user_guid = get_input('user_guid');
	$user = get_entity($user_guid);
	
	$options = array(
		"type" => "object",
		"subtype" => "publication",
		"limit" => false
	);
	
	if ($user instanceof ElggGroup){
		$options["container_guid"] = $user->getGUID();
		$pubs = elgg_get_entities($options);
	} else{
		$options["relationship"] = "author";
		$options["relationship_guid"] = $user_guid;
		$options["inverse_relationship"] = true;
		$pubs = elgg_get_entities_from_relationship($options);
	}
	
	if($pubs){
		foreach($pubs as $pub){
			$bibtex = getBibTex($pub);
			$output .= $bibtex . "\n\n";
		}
	}
} elseif ($download_type == 'all'){
	
	$pubs = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'publication',
		'limit' => false
	));
	
	if($pubs){
		foreach($pubs as $pub){
			$bibtex = getBibTex($pub);
			$output .= $bibtex . "\n\n";
		}
	}
}

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=\"export.bib\"");
$splitString = str_split($output, 8192);
foreach($splitString as $chunk) {
	echo $chunk;
}
exit;
