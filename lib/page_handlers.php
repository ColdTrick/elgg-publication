<?php

	function publication_page_handler($page) {
	
		// push all blogs breadcrumb
		elgg_push_breadcrumb(elgg_echo("publication:everyone"), "publications/all");
	
		switch($page[0]){
			case "all":
				include(dirname(dirname(__FILE__)) . "/pages/all.php");
				break;
			case "group":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(dirname(__FILE__)) . "/pages/group.php");
				break;
			case "owner":
				include(dirname(dirname(__FILE__)) . "/pages/owner.php");
				break;
			case "add":
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "custom_fields":
				include(dirname(dirname(__FILE__)) . "/pages/custom_fields.php");
				break;
			case "edit":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "view":
				if(isset($page[1])){
					set_input("guid", $page[1]);
				}
				include(dirname(dirname(__FILE__)) . "/pages/view.php");
				break;
			case "import":
				if (elgg_get_plugin_setting("enable_bibtex", "publications") == "yes") {
					include(dirname(dirname(__FILE__)) . "/pages/import.php");
					break;
				}
			case "author_autocomplete":
				include(dirname(dirname(__FILE__)) . "/procedures/author_autocomplete.php");
				break;
			default:
				forward("publications/all");
				break;
		}
	
		return true;
	}