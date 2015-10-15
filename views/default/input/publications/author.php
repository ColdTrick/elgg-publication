<?php
/**
 * Show an author input field
 *
 * @uses $vars['name'] (optional) the name for the input
 * @uses $vars['id'] (optional) the ID for the javascript
 * @uses $vars['value'] (optional) the current values
 * @uses $vars['label'] (optional) the label for the input
 * @uses $vars['entity'] when editing an entity the values will be auto extracted
 */

$entity = elgg_extract('entity', $vars);

$default_value = [elgg_get_logged_in_user_guid()];
if ($entity instanceof Publication) {
	$default_value = explode(',', $entity->authors);
}

$name = elgg_extract('name', $vars, 'authors');
$id = elgg_extract('id', $vars, 'publications-authors');
$minChars = elgg_extract('minChars', $vars, 3);

$value = elgg_extract('value', $vars, $default_value);

$destination = "{$id}_autocomplete_results";

// build form elements
$label_text = elgg_extract('label', $vars, elgg_echo('publication:forms:authors'));
if (elgg_extract('required', $vars, false)) {
	$label_text .= elgg_format_element('span', ['class' => 'elgg-quiet mls'], elgg_echo('publications:forms:required'));
}
$label = elgg_format_element('label', ['for' => "{$id}_autocomplete"], $label_text);

$input = elgg_view('input/text', [
	'id' => "{$id}_autocomplete",
	'class' => 'elgg-input elgg-input-autocomplete',
]);

$info = elgg_format_element('div', ['class' => 'elgg-subtext mbs'], elgg_echo('publications:form:author:input:info'));

$current_values = '';
if (!empty($value)) {
	if (!is_array($value)) {
		$value = [$value];
	}

	// make sure we can see all users
	$hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	foreach ($value as $v) {
		$current_value = '';
		
		if (is_numeric($v)) {
			// existing user
			if ($user = get_user($v)) {
				$current_value .= elgg_view('input/hidden', ['name' => "{$name}[]", 'value' => $v]);
				$current_value .= elgg_view('input/hidden', ['name' => "{$name}_order[]", 'value' => $v]);
				$current_value .= elgg_view_entity_icon($user, 'tiny');
				$current_value .= elgg_format_element('span', ['class' => 'author'], $user->name);
			}
		} else {
			// free text user
			$current_value .= elgg_view('input/hidden', ['name' => "{$name}_text[]", 'value' => $v]);
			$current_value .= elgg_view('input/hidden', ['name' => "{$name}_order[]", 'value' => $v]);
			$current_value .= $v;
		}

		$current_value .= elgg_view_icon('delete-alt', ['class' => 'mlm']);
		// add to list
		$current_values .= elgg_format_element('div', ['class' => "{$destination}_result"], $current_value);
	}

	// restore hidden settings
	access_show_hidden_entities($hidden);
}
$result_wrapper = elgg_format_element('div', ['id' => $destination], $current_values);

echo elgg_format_element('div', [], $label . $input . $info . $result_wrapper);
?>
<script type="text/javascript">
	$(document).ready(function() {

		$("#<?php echo $id; ?>_autocomplete").each(function() {
			var autocompleteActive = false;
			$(this)
			.focus(function(){ autocompleteActive = false; })
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}

				if ( event.keyCode === 13 ) {
					// don't submit form on enter
					event.preventDefault();

					if (!autocompleteActive) {
						var result = "";

						result += "<div class='<?php echo $destination; ?>_result'>";

						result += "<input type='hidden' value='" + $(this).val() + "' name='<?php echo $name; ?>_text[]' />";
						result += "<input type='hidden' value='" + $(this).val() + "' name='<?php echo $name; ?>_order[]' />";
						
						result += '<span class="author">';
						result += $(this).val();
						result += "</span>";

						result += "<span class='elgg-icon elgg-icon-delete-alt'></span>";
						result += "</div>";

						$('#<?php echo $destination; ?>').append(result);

						$(this).val('').blur();
					}
				}
			})
			.autocomplete({
				source: function( request, response ) {
					$.getJSON(elgg.get_site_url() +  "publications/author_autocomplete", {
						q: request.term,
						'user_guids[]': function() {
							var result = [];

							$("#<?php echo $destination; ?> input[name='<?php echo $name; ?>[]']").each(function(index, elem){
								if ($(elem).val() != "") {
									result.push($(elem).val());
								}
							});

							return result;
						}
					}, response );
				},
				delay: 0,
				search: function() {
					// custom minLength
					var term = this.value;
					if ( term.length < <?php echo $minChars; ?>){
						return false;
					}
				},
				focus: function(event, ui) {
					autocompleteActive = true;
					// prevent value inserted on focus
					event.preventDefault();
				},
				select: function( event, ui ) {
					autocompleteActive = true;
					this.value = "";
					var result = "";

					result += "<div class='<?php echo $destination; ?>_result'>";

					if(ui.item.type == "user"){
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>[]' />";
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>_order[]' />";
					} else if(ui.item.type == "text"){
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>_text[]' />";
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>_order[]' />";
					}

					result += '<span class="author">';
					result += ui.item.content;
					result += "</span>";

					result += "<span class='elgg-icon elgg-icon-delete-alt'></span>";
					result += "</div>";

					$('#<?php echo $destination; ?>').append(result);
					autocompleteActive = false;
					return false;
				},
				autoFocus: false,
				messages: {
			        noResults: '',
			        results: function() {}
			    }
			}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				var list_body = "";
				list_body += item.content;

				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + list_body + "</a>" )
					.appendTo( ul );
			};
		});

		$('#<?php echo $destination; ?> .elgg-icon-delete-alt').live("click", function(){
			$(this).parent('div').remove();
		});
	});

</script>
