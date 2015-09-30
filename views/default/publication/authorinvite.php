<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$exauthor = elgg_extract("exauthor", $vars);
$formatauthor = preg_replace('/ /','_',$exauthor);
$publication_guid = (int) elgg_extract("publication_guid", $vars);
$publication = get_entity($publication_guid);
$publication_title = $publication->title;
$invitee = elgg_get_logged_in_user_entity();
$invitee_name = $invitee->name;

$canedit = (bool) elgg_extract("canedit", $vars, false);
$canedit = false; // disable invites for now

$userinfo = elgg_view_image_block("<div class='elgg-avatar elgg-avatar-tiny'><a><img border='0' src='" . elgg_get_site_url() . "/_graphics/icons/user/defaulttiny.gif'/></a></div>", "<b>$exauthor</b>");

if ($canedit) {
	if (elgg_get_plugin_setting('toggleinvites','publications') != 'Off') {
		$userinfo .= " <input type=button class='submit_button' value='invite' onclick=\"show_dialog('$exauthor');\"/>";
	}
}

echo $userinfo;

if ($canedit) {
	$content = '<p>' . elgg_echo("publication:inviteinfomsg", [$exauthor, $exauthor]) . '</p>';
	$content .= "<p><label>Enter email address</label>";
	$content .= elgg_view('input/email', [
		'name' => 'emails',
		'id' => 'emails'
	]);
	$content .= "</p><p><label>Message</label>";
	$content .= "<textarea class='input-textarea' name='emailmessage'>" . elgg_echo('publication:invitemsg', [$exauthor, $publication_title, $invitee_name]) . elgg_echo('publication:additionalmsg') . "</textarea></p>";
	$content .= "<input type='hidden' name='author' value=''/>";
	$content .= "<input type='hidden' name='publication' value='$publication_guid' />";
	$content .= "<input type='submit' value='invite'/>&nbsp<input type='button' value='cancel' onclick=\"hide_dialog('$formatauthor')\"/>";
	
	$form = elgg_view('input/form', [
		'action' => elgg_get_site_url() . "action/publications/invite",
		'body' => $content
	]);
	
	echo "<div style='display:none' id='invite_dialog_$formatauthor' class='publication_dialog'>$form</div>";

?>
<script type='text/javascript'>
	function show_dialog(author){
		$("input:hidden[name='author']").val(author);
		var formatauthor = author.replace(/ /g,'_');
        $('#invite_dialog_'+formatauthor).show();
	}
	
	function hide_dialog(author){
		var formatauthor = author.replace(/ /g,'_');
        $('#invite_dialog_'+formatauthor).hide();
	}
</script>
<?php
} // end canedit
