<?php

namespace ColdTrick\Publications;

class Notifications {
	
	/**
	 * Change the notification contents
	 *
	 * @param string                           $hook         the name of the hook
	 * @param string                           $type         the type of the hook
	 * @param \Elgg\Notifications\Notification $return_value current return value
	 * @param array                            $params       supplied params
	 *
	 * @return void|\Elgg\Notifications\Notification
	 */
	public static function createPublication($hook, $type, $return_value, $params) {
	
		if (empty($params) || !is_array($params)) {
			return;
		}
	
		$event = elgg_extract('event', $params);
		if (!($event instanceof \Elgg\Notifications\Event)) {
			return;
		}
	
		$entity = $event->getObject();
		$actor = $event->getActor();
		$language = elgg_extract('language', $params);
	
		$return_value->subject = elgg_echo('publication:notification:create:subject', [$entity->title], $language);
		$return_value->summary = elgg_echo('publication:notification:create:summary', [$entity->title], $language);
		$return_value->body = elgg_echo('publication:notification:create:body', [
			$actor->name,
			$entity->title,
			$entity->getURL(),
		], $language);
	
		return $return_value;
	}
}