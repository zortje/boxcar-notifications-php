<?php

namespace Zortje\BoxcarNotifications\Tests;

use Zortje\BoxcarNotifications\Boxcar;

/**
 * Class BoxcarTest
 *
 * @package            Zortje\BoxcarNotifications\Tests
 *
 * @coversDefaultClass Zortje\BoxcarNotifications\Boxcar
 */
class BoxcarTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers ::__construct
	 */
	public function testConstruct() {
		$boxcar = new Boxcar('secrets');

		$reflector = new \ReflectionClass($boxcar);

		$accessToken = $reflector->getProperty('accessToken');
		$accessToken->setAccessible(true);
		$this->assertSame('secrets', $accessToken->getValue($boxcar));
	}

}
