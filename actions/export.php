<?php

if (!publications_bibtex_enabled()) {
	register_error(elgg_echo('publication:error:bibtext:enabled'));
	forward(REFERER);
}

$download_type = get_input('type');
$output = '';

switch ($download_type) {
	case 'single':
		$guid = (int) get_input('guid');
		$pub = get_entity($guid);
		
		$output = publications_get_bibtex($pub);
		break;
	case 'user':
		$user_guid = (int) get_input('user_guid');
		$user = get_entity($user_guid);
		
		$options = [
			"type" => "object",
			"subtype" => "publication",
			"limit" => false
		];
		
		if ($user instanceof ElggGroup){
			$options["container_guid"] = $user->getGUID();
		} else{
			$options["relationship"] = "author";
			$options["relationship_guid"] = $user_guid;
			$options["inverse_relationship"] = true;
		}
		
		$pubs = new ElggBatch('elgg_get_entities_from_relationship', $options);
		foreach($pubs as $pub){
			$bibtex = publications_get_bibtex($pub);
			$output .= $bibtex . "\n\n";
		}
		break;
	case 'all':
		$options = [
			'type' => 'object',
			'subtype' => Publication::SUBTYPE,
			'limit' => false
		];
		
		$pubs = new ElggBatch('elgg_get_entities', $options);
		foreach($pubs as $pub){
			$bibtex = publications_get_bibtex($pub);
			$output .= $bibtex . "\n\n";
		}
		break;
}

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=\"export.bib\"");

$splitString = str_split($output, 8192);
foreach ($splitString as $chunk) {
	echo $chunk;
}
exit;
