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

if (!in_array($type, array("book", "article_book", "article_journal"))) {
	$type = "article_book";
}

switch ($type) {
	case "article_book":
		if (!empty($entity->booktitle)) {
			$contents[] = $entity->booktitle;
		}
		if(!empty($entity->publisher)) {
			$contents[] = $entity->publisher;
		}

		break;
	case "article_journal":
		if(!empty($entity->journaltitle)) {
			$contents[] = $entity->journaltitle;
		}

		break;
	case "book":
	default:
		if(!empty($entity->publisher)) {
			$contents[] = $entity->publisher;
		}
		break;
}

if (!empty($entity->year)) {
	$contents[] = $entity->year;
}
if (!empty($entity->pages)) {
	$contents[] = elgg_echo("publications:list:pages", array($entity->pages));
}

echo implode($contents, ", ");