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
	 * @covers ::setTitle
	 * @covers ::setContent
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

	/**
	 * @covers ::setTitle
	 * @covers ::getTitle
	 */
	public function testTitle() {
		$notification = new Notification('title', 'content');

		$this->assertSame('title', $notification->getTitle());
	}

	/**
	 * @covers ::setTitle
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Notification title may not exceed 255 characters
	 */
	public function testTitleExcessiveLength() {
		$tooLongTitle = 'This string is very very very very long, much much longer than what is allowed for a Boxcar notifcation title. Actually a string must never be this long if it should be used as a Boxcar notification title as it is just tooooooooooooooooooooooooooooooo long';

		$this->assertSame(256, strlen($tooLongTitle));

		new Notification($tooLongTitle, 'content');
	}

	/**
	 * @covers ::setContent
	 * @covers ::getContent
	 */
	public function testContent() {
		$notification = new Notification('title', 'content');

		$this->assertSame('content', $notification->getContent());
	}

	/**
	 * @covers ::setContent
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Notification content may not exceed 4 kB
	 */
	public function testContentExcessiveLength() {
		$tooLongContent = str_repeat('a', 4097);

		$this->assertSame(4097, strlen($tooLongContent));

		new Notification('title', $tooLongContent);
	}

}

