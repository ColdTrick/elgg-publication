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
	
	/**
	 * Add a user as an author

	 * @param int $user_guid
	 *
	 * @return bool
	 */
	public function addAuthor($user_guid) {
		
		$user_guid = sanitize_int($user_guid, false);
		if (empty($user_guid)) {
			return false;
		}
		
		$result = (bool) $this->addRelationship($user_guid, 'author');
		
		$authors = explode(',', $this->authors);
		$authors[] = $user_guid;
		
		$this->authors = implode(',', $authors);
		
		return $result;
	}
}
