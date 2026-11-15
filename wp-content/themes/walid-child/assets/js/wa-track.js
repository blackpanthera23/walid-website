/**
 * WhatsApp click tracking (first-party, no cookies, no personal data).
 * Records: which line (general / minor surgery), where the button sits, and which page path.
 * Also pushes a `walid_wa_click` event to dataLayer / gtag if either is present.
 */
(function () {
	'use strict';

	var cfg = window.walidWaTrack;
	if (!cfg || !cfg.ajaxUrl || navigator.webdriver) {
		return;
	}

	function lineFor(href) {
		if (href.indexOf('wa.me/' + cfg.minorSurgery) !== -1) {
			return 'minor_surgery';
		}
		if (href.indexOf('wa.me/' + cfg.general) !== -1) {
			return 'general';
		}
		return '';
	}

	function placementFor(el) {
		var tagged = el.closest('[data-wa-placement]');
		if (tagged) {
			return tagged.getAttribute('data-wa-placement');
		}
		if (el.closest('.walid-fab')) {
			return 'fab';
		}
		if (el.closest('footer')) {
			return 'footer';
		}
		if (el.closest('header')) {
			return 'header';
		}
		return 'content';
	}

	document.addEventListener(
		'click',
		function (e) {
			var a = e.target.closest ? e.target.closest('a[href*="wa.me/"]') : null;
			if (!a) {
				return;
			}
			var line = lineFor(a.getAttribute('href') || '');
			if (!line) {
				return;
			}
			var data = {
				line: line,
				placement: placementFor(a),
				page: (location.pathname || '/').slice(0, 100)
			};

			if (window.dataLayer && window.dataLayer.push) {
				window.dataLayer.push({ event: 'walid_wa_click', wa_line: data.line, wa_placement: data.placement, wa_page: data.page });
			}
			if (typeof window.gtag === 'function') {
				window.gtag('event', 'walid_wa_click', { wa_line: data.line, wa_placement: data.placement, wa_page: data.page });
			}

			var body = new URLSearchParams({ action: 'walid_wa_click', line: data.line, placement: data.placement, page: data.page });
			if (navigator.sendBeacon) {
				navigator.sendBeacon(cfg.ajaxUrl, body);
			} else if (window.fetch) {
				fetch(cfg.ajaxUrl, { method: 'POST', body: body, keepalive: true, credentials: 'omit' });
			}
		},
		true
	);
})();
