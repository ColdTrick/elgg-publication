<?php

class Publication extends ElggObject {
	
	const SUBTYPE = 'publication';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		return elgg_normalize_url("publications/view/{$this->getGUID()}/" . elgg_get_friendly_title($this->title));
	}
}
