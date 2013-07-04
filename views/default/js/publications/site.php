<?php
?>
//<script>
elgg.provide("elgg.publications");

elgg.publications.draw_custom_fields = function(type, guid){
	$.ajax({
		url: elgg.get_site_url() + 'publications/custom_fields',
		data:'type='+type+'&guid='+guid,
		success:function(data){
			$('#pub_custom_fields').html(data);
		},
	});
}

elgg.publications.init = function(){
	$(".publications-add").submit(function() {
		var result = true;

		$(this).find("[name='publicationtitle'],[name='journal'],[name='year'],[name='booktitle'],[name='publisher'],[name='school'],[name='institution']").each(function(index, elem) {
			if($(elem).val() == "") {
				alert(elgg.echo("publications:forms:required:alert"));
				$(elem).focus();
				result = false;
				return false;
			}
		});

		if(result && ($(this).find("#publications-authors_autocomplete_results").html().trim() == "")) {
			alert(elgg.echo("publications:forms:required:alert"));
			$("#publications-authors_autocomplete").focus();
			result = false;
		}

		return result;
	});
}
//register init hook
elgg.register_hook_handler("init", "system", elgg.publications.init);
