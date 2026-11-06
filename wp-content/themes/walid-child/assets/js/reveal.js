/**
 * Scroll reveal for Poliklinik Walid.
 * Adds .is-visible to .reveal / .reveal-group elements as they enter the viewport.
 * Respects prefers-reduced-motion (shows everything immediately, no animation).
 */
(function () {
	'use strict';

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var items = document.querySelectorAll('.reveal, .reveal-group');

	if (!items.length) {
		return;
	}

	// No IntersectionObserver or reduced motion: just show everything.
	if (reduce || !('IntersectionObserver' in window)) {
		items.forEach(function (el) {
			el.classList.add('is-visible');
		});
		return;
	}

	var observer = new IntersectionObserver(
		function (entries, obs) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					obs.unobserve(entry.target);
				}
			});
		},
		{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
	);

	items.forEach(function (el) {
		observer.observe(el);
	});
})();

/**
 * Homepage proof stats — count up once when scrolled into view (B·v2).
 * No-op on pages without #walid-statrow. Respects prefers-reduced-motion.
 */
(function () {
	'use strict';

	var row = document.getElementById('walid-statrow');
	if (!row) {
		return;
	}

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var cards = row.querySelectorAll('.statcard');

	function run(card) {
		card.classList.add('filled');
		var b = card.querySelector('b');
		var target = parseFloat(card.getAttribute('data-target'));
		var suffix = card.getAttribute('data-suffix') || '';
		if (isNaN(target)) {
			return;
		}
		var decimals = (target % 1 !== 0) ? 1 : 0;

		if (reduce || !window.requestAnimationFrame) {
			b.innerHTML = target.toFixed(decimals) + suffix;
			return;
		}

		var start = null;
		var dur = 1400;
		function tick(ts) {
			if (!start) {
				start = ts;
			}
			var p = Math.min((ts - start) / dur, 1);
			b.innerHTML = (target * p).toFixed(decimals) + suffix;
			if (p < 1) {
				window.requestAnimationFrame(tick);
			}
		}
		window.requestAnimationFrame(tick);
	}

	if (reduce || !('IntersectionObserver' in window)) {
		cards.forEach(run);
		return;
	}

	var io = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					run(e.target);
					io.unobserve(e.target);
				}
			});
		},
		{ threshold: 0.4 }
	);

	cards.forEach(function (c) {
		io.observe(c);
	});
})();
