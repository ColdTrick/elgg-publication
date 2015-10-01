<?php
/**
 * @package Elggi
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$entity = elgg_extract("entity", $vars);

if ($entity) {
	$guid = $entity->getGUID();
	
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
	
	$title = "";
	$type = "book";
	$abstract = "";
	$authors = [];
	$attachment_guid = '';
	$attachment_file = '';
	$year = '';
	$keywords = '';

	$uri = '';
	$translation = '';

	$promotion = '';
}

$types = publications_get_types();
if (!in_array($type, $types)) {
	$type = "article_book";
}

// set the required variables
$type_options = [];
foreach ($types as $type_option) {
	$label = $type_option;
	if (elgg_language_key_exists("publications:type:{$type_option}")) {
		$label = elgg_echo("publications:type:{$type_option}");
	}
	$type_options[$type_option] = $label;
}
$type_label = elgg_echo('publication:type');
$type_dropdown = elgg_view("input/select", [
	'name' => 'type',
	'value' => $type,
	'onchange' => "elgg.publications.draw_custom_fields($(this).val(),'$guid')",
	'options_values' => $type_options
]);

$title_label = elgg_echo('title');
$title_textbox = elgg_view('input/text', [
	'name' => 'publicationtitle',
	'value' => $title
]);

$year_label = elgg_echo('publication:year');
$year_input = elgg_view('input/text', [
	'name' => 'year',
	'value' => $year
]);

$abstract_label = elgg_echo('publication:abstract');
$abstract_textarea = elgg_view('input/longtext', [
	'name' => 'publicationabstract',
	'value' => $abstract
]);

$submit_input = elgg_view('input/submit', [
	'name' => 'submit',
	'value' => elgg_echo('publish')
]);

$authors_input = elgg_view('publications/authorentry', [
	'authors' => $authors
]);

if (strtolower(elgg_get_plugin_setting('toggleattachment','publications')) !== 'off') {
	$attachment_title = elgg_echo('publication:attachment:title');
	$attachment_name = elgg_view('input/text', [
		'id' => 'attachment_name',
		'name' => 'attachment_name',
		'value' => $attachment_file,
		'disabled' => true
	]);
	$attachment_hidden = elgg_view('input/hidden', [
		'id'=>'attachment_guid',
		'name' => 'attachment_guid',
		'value' => $attachment_guid
	]);
}

$entity_hidden = '';
if ($entity) {
	$entity_hidden .= elgg_view('input/hidden', [
		'name' => 'guid',
		'value' => $guid
	]);
}

$entity_hidden .= elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => elgg_get_page_owner_entity()->getGUID()
]);

$access = "<label>" . elgg_echo("access") . "</label><br />";
$access .= elgg_view("input/access", [
	"name" => "access_id",
	"value" => $access_id
]);

$required_text = elgg_echo("publications:forms:required");
$required_hint = elgg_echo("publications:forms:required:hint");
$authors_label = elgg_echo('publication:forms:authors');

$attachment_label = elgg_echo("publication:attachment");
$attachment_input = elgg_view("input/file", [
	"name" => "attachment"
]);
$attachment_input .= "<div class='elgg-subtext'>" . elgg_echo("publication:attachment:instruction") . "</div>";

//common optional fields across all types

$keywords_label = elgg_echo('publication:keywords');

$keywords_input = elgg_view('input/tags', [
	'name' => 'publicationkeywords',
	'value' => $keywords
]);
$keywords_input.= "<div class='elgg-subtext'>" . elgg_echo("publication:keywords:instruction") . "</div>";


$uri_label = elgg_echo('publication:uri');
$uri_input = elgg_view('input/text', [
	'name' => 'uri',
	'value' => $uri
]);

$translation_label = elgg_echo('publication:translation');
$translation_input = elgg_view('input/checkbox', [
	'name' => 'translation',
	'value' => '1',
	'checked' => ($translation == true)
]);

$promotion_label = elgg_echo('publication:promotion');
$promotion_input = elgg_view('input/checkbox', [
	'name' => 'promotion',
	'value' => '1',
	'checked' => ($promotion == true)
]);

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
			$translation_input <label>$translation_label</label>
		</div>
		<div>
			$promotion_input <label>$promotion_label</label>
		</div>
		<div>
			$access
		</div>
		<div class="hint">
			$required_hint
		</div>
		<div>
			$entity_hidden
			$submit_input
		</div>
EOT;

echo $form_body;
