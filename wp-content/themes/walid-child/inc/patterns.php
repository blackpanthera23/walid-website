<?php
/**
 * Block patterns for Poliklinik Walid.
 *
 * Gives content staff reusable, on-brand sections to drop into pages in the block editor,
 * so they can build new pages without a developer (the CMS payoff). Patterns use core blocks
 * styled by the brand palette/CSS.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a "Walid" pattern category + a few patterns.
 */
function walid_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern_category(
		'walid',
		array( 'label' => __( 'Poliklinik Walid', 'walid' ) )
	);

	$wa_general = walid_whatsapp_url( 'general' );

	// 1) Value strip (three cards).
	register_block_pattern(
		'walid/value-strip',
		array(
			'title'      => __( 'Walid: value strip', 'walid' ),
			'categories' => array( 'walid' ),
			'content'    => '<!-- wp:columns {"className":"walid-pattern-value"} --><div class="wp-block-columns walid-pattern-value">'
				. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>' . esc_html__( 'Day-care surgery', 'walid' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__( 'Assessed and treated, home the same day.', 'walid' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column -->'
				. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>' . esc_html__( 'Hospital-grade care', 'walid' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__( 'Surgeon-led, MMC-registered doctors.', 'walid' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column -->'
				. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>' . esc_html__( 'The smart choice', 'walid' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__( 'Care that respects your time and money.', 'walid' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column -->'
				. '</div><!-- /wp:columns -->',
		)
	);

	// 2) WhatsApp CTA band.
	register_block_pattern(
		'walid/whatsapp-cta',
		array(
			'title'      => __( 'Walid: WhatsApp CTA', 'walid' ),
			'categories' => array( 'walid' ),
			'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"48px","bottom":"48px"}}},"backgroundColor":"brand-soft","layout":{"type":"constrained"}} --><div class="wp-block-group has-brand-soft-background-color has-background" style="padding-top:48px;padding-bottom:48px">'
				. '<!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Ready when you are.', 'walid' ) . '</h2><!-- /wp:heading -->'
				. '<!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">' . esc_html__( 'Message us on WhatsApp and the clinic team will help.', 'walid' ) . '</p><!-- /wp:paragraph -->'
				. '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $wa_general ) . '" target="_blank" rel="noopener">' . esc_html__( 'WhatsApp us', 'walid' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons -->'
				. '</div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'walid_register_patterns' );
