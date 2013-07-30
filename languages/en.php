<?php
	/**
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
	 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
	 * @link http://grc.ucalgary.ca/
	 */

	$english = array(

		// new keys



		'publications:settings:enable_bibtex' => "Enable BibTex import and export features",




		'publications:forms:required' => "*",
		'publications:forms:required:hint' => "* required fields",

		'publications:forms:required:alert' => "Please fill out all required fields.",

		'publications:list:pages' => "pp. %s",

		'publications:list:edition' => "%s ed.",

		'publications:list:techreport' => "Techreport, %s",

		'publications:list:mastersthesis' => "Masters Thesis, %s",

		'publications:list:phdthesis' => "PhD Thesis, %s",

		'publications:list:inproceedings' => "Proceedings of the %s",


		'publications:type:book' => "Book",

		'publications:type:article_book' => "Article in a book",

		'publications:type:article_journal' => "Article in a journal/review",


		'publications:details:attachment:download' => "Click to download attachment",

		'publications:details:translation' => "Text is a translation",

		'publications:details:promotion' => "Text is part of a promotion",


		'publication:forms:authors' => "Authors",
		'publications:form:author:input:info' => "Type in the first letters of the author's name and select the suggested author from the dropdown list or simply add a new one. Hit enter to add the author of your publication.",






















		// old keys

		'publication:keywords' => "Keywords",
		'publication:keywords:instruction' => "",
		'publication:exauthors' => "Additional Authors (not registered)",
		'publication:authors' => "Authors",
		'publication:uri' => "URI",
		'publication:url' => "URL",
		'publication:doi' => "DOI",
		'publication:source' => "Source (e.g. journal, conference proceedings, book, thesis)",
		'publication:attachment' => 'Attach File',
		'publication:attachment:instruction' => 'Click on any file to attach it to your publication',
		'publication:file' => 'Files',
		'publication:upload' => 'Upload Files',
		'publication:attachment:title' => 'File Attachment',
		'publication:type'=>'Type',
		'publication:source:ref' => "Source",
		'publication:inviteinfomsg' => "<b>%s</b> is not a registered user.<br/>Send an invitation to <b>%s</b> to join our Community.",
		'publication:invitemsg'=> "Hi %s,

I have included you as an author on a publication titled: '%s' on our Portal. I invite you to register for our Community.

%s

",
		'publication:additionalmsg'=>"\"[Text about your community]\"",
		'publication:volume' => "Volume",
		'publication:number' => "Number",
		'publication:month'=> "Month",
		'publication:pages' => "Number of pages",
		'publication:page_from' => "Page from",
		'publication:page_to' => "Page to",
		'publication:year' => "Year",
		'publication:booktitle' => "Title of book",
		'publication:book_editors' => "Book editors",
		'publication:translation' => "Is your text a translation?",
		'publication:promotion' => "Is it part of a promotion?",
		'publication:journaltitle' => "Title of journal/review",
		'publication:journal' => "Journal",
		'publication:publisher' => "Publishing company",
		'publication:publish_location' => "Place of publication",
		'publication:school' => "School",
		'publication:institution' => "Institution",
		'publication:note' => "Note",
		'publication:series' => "Series",
		'publication:address' => "Address",
		'publication:organization' => "Organization",
		'publication:edition' => "Edition",
		'publication:type_field' => "Type",
		'publication' => "Publication",
		'publications' => "Publications",
		'publication:user' => "%s's publication",
		'publication:user:friends' => "%s's contacts' publication",
		'publication:modify' => 'External Authors Invititation: ',
		'publication:your' => "Your publications",

		'publication:authored:your' => "Publications authored",
		'publication:catalogued:your' => "Publications catalogued",
		'publications:catalogued' => "publications catalogued",
		'publication:posttitle' => "%s's publication: %s",
		'publication:friendsselect'=>"Select Contact to View Publications",
		'publication:friends' => "Contacts' publications",
		'publication:yourfriends' => "Your contacts' latest publications",
		'publication:everyone' => "All site publications",
		'publication:new' => "New publication",
		'publication:newpost'=>'New Publication on your community',
		'publication:via' => "added a new publication titled",
		'publication:read' => "Read publication",
		'publications:add' => "Add a publication",
		'publication:add' => "Add a publication",
		'publication:export' => "Export to BibTeX File",
		'publication:export:confirm:all' => "Do you want to export all publications as a BibTeX file?",
		'publication:export:confirm:user' => "Do you want to export all %s's publications as a BibTeX file?",
		'publication:export:confirm:single' => "Do you want to export this publication as a BibTeX file?",
		'publication:import' => "Import BibTeX File",
		'publication:bibtex' => 'BibTeX File',
		'publication:selectimport' => 'Select file',
		'publication:group:tag' => "Tag a publication",
		'publication:saveimport' => 'Import',
		'publication:edit' => "Edit a publication",
		'publication:abstract' => "Abstract",
		'publication:details' => "Details",
		'publication:strapline' => "%s",
		'item:object:publication' => 'Publications',
		'publication:never' => 'never',
		'publication:draft:save' => 'Save draft',
		'publication:draft:saved' => 'Draft last saved',
		'publication:comments:allow' => 'Allow comments',
		'publication:bibtex:fileerror' => 'BibTex file not found',
		'publication:bibtex:blank' => 'BibTex file has no entries',
		'publication:enablepublication' => 'Enable group publication',
		'publication:group' => 'Group publications',
		'publication:search' => 'Search Publications',
        'river:create:object:publication' => "%s wrote a new publication titled %s",
        'river:update:object:publication' => "%s updated a publication titled %s",
        'publication:river:posted' => "%s posted",
        'publications:widget' => "Publications",
        'publications:widget:description' => "Add a list of publications to your profile",
        'publication:river:annotate' => "a comment on this publication",
		'publication:posted' => "Your publication was successfully posted.",
		'publication:deleted' => "Your publication was successfully deleted.",
		'publication:error' => 'Something went wrong. Please try again.',
		'publication:save:failure' => "Your publication could not be saved. Please try again.",
		'publication:blank' => "Sorry; you need to fill in both the title and body before you can post this publication.",
		'publication:blankauthors' => "No authors selected.",
		'publication:blankdefault' => "Please fill in all required fields.",
		'publication:notfound' => "Sorry; we could not find the specified publication.",
		'publication:notdeleted' => "Sorry; we could not delete this publication.",
	);

	add_translation("en",$english);
