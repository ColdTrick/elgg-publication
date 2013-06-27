<?php
	/**
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
	 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
	 * @link http://grc.ucalgary.ca/
	*/

	$authors = elgg_extract("authors", $vars, array());
	if (empty($authors)) {
		$authors = array(elgg_get_logged_in_user_guid());
	} elseif (!empty($authors) && !is_array($authors)) {
		$authors = array($authors);
	}
	
	echo elgg_view("input/author_autocomplete", array("name" => "authors", "id" => "publications-authors", "value" => $authors));
