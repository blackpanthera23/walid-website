/**
 * Poliklinik Walid, Concept 4.
 *
 * Always on : mobile menu, header hide/show, scroll progress, active nav link, map geometry + pin linking.
 * Motion    : split headlines, sequenced hero, reveals, counters, parallax, tile spotlight, magnet buttons,
 *             marquee. Runs only when html.m-js is present (set in <head> when motion is allowed).
 * If the motion layer throws, html.m-js is removed so no content can stay hidden.
 */
(function () {
	'use strict';

	var root = document.documentElement;
	var motion = root.classList.contains('m-js') && 'IntersectionObserver' in window;

	function $(sel, ctx) { return (ctx || document).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

	/* ------------------------------------------------------------------ menu */
	var toggle = $('#navToggle');
	var nav = $('#nav');
	function setMenu(open) {
		root.classList.toggle('menu-open', open);
		toggle.setAttribute('aria-expanded', String(open));
		toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
	}
	toggle.addEventListener('click', function () { setMenu(!root.classList.contains('menu-open')); });
	nav.addEventListener('click', function (e) { if (e.target.closest('a')) { setMenu(false); } });
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { setMenu(false); } });

	/* ------------------------------------------------------------------ map: branch list <-> pins */
	// Hovering a branch in the list lights up its pin and label, and the other way round.
	function hot(id, on) {
		$$('[data-pin-id="' + id + '"], [data-pin="' + id + '"]').forEach(function (n) { n.classList.toggle('is-hot', on); });
	}
	$$('[data-pin]').forEach(function (li) {
		var id = li.getAttribute('data-pin');
		li.addEventListener('mouseenter', function () { hot(id, true); });
		li.addEventListener('mouseleave', function () { hot(id, false); });
		li.addEventListener('focusin', function () { hot(id, true); });
		li.addEventListener('focusout', function () { hot(id, false); });
	});
	$$('.pin').forEach(function (p) {
		var id = p.getAttribute('data-pin-id');
		p.addEventListener('mouseenter', function () { hot(id, true); });
		p.addEventListener('mouseleave', function () { hot(id, false); });
	});

	/* ------------------------------------------------------------------ scroll: header, progress, active link */
	var header = $('#header');
	var fill = $('.progress i');
	var sections = $$('main section[id]');
	var links = $$('.nav a[href^="#"]');
	var lastY = window.scrollY;
	var ticking = false;
	var parallaxItems = $$('[data-parallax]');
	var counters = $$('[data-count]');
	var counted = new WeakSet();

	function parallax() {
		var vh = window.innerHeight;
		parallaxItems.forEach(function (el) {
			var parent = el.parentElement;
			var r = parent.getBoundingClientRect();
			if (r.bottom < -120 || r.top > vh + 120) { return; }
			var k = parseFloat(el.getAttribute('data-parallax')) || 0.08;
			var slack = Math.max(0, (el.offsetHeight - parent.offsetHeight) / 2);
			var v = -((r.top + r.height / 2) - vh / 2) * k;
			v = Math.max(-slack, Math.min(slack, v));
			el.style.transform = 'translate3d(0,' + v.toFixed(1) + 'px,0)';
		});
	}

	function revealAll() {
		$$('[data-reveal], [data-reveal-group], [data-split], [data-wipe], #map').forEach(function (el) {
			if (!el.classList.contains('in') && !el.hasAttribute('data-hero')) {
				el.classList.add('in');
				if (el.hasAttribute('data-wipe') && el.parentElement) { el.parentElement.classList.add('in'); }
			}
		});
		counters.forEach(runCount);
	}

	function onScroll() {
		ticking = false;
		var y = window.scrollY;
		var max = root.scrollHeight - window.innerHeight;
		fill.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0).toFixed(4) + ')';

		header.classList.toggle('is-stuck', y > 8);
		var dy = y - lastY;
		if (dy > 4 && y > 240 && !root.classList.contains('menu-open')) {
			header.classList.add('is-hidden');
		} else if (dy < -4 || y <= 240) {
			header.classList.remove('is-hidden');
		}
		lastY = y;

		var cur = 'top';
		sections.forEach(function (s) { if (s.getBoundingClientRect().top <= 150) { cur = s.id; } });
		links.forEach(function (a) { a.classList.toggle('is-active', a.getAttribute('href') === '#' + cur); });

		if (motion) {
			parallax();
			// End of page: reveal anything still waiting, so nothing near the bottom can stay hidden.
			if (max - y <= 2) { revealAll(); }
		}
	}
	function requestTick() {
		if (!ticking) { ticking = true; window.requestAnimationFrame(onScroll); }
	}
	window.addEventListener('scroll', requestTick, { passive: true });
	window.addEventListener('resize', requestTick);
	onScroll();

	if (!motion) { return; }

	/* ------------------------------------------------------------------ motion layer */
	function split(el) {
		if (el.children.length) { return; }
		var text = el.textContent.replace(/\s+/g, ' ').trim();
		if (!text) { return; }
		el.setAttribute('aria-label', text);
		el.textContent = '';
		var words = text.split(' ');
		words.forEach(function (word, i) {
			var outer = document.createElement('span');
			outer.className = 'w';
			outer.setAttribute('aria-hidden', 'true');
			var inner = document.createElement('span');
			inner.textContent = word;
			inner.style.setProperty('--wi', i);
			outer.appendChild(inner);
			el.appendChild(outer);
			if (i < words.length - 1) { el.appendChild(document.createTextNode(' ')); }
		});
	}

	function runCount(el) {
		if (counted.has(el)) { return; }
		counted.add(el);
		var target = parseFloat(el.getAttribute('data-count'));
		var dec = parseInt(el.getAttribute('data-decimals') || '0', 10);
		var dur = 1900;
		var t0 = null;
		function tick(ts) {
			if (t0 === null) { t0 = ts; }
			var p = Math.min((ts - t0) / dur, 1);
			var eased = 1 - Math.pow(1 - p, 4);
			el.textContent = (target * eased).toFixed(dec);
			if (p < 1) { window.requestAnimationFrame(tick); }
		}
		window.requestAnimationFrame(tick);
	}

	function initMotion() {
		// Sequencing variables
		$$('[data-hero]').forEach(function (el) { el.style.setProperty('--hd', el.getAttribute('data-hero')); });
		$$('[data-pop]').forEach(function (el) { el.style.setProperty('--pd', el.getAttribute('data-pop')); });
		$$('[data-reveal][data-d]').forEach(function (el) { el.style.setProperty('--rd', (parseFloat(el.getAttribute('data-d')) * 110) + 'ms'); });
		$$('[data-reveal-group]').forEach(function (group) {
			Array.prototype.forEach.call(group.children, function (child, i) { child.style.setProperty('--i', i); });
		});

		// Split headlines into masked words
		$$('[data-split]').forEach(split);

		// Counters start from zero and run when seen
		counters.forEach(function (el) {
			var dec = parseInt(el.getAttribute('data-decimals') || '0', 10);
			el.textContent = (0).toFixed(dec);
		});

		// Reveal on enter
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				var el = entry.target;
				if (el.hasAttribute('data-count')) {
					runCount(el);
				} else {
					el.classList.add('in');
					if (el.hasAttribute('data-wipe') && el.parentElement) { el.parentElement.classList.add('in'); }
				}
				io.unobserve(el);
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
		// Hero items are started explicitly below (deterministic intro), everything else on scroll.
		$$('[data-reveal], [data-reveal-group], [data-split]:not([data-hero]), [data-wipe], #map').forEach(function (el) {
			if (el.closest('.hero')) { return; }
			io.observe(el);
		});

		var ioCount = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { runCount(entry.target); ioCount.unobserve(entry.target); }
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { ioCount.observe(el); });

		// Reviews marquee: duplicate the set for a seamless loop
		var track = $('#marquee');
		if (track) {
			Array.prototype.slice.call(track.children).forEach(function (card) {
				var clone = card.cloneNode(true);
				clone.setAttribute('aria-hidden', 'true');
				track.appendChild(clone);
			});
		}

		// Pointer-follow spotlight on service tiles
		$$('.tile').forEach(function (tile) {
			tile.addEventListener('pointermove', function (e) {
				var r = tile.getBoundingClientRect();
				tile.style.setProperty('--mx', (e.clientX - r.left) + 'px');
				tile.style.setProperty('--my', (e.clientY - r.top) + 'px');
			});
		});

		// Magnetic primary buttons (fine pointers only)
		if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
			$$('[data-magnet]').forEach(function (btn) {
				btn.addEventListener('pointermove', function (e) {
					var r = btn.getBoundingClientRect();
					btn.style.setProperty('--mx', ((e.clientX - r.left - r.width / 2) * 0.2).toFixed(1) + 'px');
					btn.style.setProperty('--my', ((e.clientY - r.top - r.height / 2) * 0.32).toFixed(1) + 'px');
				});
				btn.addEventListener('pointerleave', function () {
					btn.style.setProperty('--mx', '0px');
					btn.style.setProperty('--my', '0px');
				});
			});
		}

		// Go: start the hero sequence, then raise the headline words
		window.requestAnimationFrame(function () {
			root.classList.add('m-ready');
			window.setTimeout(function () {
				$$('[data-split][data-hero]').forEach(function (el) { el.classList.add('in'); });
				$$('.hero [data-wipe]').forEach(function (el) {
					el.classList.add('in');
					if (el.parentElement) { el.parentElement.classList.add('in'); }
				});
			}, 240);
			onScroll();
		});
	}

	try {
		initMotion();
	} catch (err) {
		root.classList.remove('m-js');
		root.classList.add('m-ready');
		if (window.console && console.error) { console.error('[walid v4 motion]', err); }
	}
})();
