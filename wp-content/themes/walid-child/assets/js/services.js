/**
 * Premium "show more" toggle for service procedure lists.
 * Smoothly reveals the extra procedures, swaps the label, and manages aria-expanded.
 * Respects prefers-reduced-motion (no height animation, just show/hide).
 */
(function () {
	'use strict';

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var toggles = document.querySelectorAll('.proc-toggle');

	toggles.forEach(function (btn) {
		var extra = btn.parentNode.querySelector('.proc-extra');
		if (!extra) {
			return;
		}

		btn.addEventListener('click', function () {
			var expanded = btn.getAttribute('aria-expanded') === 'true';
			var label = btn.querySelector('.proc-toggle-label');

			if (expanded) {
				if (!reduce) {
					extra.style.maxHeight = extra.scrollHeight + 'px';
					requestAnimationFrame(function () { extra.style.maxHeight = '0px'; });
					extra.addEventListener('transitionend', function te() {
						extra.hidden = true;
						extra.style.maxHeight = '';
						extra.removeEventListener('transitionend', te);
					});
				} else {
					extra.hidden = true;
				}
				btn.setAttribute('aria-expanded', 'false');
				if (label) { label.textContent = btn.getAttribute('data-more'); }
			} else {
				extra.hidden = false;
				if (!reduce) {
					extra.style.maxHeight = '0px';
					requestAnimationFrame(function () { extra.style.maxHeight = extra.scrollHeight + 'px'; });
					extra.addEventListener('transitionend', function te() {
						extra.style.maxHeight = 'none';
						extra.removeEventListener('transitionend', te);
					});
				}
				btn.setAttribute('aria-expanded', 'true');
				if (label) { label.textContent = btn.getAttribute('data-less'); }
			}
		});
	});
})();
