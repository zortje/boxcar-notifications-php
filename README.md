# Boxcar Notifications API PHP wrapper
A Boxcar API wrapper for sending notifications to a Boxcar account without any dependencies except the cURL library.

[![Packagist](https://img.shields.io/packagist/v/zortje/boxcar-notifications-php.svg?style=flat)](https://packagist.org/packages/zortje/boxcar-notifications-php)
[![Travis](https://img.shields.io/travis/zortje/boxcar-notifications-php.svg?style=flat)](https://travis-ci.org/zortje/boxcar-notifications-php)
[![Code Coverage](https://scrutinizer-ci.com/g/zortje/boxcar-notifications-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zortje/boxcar-notifications-php/?branch=master)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/zortje/boxcar-notifications-php.svg?style=flat)](https://scrutinizer-ci.com/g/zortje/boxcar-notifications-php/?branch=master)
[![Dependency Status](https://dependencyci.com/github/zortje/boxcar-notifications-php/badge)](https://dependencyci.com/github/zortje/boxcar-notifications-php)
[![Packagist](https://img.shields.io/packagist/dt/zortje/boxcar-notifications-php.svg?style=flat)](https://packagist.org/packages/zortje/boxcar-notifications-php)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5624821a-29c9-47d3-884d-750482ebd965/big.png)](https://insight.sensiolabs.com/projects/5624821a-29c9-47d3-884d-750482ebd965)

## Installing

The recommended way to install is though [Composer](https://getcomposer.org/).

```JSON
{
    "require": {
        "zortje/boxcar-notifications-php": "~1.0"
    }
}
```

## Usage

```PHP
$boxcar = new \Zortje\BoxcarNotifications\Boxcar('secret_access_token');

$boxcar->setSourceName('ACME');
$boxcar->setSound('notifier-1');
$boxcar->setIconUrl('http://new.boxcar.io/images/rss_icons/boxcar-64.png');
$boxcar->setOpenUrl('http://maps.google.com/maps?q=cupertino');

$notification = new \Zortje\BoxcarNotifications\Notification('Message title', '<b>Bold</b> content text.');

$boxcar->push($notification);
```

**Access token**

`'secret_access_token'` in the above example. Your access token can be found in Boxcar global setting pane (Not the registered Boxcar email address).

**Title**

`'Message title'` in the above example. Title for the notification. Max size is 255 chars.

**Content**

`'<b>Bold</b> content text.'` in the above example. Content of the notification. Can be text or HTML. Max size is 4 Kb.

**Source name**

`'ACME'` in the above example. This is a short source name to show in inbox. Defaults to "Custom notification" if omitted.

**Sound**

`'notifier-1'` in the above example. General sound is used if omitted. Please find list of supported sounds below.

**Icon URL**

`'http://new.boxcar.io/images/rss_icons/boxcar-64.png'` in the above example. Icon to be displayed in the Boxcar inbox.

**open URL**

`'http://maps.google.com/maps?q=cupertino'` in the above example. If defined, Boxcar will redirect the receiver to this url when he/she opens the notification from the Notification Center.

#### Supported sounds

The following sounds can be used.

* beep-crisp
* beep-soft
* bell-modern
* bell-one-tone
* bell-simple
* bell-triple
* bird-1
* bird-2
* boing
* cash
* clanging
* detonator-charge
* digital-alarm
* done
* echo
* flourish
* harp
* light
* magic-chime
* magic-coin
* notifier-1
* notifier-2
* notifier-3
* orchestral-long
* orchestral-short
* score
* success
* up

## Acknowledgement

Built by following the API specs provided in this Boxcar help [article](http://help.boxcar.io/support/solutions/articles/6000004813-how-to-send-a-notification-to-boxcar-for-ios-users).

## Disclaimer

I am not affiliated with Boxcar in any way.
