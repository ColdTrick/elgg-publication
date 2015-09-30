<?php

namespace ColdTrick\Publications;

class Upgrade {
	
	/**
	 * Update the class for publication subtype
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function upgrade($event, $type, $object) {
		
		// set correct class handler for Publication
		if (get_subtype_id('object', \Publication::SUBTYPE)) {
			update_subtype('object', \Publication::SUBTYPE, 'Publication');
		} else {
			add_subtype('object', \Publication::SUBTYPE, 'Publication');
		}
	}
}
