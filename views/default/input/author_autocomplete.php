<?php

$name = elgg_extract("name", $vars); // input name of the selected user
$id = elgg_extract("id", $vars);
$minChars = elgg_extract("minChars", $vars, 3);

$value = elgg_extract("value", $vars);

$destination = $id . "_autocomplete_results";

?>
<input type="text" id="<?php echo $id; ?>_autocomplete" class="elgg-input elgg-input-autocomplete" />
<div class="elgg-subtext mbs"><?php echo elgg_echo("publications:form:author:input:info"); ?></div>
<div id="<?php echo $destination; ?>">
	<?php
		if (!empty($value)) {
			if (!is_array($value)) {
				$value = array($value);
			}

			// make sure we can see all users
			$hidden = access_get_show_hidden_status();
			access_show_hidden_entities(true);

			foreach($value as $v) {
				echo "<div class='" . $destination . "_result'>";

				if (is_numeric($v)) {
					// existing user
					if ($user = get_user($v)) {
						echo elgg_view("input/hidden", array("name" => $name . "[]", "value" => $v));
						echo elgg_view("input/hidden", array("name" => "authors_order[]", "value" => $v));
						echo elgg_view_entity_icon($user, "tiny");
						echo $user->name;
					}
				} else {
					// free text user
					echo elgg_view("input/hidden", array("name" => $name . "_text[]", "value" => $v));
					echo elgg_view("input/hidden", array("name" => "authors_order[]", "value" => $v));
					echo $v;
				}

				echo "<span class='elgg-icon elgg-icon-delete-alt'></span>";
				echo "</div>";
			}

			// restore hidden settings
			access_show_hidden_entities($hidden);
		}
	?>
</div>

<div class="clearfloat"></div>

<script type="text/javascript">
	$(document).ready(function() {

		$("#<?php echo $id; ?>_autocomplete").each(function() {
			$(this)
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}

				if ( event.keyCode === 13 ) {
					// don't submit form on enter
					event.preventDefault();
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
				search: function() {
					// custom minLength
					var term = this.value;
					if ( term.length < <?php echo $minChars; ?>){
						return false;
					}
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					this.value = "";
					var result = "";

					result += "<div class='<?php echo $destination; ?>_result'>";

					if(ui.item.type == "user"){
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>[]' />";
						result += "<input type='hidden' value='" + ui.item.value + "' name='authors_order[]' />";
					} else if(ui.item.type == "text"){
						result += "<input type='hidden' value='" + ui.item.value + "' name='<?php echo $name; ?>_text[]' />";
						result += "<input type='hidden' value='" + ui.item.value + "' name='authors_order[]' />";
					}
					result += ui.item.content;

					result += "<span class='elgg-icon elgg-icon-delete-alt'></span>";
					result += "</div>";

					$('#<?php echo $destination; ?>').append(result);
					return false;
				},
				autoFocus: true
			}).data( "autocomplete" )._renderItem = function( ul, item ) {
				var list_body = "";
				list_body = item.content;


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