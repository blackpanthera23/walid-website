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
