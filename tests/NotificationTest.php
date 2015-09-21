<?php

namespace Zortje\BoxcarNotifications\Tests;

use Zortje\BoxcarNotifications\Notification;

/**
 * Class NotificationTest
 *
 * @package            Zortje\BoxcarNotifications\Tests
 *
 * @coversDefaultClass Zortje\BoxcarNotifications\Notification
 */
class NotificationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers ::__construct
	 */
	public function testConstruct() {
		$notification = new Notification('title', 'content');

		$reflector = new \ReflectionClass($notification);

		$title = $reflector->getProperty('title');
		$title->setAccessible(true);
		$this->assertSame('title', $title->getValue($notification));

		$content = $reflector->getProperty('content');
		$content->setAccessible(true);
		$this->assertSame('content', $content->getValue($notification));
	}

}
