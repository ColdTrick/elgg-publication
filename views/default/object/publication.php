<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);

if (!$entity) {
	return TRUE;
}

if ($full) {
	$owner = $entity->getOwnerEntity();
	$container = $entity->getContainerEntity();
	
	$owner_icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = elgg_view('output/url', [
		'href' => "publications/owner/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
	]);
	$author_text = elgg_echo('byline', [$owner_link]);
	$date = elgg_view_friendly_time($entity->time_created);
	
	// The "on" status changes for comments, so best to check for !Off
	$comments_link = '';
	if ($entity->comments_on != 'Off') {
		$comments_count = $entity->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', [
				'href' => $entity->getURL() . '#comments',
				'text' => $text,
				'is_trusted' => true,
			]);
		}
	}
	
	$metadata = elgg_view_menu('entity', [
		'entity' => $vars['entity'],
		'handler' => 'publications',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
	
	$subtitle = "$author_text $date $comments_link";
		
	$body = elgg_view('publications/details', $vars);

	$params = [
		'entity' => $entity,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', [
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	]);

} else {
	// brief view

	$list_body = elgg_view('publications/references', $vars);

	echo elgg_view_image_block(null, $list_body);
}
