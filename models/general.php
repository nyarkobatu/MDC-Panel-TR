<?php

class General {

	public function getSettings($setting) {
		
		switch ($setting) {
			case 'site-live':					return SITE_LIVE;
			case 'site-name':					return SITE_NAME;
			case 'site-version':				return SITE_VERSION;
			case 'site-url':					return $_SERVER['SERVER_NAME'];
			case 'site-logo':					return SITE_LOGO;
			case 'site-favicon':				return SITE_FAVICON;
			case 'site-image':					return SITE_IMAGE;
			case 'site-description':			return SITE_DESCRIPTION;
			case 'site-discord-contact':		return SITE_DISCORD_CONTACT;
			case 'url-github':					return URL_GITHUB;
			case 'url-discord':					return URL_DISCORD;
			case 'url-mdc':						return URL_MDC;
			case 'url-cad':						return URL_CAD;
			case 'url-lspd':					return URL_LSPD;
			case 'url-lssd':					return URL_LSSD;
			case 'url-lsfd':					return URL_LSFD;
			case 'url-lsda':					return URL_LSDA;
			case 'url-sadcr':					return URL_SADCR;
			case 'url-sfm':						return URL_SFM;
			case 'url-sasp':					return URL_SASP;
			case 'url-penal-code':				return URL_PENAL_CODE;
			case 'url-bail-schedule':			return URL_BAIL_SCHEDULE;
			case 'url-bbcoderip':				return URL_BBCODERIP;
			case 'url-st3fan':					return URL_ST3FAN;
			case 'special-notification': 		return SPECIAL_NOTIFICATION_COOKIE;
			case 'special-notification-msg':	return SPECIAL_NOTIFICATION_MESSAGE;
			default: break;
		}
	}

	public function getUNIX($format) {

		date_default_timezone_set('GMT');
		$unix = time();

		switch($format) {
			case 'year':
				return date('Y', $unix);
			case 'date':
				return date('d/M/Y', $unix);
			case 'time':
				return date('H:i', $unix);
			default:
				return $unix;
		}

	}

	public function clearCookies() {

		$cookieToggles = array('toggleMode', 'toggleClock', 'toggleBreadcrumb', 'toggleBackgroundLogo', 'toggleHints', 'toggleFooter', 'toggleLiveVisitorCounter', 'notificationVersion', 'specialNotification');
		$cookieUserDetails = array('officerName', 'officerRank', 'officerBadge', 'callSign', 'defName', 'inputTDPatrolReportURL');

		$cookiesAll = array_merge($cookieToggles, $cookieUserDetails);

		foreach ($cookiesAll as $cookie) {
			unset($_COOKIE[$cookie]);
		}

		foreach ($cookieToggles as $cookie) {
			setcookie($cookie, false, -1, '/', $this->getSettings('site-url'), $this->getSettings('site-live'));
		}

		foreach ($cookieUserDetails as $cookie) {
			setcookie($cookie, null, -1, '/', $this->getSettings('site-url'), $this->getSettings('site-live'));
		}

	}

	public function findCookie($cookie) {

		switch ($cookie) {
			case 'notificationVersion':			return $_COOKIE['notificationVersion'] ?? false;
			case 'toggleMode':					return $_COOKIE['toggleMode'] ?? false;
			case 'toggleClock':					return $_COOKIE['toggleClock'] ?? false;
			case 'toggleBreadcrumb':			return $_COOKIE['toggleBreadcrumb'] ?? false;
			case 'toggleBackgroundLogo':		return $_COOKIE['toggleBackgroundLogo'] ?? false;
			case 'toggleHints':					return $_COOKIE['toggleHints'] ?? false;
			case 'toggleFooter':				return $_COOKIE['toggleFooter'] ?? false;
			case 'toggleLiveVisitorCounter':	return $_COOKIE['toggleLiveVisitorCounter'] ?? false;
			case 'officerName':					return $_COOKIE['officerName'] ?? '';
			case 'officerRank':					return $_COOKIE['officerRank'] ?? '';
			case 'officerBadge':				return $_COOKIE['officerBadge'] ?? '';
			case 'legalName':					return $_COOKIE['legalName'] ?? '';
			case 'legalRank':					return $_COOKIE['legalRank'] ?? '';
			case 'legalBadge':					return $_COOKIE['legalBadge'] ?? '';
			case 'callSign':					return $_COOKIE['callSign'] ?? '';
			case 'defName':						return $_COOKIE['defName'] ?? '';
			case 'defNameURL':					return str_replace(' ', '_', $_COOKIE['defName'] ?? '');
			case 'inputTDPatrolReportURL':		return $_COOKIE['inputTDPatrolReportURL'] ?? 'https://lspd.gta.world/viewforum.php?f=101';
			case 'specialNotification':         return $_COOKIE['specialNotification'] ?? false;
			case 'openStatus':         			return $_COOKIE['openStatus'] ?? 1;
			case 'openBailStatus': 				return $_COOKIE['openBailStatus'] ?? 1;
			default: break;
		}
	}

}
