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

$contents = [];

/* PUBLICATION TYPE */
switch ($type) {
	case "article_book":
		$type_name = elgg_echo('publications:type:article_book');
		break;
	case "article_journal":
		$type_name = elgg_echo('publications:type:article_journal');
		break;
	case "book":
	default:
		$type_name = elgg_echo('publications:type:book');
		break;
}

$contents[] = '<span class="publication-type">' . $type_name . '</span>';

/* TITLE */
$contents[] = '<h3 class="publication-title">' . elgg_view("output/url", [
	"href" => $entity->getURL(),
	"text" => $entity->title,
	"class" => "publications-list-title"
]) . '</h3>';

/* METADATA */
$contents[] = '<ul class="publication-data">';

$authors = $entity->authors;
$authors = explode(',',$authors);
if (!empty($authors)) {
	foreach ($authors as $index => $author) {

		if (!ctype_digit($author)) {
			$contents[] = '<li class="author">' . $author . '</li>';
		} else {
			$user = get_entity($author);
			if (!empty($user)) {
				$contents[] = '<li class="author">' . elgg_view('output/url', [
					'text' => $user->name,
					'href' => "publications/owner/{$user->username}",
					'title' => elgg_echo("publications:seeall") . ' ' . $user->name,
					'class' => 'tooltip-hint',
				]) . '</li>';
			}
		}
	}
}

if (!in_array($type, ["book", "article_book", "article_journal"])) {
	$type = "article_book";
}

switch ($type) {
	case "article_book":
		if (!empty($entity->booktitle)) {
			$contents[] = '<li class="pub-type book-title">' . $entity->booktitle . '</li>';
		}
		if(!empty($entity->publisher)) {
			$contents[] = '<li class="pub-type publisher">' . $entity->publisher . '</li>';
		}

		break;
	case "article_journal":
		if(!empty($entity->journaltitle)) {
			$contents[] = '<li class="pub-type journal-title">' . $entity->journaltitle . '</li>';
		}

		break;
	case "book":
	default:
		if(!empty($entity->publisher)) {
			$contents[] = '<li class="pub-type book">' . $entity->publisher . '</li>';
		}
		break;
}

if (!empty($entity->year)) {
	$contents[] = '<li class="year">(' . $entity->year . ')</li>';
}
/*if (!empty($entity->pages)) {
	$contents[] = '<li class="pages">' . elgg_echo("publications:list:pagestotal", [$entity->pages]) . '</li>';
}*/

$contents[] = '</ul>';

echo implode($contents, "");
