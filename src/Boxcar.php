<?php

namespace Zortje\BoxcarNotifications;

use Zortje\BoxcarNotifications\Exception\InvalidAccessTokenException;
use Zortje\BoxcarNotifications\Exception\NoDeviceAssociatedException;

/**
 * Class Boxcar
 *
 * @package Zortje\BoxcarNotifications
 */
class Boxcar {

	const USER_AGENT = 'ZortjeBoxcarNotificationsPHP/1.0';

	const ENDPOINT = 'https://new.boxcar.io/api/notifications';

	/**
	 * @var String Access token
	 */
	private $accessToken;

	/**
	 * @var String Sound
	 */
	private $sound;

	/**
	 * @var String Source name
	 */
	private $sourceName;

	/**
	 * @var String Icon URL
	 */
	private $iconUrl;

	/**
	 * @var String Open URL
	 */
	private $openUrl;

	/**
	 * Your access token can be found in Boxcar global setting pane.
	 *
	 * @param String $accessToken Access token
	 */
	public function __construct($accessToken) {
		$this->accessToken = $accessToken;
	}

	/**
	 * This is a short source name to show in inbox. Default is "Custom notification" if omitted.
	 *
	 * @param String $sourceName Source name
	 */
	public function setSourceName($sourceName) {
		$this->sourceName = $sourceName;
	}

	/**
	 * This is a short source name to show in inbox. Default is "Custom notification" if omitted.
	 *
	 * @return String Source name
	 */
	public function getSourceName() {
		return $this->sourceName;
	}

	/**
	 * This is where you define the icon you want to be displayed within the application inbox﻿.
	 *
	 * @param String $iconUrl
	 */
	public function setIconUrl($iconUrl) {
		$this->iconUrl = $iconUrl;
	}

	/**
	 * This is where you define the icon you want to be displayed within the application inbox﻿.
	 *
	 * @return String
	 */
	public function getIconUrl() {
		return $this->iconUrl;
	}

	/**
	 * As a default, the general sound is used, if you omit this parameter.<br />
	 * General sound typically default to silent, but if you changed it, you can force the notification to be silent with the "no-sound" sound name.<br />
	 * <br />
	 * **Supported sounds**
	 * - beep-crisp
	 * - beep-soft
	 * - bell-modern
	 * - bell-one-tone
	 * - bell-simple
	 * - bell-triple
	 * - bird-1
	 * - bird-2
	 * - boing
	 * - cash
	 * - clanging
	 * - detonator-charge
	 * - digital-alarm
	 * - done
	 * - echo
	 * - flourish
	 * - harp
	 * - light
	 * - magic-chime
	 * - magic-coin
	 * - notifier-1
	 * - notifier-2
	 * - notifier-3
	 * - orchestral-long
	 * - orchestral-short
	 * - score
	 * - success
	 * - up
	 *
	 * @param String $sound
	 *
	 * @throws \InvalidArgumentException If setting sound not supported
	 */
	public function setSound($sound) {
		/**
		 * White list of supported sounds
		 */
		$sounds = array_fill_keys([
			'beep-crisp',
			'beep-soft',
			'bell-modern',
			'bell-one-tone',
			'bell-simple',
			'bell-triple',
			'bird-1',
			'bird-2',
			'boing',
			'cash',
			'clanging',
			'detonator-charge',
			'digital-alarm',
			'done',
			'echo',
			'flourish',
			'harp',
			'light',
			'magic-chime',
			'magic-coin',
			'notifier-1',
			'notifier-2',
			'notifier-3',
			'orchestral-long',
			'orchestral-short',
			'score',
			'success',
			'up',
		], true);

		if (!isset($sounds[$sound])) {
			throw new \InvalidArgumentException("Sound '$sound' is not supported");
		}

		$this->sound = $sound;
	}

	/**
	 * As a default, the general sound is used, if you omit this parameter.<br />
	 * General sound typically default to silent, but if you changed it, you can force the notification to be silent with the "no-sound" sound name.
	 *
	 * @return String
	 */
	public function getSound() {
		return $this->sound;
	}

	/**
	 * If defined, Boxcar will redirect you to this url when you open the notification from the Notification Center.<br />
	 * It can be a http link like http://maps.google.com/maps?q=cupertino or an inapp link like twitter:///user?screen_name=vutheara﻿﻿
	 *
	 * @param String $openUrl
	 */
	public function setOpenUrl($openUrl) {
		$this->openUrl = $openUrl;
	}

	/**
	 * If defined, Boxcar will redirect you to this url when you open the notification from the Notification Center.<br />
	 * It can be a http link like http://maps.google.com/maps?q=cupertino or an inapp link like twitter:///user?screen_name=vutheara﻿﻿
	 *
	 * @return String
	 */
	public function getOpenUrl() {
		return $this->openUrl;
	}

	/**
	 * Push notification to Boxcar
	 *
	 * @param Notification $notification
	 *
	 * @return bool
	 *
	 * @throws InvalidAccessTokenException
	 * @throws NoDeviceAssociatedException
	 */
	public function push(Notification $notification) {
		/**
		 * Prepare data
		 */
		$data = [
			'user_credentials'           => $this->accessToken,
			'notification[title]'        => $notification->getTitle(),
			'notification[long_message]' => $notification->getContent()
		];

		if (!empty($this->getSourceName())) {
			$data['notification[source_name]'] = $this->getSourceName();
		}

		if (!empty($this->getIconUrl())) {
			$data['notification[icon_url]'] = $this->getIconUrl();
		}

		if (!empty($this->getSound())) {
			$data['notification[sound]'] = $this->getSound();
		}

		if (!empty($this->getOpenUrl())) {
			$data['notification[open_url]'] = $this->getOpenUrl();
		}

		/**
		 * Init curl, execute and close
		 */
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, self::ENDPOINT);
		curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);

		/**
		 * Handle result
		 */
		switch ($info['http_code']) {
			case 201:
				return true;

			case 401:
				throw new InvalidAccessTokenException('Not Authorized: Access token not recognized');

			case 404:
				throw new NoDeviceAssociatedException('Not Found: No device associated with provided access token');
		}

		return false;
	}
}
