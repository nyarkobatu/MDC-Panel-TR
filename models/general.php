<?php

class General {

	public function getSettings($setting) {
		
		switch ($setting) {
			case 'site-live':					return true;
			case 'site-name':					return 'MDC Panel';
			case 'site-version':				return '2.4.4';
			case 'site-url':					return $_SERVER['SERVER_NAME'];
			case 'site-logo':					return '/images/MDC-Panel.svg';
			case 'site-favicon':				return '/images/MDC-Panel-Favicon.svg';
			case 'site-image':					return '/images/MDC-Panel-OG.png';
			case 'site-description':			return 'MDC Panel - Multi-functional tools, generators, and resources for official government use.';
			case 'site-discord-contact':		return 'Biscuit#0001';
			case 'url-github':					return 'https://github.com/biscuitgtaw/MDC-Panel';
			case 'url-discord':					return 'https://discord.gg/rxfYd23TNz';
			case 'url-mdc':						return 'https://mdc.gta.world';
			case 'url-cad':						return 'https://cad.gta.world';
			case 'url-lspd':					return 'https://lspd.gta.world';
			case 'url-lssd':					return 'https://lssd.gta.world';
			case 'url-lsfd':					return 'https://lsfd.gta.world';
			case 'url-lsda':					return 'https://lsda.gta.world';
			case 'url-sadoc':					return 'https://sadcr.gta.world';
			case 'url-sanfire':					return 'https://sfm.gta.world';
			case 'url-sasp':					return 'https://saparks.gta.world';
			case 'url-penal-code':				return 'https://forum.gta.world/en/topic/78852-san-andreas-penal-code/';
			case 'url-bail-schedule':			return 'https://docs.google.com/spreadsheets/d/1qm04NZm-HEy-vdW2liNWcdok7eXFGty_rO-dA1H_k0g/';
			case 'url-bbcoderip':				return 'https://booskit-bbcode.netlify.app/';
			case 'url-st3fan':					return 'https://st3fannl.nl/gtaw/';
			case 'special-notification': 		return 'bail-schedule-outdated-09132023';
			case 'special-notification-msg':	return 'Bail schedule is outdated! I wasn\'t given a headsup :c - It\'ll take some time for me to update it.';
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
			default: break;
		}
	}

}
