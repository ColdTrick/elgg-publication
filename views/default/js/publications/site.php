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
			},
			complete: spinner.stop
		});
	});
};

elgg.publications.change_type = function () {
	
	var val = $('#publications-type-selector').val();
	var guid = $('.elgg-form-publications-edit input[name="guid"]').val();
	
	elgg.publications.draw_custom_fields(val, guid);
};

elgg.publications.init = function(){
	$(".publications-add").submit(function() {
		var result = true;
		
		if(result && ($(this).find("#publications-authors_autocomplete_results").html().trim() == "")) {
			alert(elgg.echo("publications:forms:required:alert"));
			$("#publications-authors_autocomplete").focus();
			result = false;
		}
		
		if(result && $(this).find("#publications-book-editors_autocomplete_results").length && ($(this).find("#publications-book-editors_autocomplete_results").html().trim() == "")) {
			alert(elgg.echo("publications:forms:required:alert"));
			$("#publications-book-editors_autocomplete").focus();
			result = false;
		}
		
		return result;
	});
	
	$("#publications-authors_autocomplete_results").sortable({
		containment: "parent",
		axis: "y",
		tolerance: "pointer"
	});
	
	$('#publications-type-selector').on('change', elgg.publications.change_type);
};

//register init hook
elgg.register_hook_handler("init", "system", elgg.publications.init);
