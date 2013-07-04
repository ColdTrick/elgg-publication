<?php

/**
 * @package Elggi
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

gatekeeper();

$entity = elgg_extract("entity", $vars);

if ($entity) {
	$guid = $entity->getGUID();
	$action = "publications/edit";
	$type = $entity->pubtype;
	$title = $entity->title;

	$abstract = $entity->description;
	if (empty($abstract)) {
		$abstract = "";
	}

	$access_id = $entity->access_id;
	$highlight = 'default';
	$authors = $entity->authors;
	$authors = explode(',',$authors);
	$attachment_guid = $entity->attachment;

	if ($attachment_guid) {
		$attachment_entity = get_entity($attachment_guid);
		if ($attachment_entity) {
			$attachment_file = $attachment_entity->title;
		} else {
			$attachment_guid = '';
			$attachment_file = '';
		}
	} else {
		$attachment_file = '';
	}

} else {
	$access_id = null;
	$guid = '';
	$action = "publications/add";
	$title = "";
	$type = "ARTICLE";
	$abstract = "";
	$authors = array();
	$attachment_guid = '';
	$attachment_file = '';
}

// set the required variables

$type_label = elgg_echo('publication:type');
$type_dropdown = elgg_view("input/dropdown", array('name'=>'type', 'value'=>$type, 'onchange'=>"elgg.publications.draw_custom_fields(this.options[this.selectedIndex].text,'$guid')",'options'=>array('ARTICLE','INPROCEEDINGS','BOOK','PHDTHESIS','MASTERSTHESIS','TECHREPORT')));

$title_label = elgg_echo('title');
$title_textbox = elgg_view('input/text', array('name' => 'publicationtitle', 'value' => $title));
$abstract_label = elgg_echo('publication:abstract');
$abstract_textarea = elgg_view('input/longtext', array('name' => 'publicationabstract', 'value' => $abstract));

$submit_input = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('publish')));

$authors_input = elgg_view('publication/authorentry', array('authors' => $authors));

if(strtolower(elgg_get_plugin_setting('toggleattachment','publications')) !== 'off'){
	$attachment_title = elgg_echo('publication:attachment:title');
	$attachment_name = elgg_view('input/text',array('id'=>'attachment_name','name'=>'attachment_name','value'=>$attachment_file,'disabled'=>true));
	$attachment_hidden = elgg_view('input/hidden',array('id'=>'attachment_guid','name' => 'attachment_guid','value'=>$attachment_guid));
	$attachment = elgg_view('publication/embed/link',array('name'=>'pubattachment'));
}

$entity_hidden = '';
if ($entity) {
	$entity_hidden .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

$entity_hidden .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_entity()->getGUID()));

$access = "<label>" . elgg_echo("access") . "</label><br />" . elgg_view("input/access", array("name" => "access_id", "value" => $access_id));

$required_text = elgg_echo("publications:forms:required");
$authors_label = elgg_echo('publication:authors');

$attachment_label = elgg_echo("publication:attachment");
$attachment_input = elgg_view("input/file", array("name" => "attachment"));
$attachment_input .= "<div class='elgg-subtext'>" . elgg_echo("publication:attachment:instruction") . "</div>";
$form_body = <<<EOT
		<div>
			<label>$title_label<span class='elgg-quiet mls'>$required_text</span></label><br />
            $title_textbox
		</div>
		<div>
			<label>$type_label</label><br/>
			$type_dropdown
		</div>
		<div>
			<label>$authors_label<span class='elgg-quiet mls'>$required_text</span></label>
			$authors_input
		</div>
		<div>
			$access
		</div>
		<div>
			<label>$abstract_label</label><br />
            $abstract_textarea
		</div>
		<div>
			<label>$attachment_label</label><br />
            $attachment_input
		</div>
		<script type='text/javascript'>
			elgg.publications.draw_custom_fields('$type','$guid');
		</script>
		<div id='pub_custom_fields'></div>

		<div>
			$entity_hidden
			$submit_input
		</div>
EOT;

echo elgg_view('input/form', array('action' => "action/$action", 'body' => $form_body, "enctype" => "multipart/form-data", "class" => "publications-add"));