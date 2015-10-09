<?php

$entity = elgg_extract('entity', $vars);

$required_text = elgg_echo("publications:forms:required");
$required = elgg_format_element('span', ['class' => ['elgg-quiet', 'mls']], $required_text);

$journaltitle = '';
$number = '';
$page_from = '';
$page_to = '';

if ($entity instanceof Publication) {
	$journaltitle = $entity->journaltitle;
	$number = $entity->number;
	$page_from = $entity->page_from;
	$page_to = $entity->page_to;
}

// journal title
$journal_title_input = elgg_format_element('label', ['for' => 'publication-journal-title'], elgg_echo('publication:journaltitle') . $required);
$journal_title_input .= elgg_view('input/text', [
	'name' => 'data[journaltitle]',
	'value' => $journaltitle,
	'id' => 'publication-journal-title',
	'required' => true,
]);
echo elgg_format_element('div', [], $journal_title_input);

// number
$number_input = elgg_format_element('label', ['for' => 'publication-number'], elgg_echo('publication:number') . $required);
$number_input .= elgg_view('input/text', [
	'name' => 'data[number]',
	'value' => $number,
	'id' => 'publication-number',
	'required' => true,
]);
echo elgg_format_element('div', [], $number_input);

// page from
$page_from_input = elgg_format_element('label', ['for' => 'publication-page-from'], elgg_echo('publication:page_from') . $required);
$page_from_input .= elgg_view('input/text', [
	'name' => 'data[page_from]',
	'value' => $page_from,
	'id' => 'publication-page-from',
	'required' => true,
]);
echo elgg_format_element('div', [], $page_from_input);

// page to
$page_to_input = elgg_format_element('label', ['for' => 'publication-page-to'], elgg_echo('publication:page_to') . $required);
$page_to_input .= elgg_view('input/text', [
	'name' => 'data[page_to]',
	'value' => $page_to,
	'id' => 'publication-page-to',
	'required' => true,
]);
echo elgg_format_element('div', [], $page_to_input);
