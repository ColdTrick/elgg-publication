<?php

/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$type = $vars['entity']->pubtype;
$info = "<em><b><a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a></b></em>";

$contents = array();

$authors = $vars['entity']->authors;
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

$contents[] = "<i>$info</i>";

if ($type == 'ARTICLE') {
	if(!empty($vars['entity']->journal)) {
		$contents[] = $vars['entity']->journal;
	}
} else if($type == 'INPROCEEDINGS') {
	if (!empty($vars['entity']->booktitle)) {
		$contents[] =  "Proceedings of the " . $vars['entity']->booktitle;
	}
} else if($type == 'BOOK') {
	if (!empty($vars['entity']->edition)) {
		$contents[] = $vars['entity']->edition . " ed.";
	}
	if (!empty($vars['entity']->publisher)) {
		$contents[] = $vars['entity']->publisher;
	}
} else if($type == 'PHDTHESIS') {
	if (!empty($vars['entity']->school)) {
		$contents[] = "PhD Thesis, " .$vars['entity']->school;
	}
} else if($type == 'MASTERSTHESIS') {
	if (!empty($vars['entity']->school)) {
		$contents[] = "Masters Thesis, " .$vars['entity']->school;
	}
} else if($type == 'TECHREPORT') {
	if (!empty($vars['entity']->institution)) {
		$contents[] = "Techreport, " .$vars['entity']->institution;
	}
}

if (!empty($vars['entity']->year)) {
	$contents[] = $vars['entity']->year;
}
if (!empty($vars['entity']->pages)) {
	$contents[] = 'pp. ' . $vars['entity']->pages;
}

// $page_owner = elgg_get_page_owner_entity();
// if($page_owner instanceof ElggGroup){
// 	if(elgg_is_logged_in() && $page_owner->isMember(elgg_get_logged_in_user_guid())){
// 		$contents[] = elgg_view('publication/tag', array('pub' => $vars['entity']->guid, 'group' => $page_owner->getGUID()));
// 	}
// }

echo implode($contents, ", ");