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
	public static function setClassHandler($event, $type, $object) {
		
		// set correct class handler for Publication
		if (get_subtype_id('object', \Publication::SUBTYPE)) {
			update_subtype('object', \Publication::SUBTYPE, 'Publication');
		} else {
			add_subtype('object', \Publication::SUBTYPE, 'Publication');
		}
	}
	
	/**
	 * Update the publication type article_book to inbook (BibTex standard)
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function updateArticleBook($event, $type, $object) {
		
		$options = [
			'type' => 'object',
			'subtype' => \Publication::SUBTYPE,
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'pubtype',
				'value' => 'article_book'
			],
		];
		$entities = new \ElggBatch('elgg_get_entities_from_metadata', $options);
		$entities->setIncrementOffset(false);
		foreach ($entities as $entity) {
			// convert article_book to inbook
			$entity->pubtype = 'inbook';
			$entity->save();
		}
		
	}
	
	/**
	 * Update the publication type article_journal to article (BibTex standard)
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function updateArticleJournal($event, $type, $object) {
		
		$options = [
			'type' => 'object',
			'subtype' => \Publication::SUBTYPE,
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'pubtype',
				'value' => 'article_journal'
			],
		];
		$entities = new \ElggBatch('elgg_get_entities_from_metadata', $options);
		$entities->setIncrementOffset(false);
		foreach ($entities as $entity) {
			// convert article_journal to article
			$entity->pubtype = 'article';
			$entity->save();
		}
		
	}
	
	/**
	 * Move the imported abstract fields to description
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function abstractToDescription($event, $type, $object) {
		
		$options = [
			'type' => 'object',
			'subtype' => \Publication::SUBTYPE,
			'limit' => false,
			'metadata_name' => 'abstract',
		];
		$entities = new \ElggBatch('elgg_get_entities_from_metadata', $options);
		$entities->setIncrementOffset(false);
		foreach ($entities as $entity) {
			
			// append abstract to description
			$entity->description .= ' ' . $entity->abstract;
			// remove trailing spaces
			trim($entity->description);
			
			// unset abstract
			unset($entity->abstract);
			
			// save new data
			$entity->save();
		}
	}
}
