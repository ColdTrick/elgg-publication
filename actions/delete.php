<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$guid = (int) get_input('guid');

$publication = get_entity($guid);
if ($publication->getSubtype() == "publication" && $publication->canEdit()) {
	$owner = $publication->getOwnerEntity();
	if ($publication->delete()) {
		system_message(elgg_echo("publication:deleted"));
	} else {
		register_error(elgg_echo("publication:notdeleted"));
	}

	forward("publications/owner/" . $owner->username);
} else {
	forward(REFERER);
}
