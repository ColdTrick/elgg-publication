<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$emails = get_input('emails');
$emailmessage = get_input('emailmessage');
$author = get_input('author');

if (!empty($author)) {
	$publication = get_input('publication');
}

if (empty($emails)) {
	register_error('No email addresses specified');
	forward(REFERER);
}

$emails = explode("\n", $emails);

global $CONFIG;

if (empty($emails)) {
	register_error(elgg_echo('invitefriends:failure'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$site = elgg_get_site_entity();

if (isset($site->email)) {
	$from = $site->email;
} else {
	$from = 'noreply@' . $site->getDomain();
}

$from = "{$site->name} <{$from}>";

$base_link_attributes = [
	'friend_guid' => $user->getGUID(),
	'invitecode' => generate_invite_code($user->username),
];

foreach ($emails as $email) {
	$email = trim($email);
	if (empty($email)) {
		continue;
	}
	
	$link_attributes = $base_link_attributes;
	
	if (!empty($author) && !empty($publication)) {
		$author = urlencode($author);
		$link_attributes['author'] = $author;
		$link_attributes['publication'] = $publication;
	}
	
	$link = elgg_normalize_url('account/register.php');
	$link = elgg_http_add_url_query_elements($link, $link_attributes);
	
	$subject = elgg_echo('invitefriends:subject', [$site->name]);
	$message = elgg_echo('invitefriends:email', [
		$site->name,
		$user->name,
		$emailmessage,
		$link
	]);
	
	elgg_send_email($from, $email, $subject, $message);
}

system_message(elgg_echo('invitefriends:success'));
forward(REFERER);
