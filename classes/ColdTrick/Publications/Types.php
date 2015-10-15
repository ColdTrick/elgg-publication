<?php

namespace ColdTrick\Publications;

class Types {
	
	/**
	 * Add a publication type
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function registerTypeBook($hook, $type, $return_value, $params) {
		
		$return_value[] = 'book';
		
		return $return_value;
	}
	
	/**
	 * Add a publication type
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function registerTypeInBook($hook, $type, $return_value, $params) {
		
		$return_value[] = 'inbook';
		
		return $return_value;
	}
	
	/**
	 * Add a publication type
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function registerTypeArticle($hook, $type, $return_value, $params) {
		
		$return_value[] = 'article';
		
		return $return_value;
	}
	
	/**
	 * Validate the input for the custom type 'book'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputBook($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'publisher',
		];
		
		foreach ($required_fields as $field) {
			$field_value = elgg_extract($field, $data);
		
			if (empty($field_value)) {
				register_error(elgg_echo('publication:blankdefault'));
				return false;
			}
		}
	}
	
	/**
	 * Validate the input for the custom type 'article_book'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputInBook($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'booktitle',
			'publisher',
			'page_from',
			'page_to',
		];
		
		// for readability spread over 2 checks
		foreach ($required_fields as $field) {
			$field_value = elgg_extract($field, $data);
				
			if (empty($field_value)) {
				register_error(elgg_echo('publication:blankdefault'));
				return false;
			}
		}
		
		$book_editors_guids = get_input('book_editors');
		$book_editors_text = get_input('book_editors_text');
		
		if (empty($book_editors_guids) && empty($book_editors_text)) {
			register_error(elgg_echo('publication:blankdefault'));
			return false;
		}
	}
	
	/**
	 * Validate the input for the custom type 'article_journal'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputArticle($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'journaltitle',
			'volume',
		];
		
		foreach ($required_fields as $field) {
			$field_value = elgg_extract($field, $data);
			
			if (empty($field_value)) {
				register_error(elgg_echo('publication:blankdefault'));
				return false;
			}
		}
	}
	
	/**
	 * Save book editors with a publication
	 *
	 * @param string       $event  the name of the event
	 * @param string       $type   the type of the event
	 * @param \Publication $entity supplied entity
	 *
	 * @return void
	 */
	public static function saveArticleBookAuthors($event, $type, $entity) {
		
		if (!($entity instanceof \Publication)) {
			return;
		}
		
		// cleanup book editors
		$entity->deleteRelationships('book_editor');
		
		$type = get_input('type');
		if (!in_array($type, ['inbook', 'book'])) {
			return;
		}
		
		$book_editors_guids = get_input('book_editors');
		$book_editors_order = get_input('book_editors_order');
		
		// save book editors
		if (!empty($book_editors_guids)) {
			foreach ($book_editors_guids as $book_editor) {
				add_entity_relationship($entity->getGUID(), 'book_editor', $book_editor);
			}
		}
		
		$pbook_editors = implode(',', $book_editors_order);
		$entity->book_editors = $pbook_editors;
		
		$entity->save();
		
	}
}
