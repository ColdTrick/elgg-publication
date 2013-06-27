<?php

// TODO: remove this as a seperate ajax loaded page and embed it into the edit form

gatekeeper();

$guid = get_input('guid');
$type = get_input('type');
$entity = get_entity($guid);

if($entity){
	if (!$entity->canEdit()) {
		exit();
	}
	$action = 'edit';
	$keywords = $entity->tags;
	$uri = $entity->uri;
	$year = $entity->year;
	$journal = $entity->journal;
	$publisher = $entity->publisher;
	$booktitle = $entity->booktitle;
	$school = $entity->school;
	$institution = $entity->institution;
	$volume = $entity->volume;
	$number = $entity->number;
	$pages = $entity->pages;
	$month = $entity->month;
	$note = $entity->note;
	$series = $entity->series;
	$address = $entity->address;
	$edition = $entity->edition;
	$organization = $entity->organization;
	$type_field = $entity->type_field;
} else {
	$action = 'add';
	$keywords = '';
	$uri = '';
	$year = '';
	$journal = '';
	$publisher = '';
	$booktitle = '';
	$school = '';
	$institution = '';
	$volume = '';
	$number = '';
	$pages = '';
	$month = '';
	$note = '';
	$series = '';
	$address = '';
	$edition = '';
	$organization = '';
	$type_field = '';
}

$required_text = elgg_echo("publications:forms:required");

//required filed by type
if($type == "ARTICLE"){
	$journal_label = elgg_echo('publication:journal');
	$journal_input = elgg_view('input/text',array('name'=>'journal','value'=>$journal));
	$custom_field .= "<p><label>$journal_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$journal_input</p>";
}else if($type == "INPROCEEDINGS"){
	$booktitle_label = elgg_echo('publication:booktitle');
	$booktitle_input = elgg_view('input/text',array('name'=>'booktitle','value'=>$booktitle));
	$custom_field .= "<p><label>$booktitle_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$booktitle_input</p>";
}else if($type == "BOOK"){
	$publisher_label = elgg_echo('publication:publisher');
	$publisher_input = elgg_view('input/text',array('name'=>'publisher','value'=>$publisher));
	$custom_field .= "<p><label>$publisher_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$publisher_input</p>";
}else if($type == "PHDTHESIS" || $type == "MASTERSTHESIS"){
	$school_label = elgg_echo('publication:school');
	$school_input = elgg_view('input/text',array('name'=>'school','value'=>$school));
	$custom_field .= "<p><label>$school_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$school_input</p>";
}else if($type == "TECHREPORT"){
	$institution_label = elgg_echo('publication:institution');
	$institution_input = elgg_view('input/text',array('name'=>'institution','value'=>$institution));
	$custom_field .= "<p><label>$institution_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$institution_input</p>";
}

$year_label = elgg_echo('publication:year');
$year_input = elgg_view('input/text',array('name'=>'year','value'=>$year));
$custom_field .= "<p><label>$year_label<span class='elgg-quiet mls'>$required_text</span></label><br/>$year_input</p>";

//optional fields by type
if($type == 'ARTICLE'){
	//ARTICLE
	$volume_label = elgg_echo('publication:volume');
	$volume_input = elgg_view('input/text',array('name'=>'volume','value'=>$volume));
	$custom_field .= "<p><label>$volume_label</label><br/>$volume_input</p>";
	$number_label = elgg_echo('publication:number');
	$number_input = elgg_view('input/text',array('name'=>'number','value'=>$number));
	$custom_field .= "<p><label>$number_label</label><br/>$number_input</p>";
	$pages_label = elgg_echo('publication:pages');
	$pages_input = elgg_view('input/text',array('name'=>'pages','value'=>$pages));
	$custom_field .= "<p><label>$pages_label</label><br/>$pages_input</p>";
}else if($type == 'INPROCEEDINGS'){
	//INPROCEEDINGS
	$volume_label = elgg_echo('publication:volume');
	$volume_input = elgg_view('input/text',array('name'=>'volume','value'=>$volume));
	$custom_field .= "<p><label>$volume_label</label><br/>$volume_input</p>";
	$number_label = elgg_echo('publication:number');
	$number_input = elgg_view('input/text',array('name'=>'number','value'=>$number));
	$custom_field .= "<p><label>$number_label</label><br/>$number_input</p>";
	$series_label = elgg_echo('publication:series');
	$series_input = elgg_view('input/text',array('name'=>'series','value'=>$series));
	$custom_field .= "<p><label>$series_label</label><br/>$series_input</p>";
	$pages_label = elgg_echo('publication:pages');
	$pages_input = elgg_view('input/text',array('name'=>'pages','value'=>$pages));
	$custom_field .= "<p><label>$pages_label</label><br/>$pages_input</p>";
	$address_label = elgg_echo('publication:address');
	$address_input = elgg_view('input/text',array('name'=>'address','value'=>$address));
	$custom_field .= "<p><label>$address_label</label><br/>$address_input</p>";
	$organization_label = elgg_echo('publication:organization');
	$organization_input = elgg_view('input/text',array('name'=>'organization','value'=>$organization));
	$custom_field .= "<p><label>$organization_label</label><br/>$organization_input</p>";
	$publisher_label = elgg_echo('publication:publisher');
	$publisher_input = elgg_view('input/text',array('name'=>'publisher','value'=>$publisher));
	$custom_field .= "<p><label>$publisher_label</label><br/>$publisher_input</p>";
}else if($type == 'BOOK'){
	//BOOK
	$volume_label = elgg_echo('publication:volume');
	$volume_input = elgg_view('input/text',array('name'=>'volume','value'=>$volume));
	$custom_field .= "<p><label>$volume_label</label><br/>$volume_input</p>";
	$number_label = elgg_echo('publication:number');
	$number_input = elgg_view('input/text',array('name'=>'number','value'=>$number));
	$custom_field .= "<p><label>$number_label</label><br/>$number_input</p>";
	$series_label = elgg_echo('publication:series');
	$series_input = elgg_view('input/text',array('name'=>'series','value'=>$series));
	$custom_field .= "<p><label>$series_label</label><br/>$series_input</p>";
	$address_label = elgg_echo('publication:address');
	$address_input = elgg_view('input/text',array('name'=>'address','value'=>$address));
	$custom_field .= "<p><label>$address_label</label><br/>$address_input</p>";
	$edition_label = elgg_echo('publication:edition');
	$edition_input = elgg_view('input/text',array('name'=>'edition','value'=>$edition));
	$custom_field .= "<p><label>$edition_label</label><br/>$edition_input</p>";
}else if($type == 'PHDTHESIS' || $type == 'MASTERSTHESIS'){
	//THESIS
	$type_field_label = elgg_echo('publication:type_field');
	$type_field_input = elgg_view('input/text',array('name'=>'type_field','value'=>$type_field));
	$custom_field .= "<p><label>$type_field_label</label><br/>$type_field_input</p>";
	$address_label = elgg_echo('publication:address');
	$address_input = elgg_view('input/text',array('name'=>'address','value'=>$address));
	$custom_field .= "<p><label>$address_label</label><br/>$address_input</p>";
}else if($type == 'TECHREPORT'){
	//TECHREPORT
	$type_field_label = elgg_echo('publication:type_field');
	$type_field_input = elgg_view('input/text',array('name'=>'type_field','value'=>$type_field));
	$custom_field .= "<p><label>$type_field_label</label><br/>$type_field_input</p>";
	$number_label = elgg_echo('publication:number');
	$number_input = elgg_view('input/text',array('name'=>'number','value'=>$number));
	$custom_field .= "<p><label>$number_label</label><br/>$number_input</p>";
	$address_label = elgg_echo('publication:address');
	$address_input = elgg_view('input/text',array('name'=>'address','value'=>$address));
	$custom_field .= "<p><label>$address_label</label><br/>$address_input</p>";
}

//common optional fields across all types
$keywords_label = elgg_echo('publication:keywords');
$keywords_input = elgg_view('input/tags', array('name' => 'publicationkeywords', 'value' => $keywords));

$uri_label = elgg_echo('publication:uri');
$uri_input = elgg_view('input/text', array('name' => 'uri', 'value' => $uri));

$month_label = elgg_echo('publication:month');
$month_input = elgg_view('input/text', array('name' => 'month', 'value'=> $month));

$note_label = elgg_echo('publication:note');
$note_input = elgg_view('input/text', array('name' => 'note', 'value' => $note));
$custom_field .= "<p><label>$month_label</label><br/>$month_input</p>";
$custom_field .= "<p><label>$keywords_label</label><br/>$keywords_input</p>";
$custom_field .= "<p><label>$uri_label</label><br/>$uri_input</p>";
$custom_field .= "<p><label>$note_label</label><br/>$note_input</p>";

echo $custom_field;
exit();