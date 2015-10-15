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
	public static function registerTypeBibTex($hook, $type, $return_value, $params) {
		
		$return_value[] = 'article';
		$return_value[] = 'book';
		$return_value[] = 'booklet';
		$return_value[] = 'inbook';
		$return_value[] = 'incollection';
		$return_value[] = 'inproceedings';
		$return_value[] = 'manual';
		$return_value[] = 'mastersthesis';
		$return_value[] = 'phdthesis';
		$return_value[] = 'proceedings';
		$return_value[] = 'techreport';
		$return_value[] = 'unpublished';
		
		return $return_value;
	}
	
	/**
	 * Validate the input for the custom type 'article'
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
			'year',
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
			'year',
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
	 * Validate the input for the custom type 'inbook'
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
			'year',
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
	 * Validate the input for the custom type 'incollection'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputInCollection($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'booktitle',
			'publisher',
			'year',
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
	 * Validate the input for the custom type 'inproceedings'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputInProceedings($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'booktitle',
			'year',
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
	 * Validate the input for the custom type 'mastersthesis'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputMastersThesis($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'school',
			'year',
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
	 * Validate the input for the custom type 'phdthesis'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputPhdThesis($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'school',
			'year',
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
	 * Validate the input for the custom type 'proceedings'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputProceedings($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'year',
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
	 * Validate the input for the custom type 'techreport'
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateInputTechreport($hook, $type, $return_value, $params) {
		
		$data = (array) get_input('data', []);
		
		$required_fields = [
			'institution',
			'year',
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
	 * Validate the presence of authors for certain types
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function validateRequiredAuthors($hook, $type, $return_value, $params) {
		
		if (stristr($type, 'input_validation:') === false) {
			return;
		}
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$required_types = [
			'article',
			'book',
			'inbook',
			'incollection',
			'inproceedings',
			'mastersthesis',
			'phdthesis',
			'techreport',
			'unpublished',
		];
		
		$pubtype = elgg_extract('type', $params);
		if (!in_array($pubtype, $required_types)) {
			return;
		}
		
		$author_guids = get_input('authors');
		$authors_text = get_input('authors_text');
		
		if (empty($author_guids) && empty($authors_text)) {
			register_error(elgg_echo('publication:blankdefault'));
			return false;
		}
	}
	
	/**
	 * Save authors with a publication
	 *
	 * @param string       $event  the name of the event
	 * @param string       $type   the type of the event
	 * @param \Publication $entity supplied entity
	 *
	 * @return void
	 */
	public static function saveArticleAuthors($event, $type, $entity) {
		
		if (!($entity instanceof \Publication)) {
			return;
		}
		
		// cleanup authors
		$entity->deleteRelationships('author');
		unset($entity->authors);
		
		$supported_types = [
			'article',
			'book',
			'booklet',
			'inbook',
			'incollection',
			'inproceedings',
			'manual',
			'mastersthesis',
			'phdthesis',
			'proceedings',
			'techreport',
			'unpublished',
		];
		
		$type = get_input('type');
		if (!in_array($type, $supported_types)) {
			// not in supported type, so don't save new data
			return;
		}
		
		$author_guids = get_input('authors');
		$authors_order = get_input('authors_order');
		
		// save authors
		if (!empty($author_guids)) {
			foreach ($author_guids as $author) {
				add_entity_relationship($entity->getGUID(), 'author', $author);
			}
		}
		
		$pauthors = implode(',', $authors_order);
		$entity->authors = $pauthors;
		
		$entity->save();
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
		unset($entity->book_editors);
		
		$supported_types = [
			'book',
			'inbook',
			'incollection',
			'inproceedings',
		];
		
		$type = get_input('type');
		if (!in_array($type, $supported_types)) {
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
