/**
 * Professional motion layer for Poliklinik Walid.
 *
 * Works with assets/css/motion.css. Tags elements at runtime (no template edits needed):
 *   - hero text column: word-split headline + sequenced rise      -> [data-hero-item], .m-word
 *   - headings, eyebrows, closing CTAs: scroll reveal variants     -> [data-m] (+ .m-in when seen)
 *   - .reveal-group children: stagger index                        -> --i
 *   - scroll progress bar, header depth                            -> .m-progress, html.m-scrolled
 *
 * Does nothing when the user prefers reduced motion (the head script never adds html.m-js then).
 * If anything throws, html.m-js is removed so no content can stay hidden.
 */
(function () {
	'use strict';

	var root = document.documentElement;

	// Bail out when motion is off or the head flag was not set (reduced motion, or failsafe fired).
	if (!root.classList.contains('m-js') || !('IntersectionObserver' in window)) {
		return;
	}

	function each(list, fn) {
		Array.prototype.forEach.call(list, fn);
	}

	function init() {
		var main = document.querySelector('main') || document.body;

		/* 1. Scroll progress + header depth ------------------------------------ */
		var bar = document.createElement('div');
		bar.className = 'm-progress';
		bar.setAttribute('aria-hidden', 'true');
		var fill = document.createElement('i');
		bar.appendChild(fill);
		document.body.appendChild(bar);

		var ticking = false;
		function update() {
			ticking = false;
			var max = root.scrollHeight - window.innerHeight;
			var p = max > 0 ? Math.min(window.scrollY / max, 1) : 0;
			fill.style.transform = 'scaleX(' + p + ')';
			root.classList.toggle('m-scrolled', window.scrollY > 8);
			// End of page (or a page too short to scroll): reveal anything still waiting, so blocks
			// sitting in the last strip of the viewport can never stay hidden.
			if (max - window.scrollY <= 2) {
				each(document.querySelectorAll('[data-m]:not(.m-in)'), function (el) {
					el.classList.add('m-in');
				});
			}
		}
		window.addEventListener('scroll', function () {
			if (!ticking) {
				ticking = true;
				window.requestAnimationFrame(update);
			}
		}, { passive: true });
		window.addEventListener('resize', update);
		update();

		/* 2. Hero choreography ------------------------------------------------- */
		function splitWords(h) {
			if (h.children.length) {
				return; // contains markup already; leave untouched.
			}
			var text = h.textContent.replace(/\s+/g, ' ').trim();
			if (!text) {
				return;
			}
			h.setAttribute('aria-label', text);
			h.textContent = '';
			var words = text.split(' ');
			words.forEach(function (word, i) {
				var outer = document.createElement('span');
				outer.className = 'm-word';
				outer.setAttribute('aria-hidden', 'true');
				var inner = document.createElement('span');
				inner.textContent = word;
				inner.style.setProperty('--wi', i);
				outer.appendChild(inner);
				h.appendChild(outer);
				if (i < words.length - 1) {
					h.appendChild(document.createTextNode(' '));
				}
			});
		}

		each(document.querySelectorAll(
			'.walid-home .hero .hero-grid > div:first-child, .walid-single .service-hero-inner, .walid-procedure .proc-hero-grid > div:first-child'
		), function (col) {
			var n = 0;
			each(col.children, function (child) {
				child.setAttribute('data-hero-item', '');
				child.style.setProperty('--hi', n++);
				if (child.tagName === 'H1') {
					splitWords(child);
				}
			});
		});

		/* 3. Stagger index for card groups ------------------------------------ */
		each(document.querySelectorAll('.reveal-group'), function (group) {
			each(group.children, function (child, i) {
				child.style.setProperty('--i', i);
			});
		});

		/* 4. Scroll-reveal tagging --------------------------------------------- */
		function tag(el, variant, delay) {
			if (!el || el.hasAttribute('data-m')) {
				return;
			}
			el.setAttribute('data-m', variant);
			if (delay) {
				el.style.setProperty('--m-d', delay + 'ms');
			}
		}
		// Skip anything already animated by another system (hero, .reveal, .reveal-group, tagged parents).
		function covered(el) {
			var p = el.parentElement;
			return !!(p && p.closest('.reveal, .reveal-group, [data-m], [data-hero-item], .hero, .service-hero, .proc-hero'));
		}

		// Closing blocks first, so their children get an ordered stagger.
		each(main.querySelectorAll('.final .container, .intl .container, .proc-cta .container'), function (box) {
			each(box.children, function (child, i) {
				tag(child, child.classList.contains('flags') ? 'scale' : 'up', i * 110);
			});
		});

		each(main.querySelectorAll('.eyebrow, h2'), function (el) {
			if (!covered(el)) {
				tag(el, 'up', el.tagName === 'H2' ? 90 : 0);
			}
		});

		each(main.querySelectorAll('.pillar-hero > div:first-child'), function (el) {
			tag(el, 'left');
		});
		each(main.querySelectorAll('.walid-single .entry'), function (el) {
			if (!covered(el)) {
				tag(el, 'up');
			}
		});

		/* 5. Reveal on enter ----------------------------------------------------- */
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('m-in');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
		each(document.querySelectorAll('[data-m]'), function (el) {
			io.observe(el);
		});

		/* 6. Go. Flipping m-ready starts the hero sequence. -------------------- */
		window.requestAnimationFrame(function () {
			root.classList.add('m-ready');
			update(); // handles pages that cannot scroll.
		});
	}

	try {
		init();
	} catch (err) {
		// Never leave content hidden because of a script error.
		root.classList.remove('m-js');
		root.classList.add('m-ready');
		if (window.console && console.error) {
			console.error('[walid motion]', err);
		}
	}
})();
