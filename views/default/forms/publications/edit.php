<?php
/**
 * @package Elggi
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

$entity = elgg_extract("entity", $vars);

elgg_require_js('elgg/spinner');

// default field config
$field_config = [
	'type_selector' => [],
	'doi' => [],
	'url' => [],
	'note' => [],
	'attachment' => [],
];

$access_id = null;
$tags = '';
if ($entity instanceof Publication) {
	$access_id = (int) $entity->access_id;
	$tags = $entity->tags;
}

// default fields
foreach ($field_config as $input_type => $settings) {
	$settings = $settings + $vars;
	echo elgg_view("input/publications/{$input_type}", $settings);
}

// additional (non-BibTex) fields
echo elgg_view('publications/publication/edit/extend', $vars);

// tags
$keywords_label = elgg_format_element('label' , ['for' => 'publications-tags'], elgg_echo('publication:keywords'));
$keywords_input = elgg_view('input/tags', [
	'id' => 'publications-tags',
	'name' => 'tags',
	'value' => $tags,
]);
$keywords_input.= "<div class='elgg-subtext'>" . elgg_echo("publication:keywords:instruction") . "</div>";
echo elgg_format_element('div', [], $keywords_label . $keywords_input);

// access
$access_label = elgg_format_element('label', ['for' => 'publications-access'], elgg_echo("access"));
$access_input = '<br />';
$access_input .= elgg_view('input/access', [
	'id' => 'publications-access',
	'name' => 'access_id',
	'value' => $access_id,
	'type' => 'object',
	'subtype' => Publication::SUBTYPE,
	'entity' => $entity,
]);
echo elgg_format_element('div', [], $access_label . $access_input);

// required hint
$required_hint = elgg_echo("publications:forms:required:hint");
echo elgg_format_element('div', ['class' => 'hint'], $required_hint);

// footer
$footer = elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => elgg_get_page_owner_guid(),
]);
if ($entity instanceof Publication) {
	$footer .= elgg_view('input/hidden', [
		'name' => 'guid',
		'value' => $entity->getGUID(),
	]);
}
$footer .= elgg_view('input/submit', [
	'name' => 'submit',
	'value' => elgg_echo('publish'),
]);
echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);

?>
<script type='text/javascript'>
	elgg.publications.change_type();
</script>
