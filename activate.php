<?php

// set correct class handler for Publication
if (get_subtype_id('object', Publication::SUBTYPE)) {
	update_subtype('object', Publication::SUBTYPE, 'Publication');
} else {
	add_subtype('object', Publication::SUBTYPE, 'Publication');
}
