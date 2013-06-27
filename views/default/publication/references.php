<?php

/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$entity = $vars['entity'];

$type = $entity->pubtype;

$contents = array();

$authors = $entity->authors;
$authors = explode(',',$authors);
if (!empty($authors)) {
	foreach($authors as $index => $author) {
		
		if(!ctype_digit($author)) {
			$contents[] = $author;
		} else {
			if ($user = get_entity((int) $author)) {
				$contents[] = '<a href="' . elgg_get_site_url() . 'publications/owner/' . $user->username . '">' . $user->name . '</a>';
			}
		}
	}
}

$contents[] = elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title, "class" => "publications-list-title"));

if ($type == 'ARTICLE') {
	if(!empty($entity->journal)) {
		$contents[] = $entity->journal;
	}
} else if($type == 'INPROCEEDINGS') {
	if (!empty($entity->booktitle)) {
		$contents[] = elgg_echo("publications:list:inproceedings", array($entity->booktitle));
	}
} else if($type == 'BOOK') {
	if (!empty($entity->edition)) {
		$contents[] = elgg_echo("publications:list:edition", array($entity->edition));
	}
	if (!empty($entity->publisher)) {
		$contents[] = $entity->publisher;
	}
} else if($type == 'PHDTHESIS') {
	if (!empty($entity->school)) {
		$contents[] = elgg_echo("publications:list:phdthesis", array($entity->school));
	}
} else if($type == 'MASTERSTHESIS') {
	if (!empty($entity->school)) {
		$contents[] = elgg_echo("publications:list:mastersthesis", array($entity->school));
	}
} else if($type == 'TECHREPORT') {
	if (!empty($entity->institution)) {
		$contents[] = elgg_echo("publications:list:techreport", array($entity->institution));
	}
}

if (!empty($entity->year)) {
	$contents[] = $entity->year;
}
if (!empty($entity->pages)) {
	$contents[] = elgg_echo("publications:list:pages", array($entity->pages));
}

echo implode($contents, ", ");