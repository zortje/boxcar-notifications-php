<?php

namespace Zortje\BoxcarNotifications\Tests;

use Zortje\BoxcarNotifications\Boxcar;
use Zortje\BoxcarNotifications\Notification;

/**
 * Class BoxcarTest
 *
 * @package            Zortje\BoxcarNotifications\Tests
 *
 * @coversDefaultClass Zortje\BoxcarNotifications\Boxcar
 */
class BoxcarTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $boxcar = new Boxcar('secrets');

        $reflector = new \ReflectionClass($boxcar);

        $accessToken = $reflector->getProperty('accessToken');
        $accessToken->setAccessible(true);
        $this->assertSame('secrets', $accessToken->getValue($boxcar));
    }

    /**
     * @covers ::setSourceName
     * @covers ::getSourceName
     */
    public function testSourceName()
    {
        $boxcar = new Boxcar('secrets');

        $boxcar->setSourceName('ACME');
        $this->assertSame('ACME', $boxcar->getSourceName());
    }

    /**
     * @covers ::setIconUrl
     * @covers ::getIconUrl
     */
    public function testIconUrl()
    {
        $boxcar = new Boxcar('secrets');

        $boxcar->setIconUrl('http://new.boxcar.io/images/rss_icons/boxcar-64.png');
        $this->assertSame('http://new.boxcar.io/images/rss_icons/boxcar-64.png', $boxcar->getIconUrl());
    }

    /**
     * @covers ::setSound
     * @covers ::getSound
     */
    public function testSound()
    {
        $boxcar = new Boxcar('secrets');

        $boxcar->setSound('notifier-1');
        $this->assertSame('notifier-1', $boxcar->getSound());
    }

    /**
     * @covers ::setSound
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Sound 'foo' is not supported
     */
    public function testUnsupportedSound()
    {
        $boxcar = new Boxcar('secrets');

        $boxcar->setSound('foo');
    }

    /**
     * @covers ::setOpenUrl
     * @covers ::getOpenUrl
     */
    public function testOpenUrl()
    {
        $boxcar = new Boxcar('secrets');

        $boxcar->setOpenUrl('http://maps.google.com/maps?q=cupertino');
        $this->assertSame('http://maps.google.com/maps?q=cupertino', $boxcar->getOpenUrl());
    }

    public function testCreatePostFields()
    {
        $boxcar       = new Boxcar('secrets');
        $notification = new Notification('title', 'content');

        $reflector = new \ReflectionClass($boxcar);

        $method = $reflector->getMethod('createPostFields');
        $method->setAccessible(true);

        /**
         * Required
         */
        $required = [
            'user_credentials'           => 'secrets',
            'notification[title]'        => 'title',
            'notification[long_message]' => 'content'
        ];

        $this->assertSame($required, $method->invoke($boxcar, $notification));

        /**
         * Optionals
         */
        $boxcar->setSourceName('ACME');
        $boxcar->setIconUrl('http://new.boxcar.io/images/rss_icons/boxcar-64.png');
        $boxcar->setSound('notifier-1');
        $boxcar->setOpenUrl('http://maps.google.com/maps?q=cupertino');

        $optionals = [
            'user_credentials'           => 'secrets',
            'notification[title]'        => 'title',
            'notification[long_message]' => 'content',
            'notification[source_name]'  => 'ACME',
            'notification[icon_url]'     => 'http://new.boxcar.io/images/rss_icons/boxcar-64.png',
            'notification[sound]'        => 'notifier-1',
            'notification[open_url]'     => 'http://maps.google.com/maps?q=cupertino'
        ];

        $this->assertSame($optionals, $method->invoke($boxcar, $notification));
    }
}
