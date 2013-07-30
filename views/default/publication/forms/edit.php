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
	$year = $entity->year;
	$keywords = $entity->tags;

	$uri = $entity->uri;
	$translation = $entity->translation;
	$promotion = $entity->promotion;

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
	$type = "book";
	$abstract = "";
	$authors = array();
	$attachment_guid = '';
	$attachment_file = '';
	$year = '';
	$keywords = '';

	$uri = '';
	$translation = '';

	$promotion = '';
}

if (!in_array($type, array("book", "article_book", "article_journal"))) {
	$type = "article_book";
}

// set the required variables
$type_options = array(
		"book" => elgg_echo("publications:type:book"),
		"article_book" => elgg_echo("publications:type:article_book"),
		"article_journal" => elgg_echo("publications:type:article_journal")
		);
$type_label = elgg_echo('publication:type');
$type_dropdown = elgg_view("input/dropdown", array('name'=>'type', 'value' => $type, 'onchange'=>"elgg.publications.draw_custom_fields($(this).val(),'$guid')",'options_values' => $type_options));

$title_label = elgg_echo('title');
$title_textbox = elgg_view('input/text', array('name' => 'publicationtitle', 'value' => $title));

$year_label = elgg_echo('publication:year');

$year_input = elgg_view('input/text', array('name' => 'year', 'value' => $year));

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

//common optional fields across all types

$keywords_label = elgg_echo('publication:keywords');

$keywords_input = elgg_view('input/tags', array('name' => 'publicationkeywords', 'value' => $keywords));



$uri_label = elgg_echo('publication:uri');

$uri_input = elgg_view('input/text', array('name' => 'uri', 'value' => $uri));

$translation_label = elgg_echo('publication:translation');

$translation_input = elgg_view('input/checkbox', array('name' => 'translation', 'value' => '1', 'checked' => ($translation == true)));

$promotion_label = elgg_echo('publication:promotion');

$promotion_input = elgg_view('input/checkbox', array('name' => 'promotion', 'value' => '1', 'checked' => ($promotion == true)));

$form_body = <<<EOT
		<div>
			<label>$title_label<span class='elgg-quiet mls'>$required_text</span></label><br />
            $title_textbox
		</div>
		<div>
			<label>$authors_label<span class='elgg-quiet mls'>$required_text</span></label>
			$authors_input
		</div>
		<div>
			<label>$year_label<span class='elgg-quiet mls'>$required_text</span></label><br/>
			$year_input
		</div>
		<div>
			<label>$abstract_label</label><br />
            $abstract_textarea
		</div>
		<div>
			<label>$attachment_label</label><br />
            $attachment_input
		</div>
		<div>
			<label>$type_label</label><br/>
			$type_dropdown
		</div>
		<script type='text/javascript'>
			elgg.publications.draw_custom_fields('$type','$guid');
		</script>
		<div id='pub_custom_fields'></div>
		<div>
			<label>$keywords_label</label><br/>
			$keywords_input
		</div>
		<div>
			<label>$uri_label</label><br/>
			$uri_input
		</div>
		<div>
			<label>$translation_label</label> $translation_input
		</div>
		<div>
			<label>$promotion_label</label> $promotion_input
		</div>
		<div>
			$access
		</div>
		<div>
			$entity_hidden
			$submit_input
		</div>
EOT;

echo elgg_view('input/form', array('action' => "action/$action", 'body' => $form_body, "enctype" => "multipart/form-data", "class" => "publications-add"));