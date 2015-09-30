<?php

// set class handler to default Elgg handling
if (get_subtype_id('object', Publication::SUBTYPE)) {
	update_subtype('object', Publication::SUBTYPE);
}
