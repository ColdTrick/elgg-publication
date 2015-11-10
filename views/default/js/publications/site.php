<?php
?>
//<script>
elgg.provide("elgg.publications");

elgg.publications.draw_custom_fields = function(type, guid) {

	require(['elgg/spinner'], function(spinner) {

		spinner.start();
		
		elgg.get('ajax/view/publications/publication/custom_fields', {
			data: {
				type: type,
				guid: guid
			},
			success: function(data) {
				$('#pub_custom_fields').html(data);
				// re-init sortable
				elgg.publications.init_author_sortable();
			},
			complete: spinner.stop
		});
	});
};

elgg.publications.change_type = function() {
	
	var val = $('#publications-type-selector').val();
	var guid = $('.elgg-form-publications-edit input[name="guid"]').val();
	
	elgg.publications.draw_custom_fields(val, guid);
};

elgg.publications.init_author_sortable = function() {
	$("#publications-authors_autocomplete_results, #publications-book-editors_autocomplete_results").sortable({
		containment: "parent",
		axis: "y",
		tolerance: "pointer"
	});
};

elgg.publications.init = function() {
	$(".publications-add").submit(function() {
		var result = true;
		var msg = '';
		
		var authors_mandatory = $('label[for="publications-authors_autocomplete"] span.elgg-quiet').length;
		if (authors_mandatory && $(this).find("#publications-authors_autocomplete_results").html().trim() == "") {
			msg = msg + elgg.echo("publications:forms:required:alert") + '\n';
			$("#publications-authors_autocomplete").focus();
			result = false;
		}
		
		var editors_mandatory = $('label[for="publications-book-editors_autocomplete"] span.elgg-quiet').length;
		if (editors_mandatory && $(this).find("#publications-book-editors_autocomplete_results").html().trim() == "") {
			msg = msg + elgg.echo("publications:forms:required:alert") + '\n';
			$("#publications-book-editors_autocomplete").focus();
			result = false;
		}
		
		if (!result) {
			alert(msg);
		}
		
		return result;
	});
	
	$('#publications-type-selector').on('change', elgg.publications.change_type);

	$('#publications-filter-selector').change(function() {
		var url = window.location.href;
		if (window.location.search.length) {
			url = url.substring(0, url.indexOf('?'));
		}
		url += '?' + $(this).val();
		elgg.forward(url);
	});


};


//register init hook
elgg.register_hook_handler("init", "system", elgg.publications.init);
