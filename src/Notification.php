<?php

namespace Zortje\BoxcarNotifications;

/**
 * Class Notification
 *
 * @package Zortje\BoxcarNotifications
 */
class Notification {

	/**
	 * Title of the notification
	 *
	 * @var String Title
	 */
	private $title;

	/**
	 * Content of the notification, cant either be text or HTML
	 *
	 * @var String Content
	 */
	private $content;

	/**
	 * @param String $title   Notification title
	 * @param String $content Notification content
	 *
	 * @throws \InvalidArgumentException If title exceeds max size of 255 characters
	 * @throws \InvalidArgumentException If title exceeds max size of 4 kB
	 */
	public function __construct($title, $content) {
		$this->setTitle($title);
		$this->setContent($content);
	}


	/**
	 * @param String $title
	 *
	 * @throws \InvalidArgumentException If title exceeds max size of 255 characters
	 */
	private function setTitle($title) {
		/**
		 * Notification title has a max size of 255 characters
		 */
		if (strlen($title) > 255) {
			throw new \InvalidArgumentException('Notification title may not exceed 255 characters');
		}

		$this->title = $title;
	}

	/**
	 * @return String
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param String $content
	 *
	 * @throws \InvalidArgumentException If title exceeds max size of 4 kB
	 */
	private function setContent($content) {
		/**
		 * Notification content has a max size of 4 kB
		 */
		if (strlen($content) > 4096) {
			throw new \InvalidArgumentException('Notification content may not exceed 4 kB');
		}

		$this->content = $content;
	}

	/**
	 * @return String
	 */
	public function getContent() {
		return $this->content;
	}

}
