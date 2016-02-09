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
		
		// find required autocompletes
		$(this).find('.elgg-input-autocomplete[data-required="1"]').each(function() {
			var id = $(this).attr('id');
			if ($('#' + id + '_results').html().trim() == "") {
				msg = msg + elgg.echo("publications:forms:required:alert") + '\n';
				$('#' + id).focus();
				result = false;
			}
		});
		
		// find partial/shared required autocompletes
		var partials = false;
		var partials_filled = false;
		
		$(this).find('.elgg-input-autocomplete[data-partial-required="1"]').each(function() {
			partials = true;
			var id = $(this).attr('id');
			if ($('#' + id + '_results').html().trim() != "") {
				partials_filled = true;
				return;
			}
		});
		
		if (partials && !partials_filled) {
			msg = msg + elgg.echo("publications:forms:partial_required:alert") + '\n';
			result = false;
		}
		
		// did we have errors
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
