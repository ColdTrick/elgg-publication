<?php
        /**
         * @package Elgg
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
         * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
         * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
         * @link http://grc.ucalgary.ca/
         */


if(is_array($vars['authors'])) {
	$authors = $vars['authors'];
} else if($vars['authors']){
	$authors = array();
	$authors[] = $vars['authors'];
}

$users = elgg_get_entities(array("type" => "user", "limit" => false)); // TODO this will cause performance issues if site grows larger

$sorted = array();
foreach($users as $user){
	$user_guid = $user->getGUID();
	$user_name = $user->name;
	$sorted[$user_guid] = $user_name;
}
natcasesort($sorted);
?>

<table>
	<tr>
	<td>
		<table>
		<tr><td>
		<select multiple='yes' id='authorselected' name='authorselected[]' size='8' style='width:22em'>
<?php
		if(is_array($authors)){
			foreach($authors as $author){
				if(!ctype_digit($author)){
					$guid = 'new';
					$name=$author;
				}else{
					$user = get_entity($author);
					$name = $user->name;
					$guid = $author;
				}
			echo "<option value='$guid,$name'>$name</option>";
			}
		}
?>
		</select>
		</td>
		<tr><td class="pvs">
			<a class='elgg-button elgg-button-action' onclick=up();>up</a>&nbsp
			<a class='elgg-button elgg-button-action' onclick=down();>down</a>
		</td></tr>
		<tr><td>
		 	<div>
            	<input type='text' id='unregistered'/><br/><br/>
                <a class='elgg-button elgg-button-action' onclick=addunregisteredauthor()>Add Unregistered Author</a>
            </div>
		</td></tr>
		
	</table>
	</td>
	<td class="pas">
		<a class='elgg-button elgg-button-action' onclick=add();><< add</a><br/>
		<a class='elgg-button elgg-button-action' onclick=remove();>remove >></a><br/>
	</td>
	<td>
		<select id='authorinput' name='authorinput' size='12' style='width:22em'>
<?php

                foreach($sorted as $key=>$value) {
                	echo "<option value='$key,$value'>$value</option>";
                }
?>
		</select>
	</td></tr>
	
</table>

