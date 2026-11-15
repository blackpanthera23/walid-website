<?php
/**
 * Homepage branch map: schematic Peninsular Malaysia (Natural Earth 50m, public domain) with the four
 * surgical centres. Static geometry; pins are linked to the branch list by data-pin / data-pin-id.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<figure class="wh-map" id="map" aria-label="<?php echo esc_attr__( 'Schematic map of Peninsular Malaysia showing the four surgical centres', 'walid' ); ?>">
			<svg viewBox="0 0 640 590" role="img" aria-labelledby="mapTitle">
				<title id="mapTitle"><?php echo esc_html__( 'Schematic map of Peninsular Malaysia with surgical centres at Ampang, Jalan Baru, Tasek Gelugor and Sungai Petani', 'walid' ); ?></title>
				<g transform="translate(140 10)">
					<path id="land" class="wh-land" pathLength="1" d="M56.9 40.8 L58.8 36.1 L61.1 20.8 L62.7 17.8 L66.7 16.3 L71.1 16.7 L79.5 30.0 L101.4 38.2 L107.9 40.2 L116.6 36.9 L120.4 39.0 L124.4 42.4 L126.7 51.8 L132.4 60.5 L143.9 59.2 L147.9 60.5 L150.4 60.7 L152.6 68.4 L153.7 81.6 L152.6 89.4 L144.3 100.4 L143.2 107.9 L147.5 112.5 L153.2 117.5 L156.4 121.3 L159.8 120.7 L164.1 118.1 L168.0 111.6 L170.7 106.1 L185.4 99.8 L200.6 94.2 L202.7 94.8 L205.1 97.3 L210.0 105.4 L212.8 107.1 L217.0 107.9 L224.1 107.1 L232.4 102.5 L236.7 93.9 L238.6 87.1 L250.5 75.3 L251.8 66.5 L255.1 60.8 L272.4 64.7 L279.0 67.8 L298.4 98.7 L324.0 120.5 L334.9 128.6 L343.2 132.5 L354.7 144.2 L364.7 158.8 L386.6 200.0 L390.4 218.1 L391.9 245.7 L387.1 287.3 L381.2 308.1 L382.3 317.9 L390.4 332.9 L387.9 347.1 L389.5 358.9 L388.9 391.7 L393.5 401.3 L398.7 407.5 L426.2 427.0 L428.2 434.2 L441.8 458.9 L466.9 512.7 L473.8 536.9 L473.0 543.4 L470.0 546.1 L462.6 548.5 L456.5 543.8 L454.4 540.4 L455.1 536.2 L452.6 532.0 L446.6 527.1 L443.1 522.6 L444.1 530.0 L444.2 539.5 L436.5 540.3 L426.7 537.3 L414.5 540.0 L400.0 551.7 L393.0 552.1 L387.7 542.0 L385.0 535.2 L380.7 530.4 L334.7 505.8 L317.7 499.4 L299.8 480.8 L259.6 460.2 L234.0 440.1 L223.1 427.6 L197.0 416.6 L185.7 403.7 L180.1 401.1 L174.6 396.5 L180.4 383.9 L178.0 370.8 L175.0 359.7 L156.5 337.8 L147.5 322.5 L130.1 307.3 L123.2 298.6 L116.5 288.4 L120.7 284.8 L124.6 282.7 L121.0 275.3 L111.1 262.4 L106.5 247.7 L106.5 219.8 L92.3 180.6 L80.3 126.2 L82.4 107.2 L79.3 86.6 L71.3 66.7 L60.8 52.6 L56.9 40.8Z"/>
					<path class="wh-land-island" d="M73.9 155.5 L71.4 158.3 L64.1 156.7 L65.4 140.3 L69.6 138.2 L76.0 141.2 L78.9 144.0 L73.9 155.5Z"/>
					<path class="wh-land-island" d="M29.8 38.4 L36.9 49.1 L33.3 53.9 L31.6 55.3 L27.3 53.7 L23.3 57.8 L19.4 58.7 L15.5 51.2 L10.7 48.3 L9.6 43.2 L16.1 42.3 L19.9 44.0 L27.2 40.5 L29.8 38.4Z"/>

					<circle class="wh-hub-ring wh-hub-central" cx="221" cy="370" r="52"/>
					<circle class="wh-hub-ring wh-hub-north" cx="93" cy="135" r="44"/>

					<!-- leader lines (north cluster) -->
					<path class="wh-leader" pathLength="1" d="M34 92H62L90 119"/>
					<path class="wh-leader" pathLength="1" d="M34 132H62L89 135"/>
					<path class="wh-leader" pathLength="1" d="M34 168H64L85 153"/>

					<g class="wh-pin" data-pin-id="ampang" style="--i:0"><circle class="wh-pulse" cx="221" cy="370" r="9"/><circle class="wh-dot" cx="221" cy="370" r="8"/><circle class="wh-core" cx="221" cy="370" r="3"/></g>
					<g class="wh-pin" data-pin-id="sp" style="--i:1"><circle class="wh-dot" cx="94" cy="120" r="5.5"/><circle class="wh-core" cx="94" cy="120" r="2"/></g>
					<g class="wh-pin" data-pin-id="tasek" style="--i:2"><circle class="wh-dot" cx="95" cy="135" r="5.5"/><circle class="wh-core" cx="95" cy="135" r="2"/></g>
					<g class="wh-pin" data-pin-id="jalanbaru" style="--i:3"><circle class="wh-dot" cx="89" cy="149" r="5.5"/><circle class="wh-core" cx="89" cy="149" r="2"/></g>

					<text class="wh-lbl" x="28" y="96" text-anchor="end" data-pin-id="sp">Sungai Petani</text>
					<text class="wh-lbl" x="28" y="136" text-anchor="end" data-pin-id="tasek">Tasek Gelugor</text>
					<text class="wh-lbl" x="28" y="172" text-anchor="end" data-pin-id="jalanbaru">Jalan Baru</text>
					<text class="wh-lbl wh-lbl-main" x="250" y="366" data-pin-id="ampang">Ampang</text>
					<text class="wh-lbl wh-lbl-sub" x="250" y="384" data-pin-id="ampang"><?php esc_html_e( 'Flagship hub (HQ)', 'walid' ); ?></text>
				</g>
			</svg>
			<figcaption><i class="wh-legend-dot"></i> <?php esc_html_e( 'Surgical centre', 'walid' ); ?> <span><?php esc_html_e( 'Schematic, not to scale', 'walid' ); ?></span></figcaption>
		</figure>
