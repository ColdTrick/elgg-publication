<?php 
?>
//<script>
elgg.provide("elgg.publications");

elgg.publications.draw_custom_fields = function(type, guid){
	$.ajax({
		url: elgg.get_site_url() + '/publications/custom_fields',
		data:'type='+type+'&guid='+guid,
		success:function(data){
			$('#pub_custom_fields').html(data);
		},
	});	
}
