/**
 * Poliklinik Walid homepage motion (Concept 4). Front page only.
 *
 * Pairs with assets/css/home.css. Runs only when html.m-js is present, which walid_motion_flag() sets in <head>
 * when the visitor allows motion. Features: sequenced hero, masked word reveals, scroll reveals, count-up numbers,
 * image wipes + parallax, tile spotlight, magnetic buttons, reviews marquee, map pin linking, scroll progress.
 * If anything throws, html.m-js is removed so no content can stay hidden.
 */
(function () {
	'use strict';

	var root = document.documentElement;
	var page = document.querySelector('.walid-home');
	if (!page) {
		return;
	}

	function $(sel, ctx) { return (ctx || document).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

	/* ---- Map: hovering a branch lights its pin, and the other way round (works with or without motion) ---- */
	function hot(id, on) {
		$$('[data-pin-id="' + id + '"], [data-pin="' + id + '"]').forEach(function (n) { n.classList.toggle('wh-is-hot', on); });
	}
	$$('[data-pin]').forEach(function (li) {
		var id = li.getAttribute('data-pin');
		li.addEventListener('mouseenter', function () { hot(id, true); });
		li.addEventListener('mouseleave', function () { hot(id, false); });
		li.addEventListener('focusin', function () { hot(id, true); });
		li.addEventListener('focusout', function () { hot(id, false); });
	});
	$$('.wh-pin').forEach(function (p) {
		var id = p.getAttribute('data-pin-id');
		p.addEventListener('mouseenter', function () { hot(id, true); });
		p.addEventListener('mouseleave', function () { hot(id, false); });
	});

	if (!root.classList.contains('m-js') || !('IntersectionObserver' in window)) {
		return;
	}

	/* ---- Motion layer ---- */
	var parallaxItems = $$('[data-parallax]');
	var counters = $$('[data-count]');
	var counted = new WeakSet();
	var bar = document.createElement('div');
	var fill = document.createElement('i');
	bar.className = 'wh-progress';
	bar.setAttribute('aria-hidden', 'true');
	bar.appendChild(fill);
	var ticking = false;

	function runCount(el) {
		if (counted.has(el)) { return; }
		counted.add(el);
		var target = parseFloat(el.getAttribute('data-count'));
		var dec = parseInt(el.getAttribute('data-decimals') || '0', 10);
		var t0 = null;
		function tick(ts) {
			if (t0 === null) { t0 = ts; }
			var p = Math.min((ts - t0) / 1900, 1);
			el.textContent = (target * (1 - Math.pow(1 - p, 4))).toFixed(dec);
			if (p < 1) { window.requestAnimationFrame(tick); }
		}
		window.requestAnimationFrame(tick);
	}

	function markIn(el) {
		el.classList.add('wh-in');
		if (el.hasAttribute('data-wipe') && el.parentElement) { el.parentElement.classList.add('wh-in'); }
	}

	function revealAll() {
		$$('[data-reveal], [data-reveal-group], [data-split], [data-wipe], #map').forEach(function (el) {
			if (!el.classList.contains('wh-in') && !el.hasAttribute('data-hero')) { markIn(el); }
		});
		counters.forEach(runCount);
	}

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

	function onScroll() {
		ticking = false;
		var y = window.scrollY;
		var max = root.scrollHeight - window.innerHeight;
		fill.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0).toFixed(4) + ')';
		parallax();
		// End of page (or a page that cannot scroll): reveal anything still waiting.
		if (max - y <= 2) { revealAll(); }
	}
	function requestTick() {
		if (!ticking) { ticking = true; window.requestAnimationFrame(onScroll); }
	}

	function split(el) {
		if (el.children.length) { return; }
		var text = el.textContent.replace(/\s+/g, ' ').trim();
		if (!text) { return; }
		el.setAttribute('aria-label', text);
		el.textContent = '';
		var words = text.split(' ');
		words.forEach(function (word, i) {
			var outer = document.createElement('span');
			outer.className = 'wh-w';
			outer.setAttribute('aria-hidden', 'true');
			var inner = document.createElement('span');
			inner.textContent = word;
			inner.style.setProperty('--wi', i);
			outer.appendChild(inner);
			el.appendChild(outer);
			if (i < words.length - 1) { el.appendChild(document.createTextNode(' ')); }
		});
	}

	function init() {
		document.body.appendChild(bar);

		// Sequencing variables
		$$('[data-hero]').forEach(function (el) { el.style.setProperty('--hd', el.getAttribute('data-hero')); });
		$$('[data-pop]').forEach(function (el) { el.style.setProperty('--pd', el.getAttribute('data-pop')); });
		$$('[data-reveal][data-d]').forEach(function (el) { el.style.setProperty('--rd', (parseFloat(el.getAttribute('data-d')) * 110) + 'ms'); });
		$$('[data-reveal-group]').forEach(function (group) {
			Array.prototype.forEach.call(group.children, function (child, i) { child.style.setProperty('--i', i); });
		});

		$$('[data-split]').forEach(split);

		counters.forEach(function (el) {
			el.textContent = (0).toFixed(parseInt(el.getAttribute('data-decimals') || '0', 10));
		});

		// Reveal on enter. Hero items start deterministically below.
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				markIn(entry.target);
				io.unobserve(entry.target);
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
		$$('[data-reveal], [data-reveal-group], [data-split], [data-wipe], #map').forEach(function (el) {
			if (!el.closest('.wh-hero')) { io.observe(el); }
		});

		var ioCount = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { runCount(entry.target); ioCount.unobserve(entry.target); }
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { ioCount.observe(el); });

		// Reviews marquee: duplicate the set for a seamless loop
		var track = $('#whMarquee');
		if (track) {
			Array.prototype.slice.call(track.children).forEach(function (card) {
				var clone = card.cloneNode(true);
				clone.setAttribute('aria-hidden', 'true');
				track.appendChild(clone);
			});
		}

		// Pointer-follow spotlight on service tiles
		$$('.wh-tile').forEach(function (tile) {
			tile.addEventListener('pointermove', function (e) {
				var r = tile.getBoundingClientRect();
				tile.style.setProperty('--wh-mx', (e.clientX - r.left) + 'px');
				tile.style.setProperty('--wh-my', (e.clientY - r.top) + 'px');
			});
		});

		// Magnetic buttons (fine pointers only)
		if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
			$$('[data-magnet]').forEach(function (btn) {
				btn.addEventListener('pointermove', function (e) {
					var r = btn.getBoundingClientRect();
					btn.style.setProperty('--wh-mx', ((e.clientX - r.left - r.width / 2) * 0.2).toFixed(1) + 'px');
					btn.style.setProperty('--wh-my', ((e.clientY - r.top - r.height / 2) * 0.32).toFixed(1) + 'px');
				});
				btn.addEventListener('pointerleave', function () {
					btn.style.setProperty('--wh-mx', '0px');
					btn.style.setProperty('--wh-my', '0px');
				});
			});
		}

		window.addEventListener('scroll', requestTick, { passive: true });
		window.addEventListener('resize', requestTick);

		// Go: start the hero sequence, then raise the headline and image
		window.requestAnimationFrame(function () {
			root.classList.add('m-ready');
			window.setTimeout(function () {
				$$('.wh-hero [data-split], .wh-hero [data-wipe]').forEach(markIn);
			}, 240);
			onScroll();
		});
	}

	try {
		init();
	} catch (err) {
		root.classList.remove('m-js');
		root.classList.add('m-ready');
		if (window.console && console.error) { console.error('[walid home motion]', err); }
	}
})();

/**
 * International flag strip: duplicate the list once so the CSS marquee loops seamlessly.
 * The copy is hidden from assistive tech. Skipped when the user prefers reduced motion
 * (the strip is then a plain horizontally scrollable row).
 */
(function () {
	'use strict';
	var track = document.querySelector('.wh-flags-track');
	if (!track || track.classList.contains('is-looping')) {
		return;
	}
	if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		return;
	}
	var items = Array.prototype.slice.call(track.children);
	items.forEach(function (li) {
		var copy = li.cloneNode(true);
		copy.setAttribute('aria-hidden', 'true');
		track.appendChild(copy);
	});
	track.classList.add('is-looping');
})();
