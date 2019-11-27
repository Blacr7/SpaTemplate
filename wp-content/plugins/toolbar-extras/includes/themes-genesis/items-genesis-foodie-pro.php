<?php

// includes/themes-genesis/items-genesis-foodie-pro

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'tbex_filter_items_theme_customizer_deep', 'ddw_tbex_themeitems_foodie_pro_customize', 90 );
/**
 * Customize items for Genesis Child Theme:
 *   Foodie Pro (Premium, by Feast Design Co.)
 *
 * @since 1.2.0
 * @since 1.4.2 Refactored using filter/array declaration.
 *
 * @param array $items Existing array of params for creating Toolbar nodes.
 * @return array Tweaked array of params for creating Toolbar nodes.
 */
function ddw_tbex_themeitems_foodie_pro_customize( array $items ) {

	/** Declare child theme's items */
	$foodiepro_items = array(
		'typography' => array(
			'type'  => 'panel',
			'title' => esc_attr__( 'Typography', 'toolbar-extras' ),
			'id'    => 'foodiepro-typography',
		),
		'colors' => array(
			'type'  => 'panel',
			'title' => __( 'Colors', 'toolbar-extras' ),
			'id'    => 'foodiepro-colors',
		),
		'header_image' => array(
			'type'  => 'section',
			'title' => __( 'Header Image', 'toolbar-extras' ),
			'id'    => 'foodiepro-header-image',
		),
		'background_image' => array(
			'type'  => 'section',
			'title' => __( 'Background Image', 'toolbar-extras' ),
			'id'    => 'foodiepro-background-image',
		),
	);

	/** Merge and return with all items */
	return array_merge( $items, $foodiepro_items );

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbex_themeitems_foodie_pro', 100 );
/**
 * Theme items for Genesis Child Theme:
 *   Foodie Pro (Premium, by Feast Design Co.)
 *
 * @since 1.2.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_themeitems_foodie_pro( $admin_bar ) {

	$admin_bar->add_node(
		array(
			'id'     => 'foodiepro-theme-info',
			'parent' => 'theme-creative',
			'title'  => esc_attr__( 'Theme Info', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'admin.php?page=feast-dashboard' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Theme Info', 'toolbar-extras' ),
			)
		)
	);

}  // end function
