<?php

// includes/elementor-addons/items-total-recipe-generator

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_trg_elementor', 100 );
/**
 * Items for Add-On: Total Recipe Generator (Premium, by SaurabhSharma)
 *
 * @since 1.1.0
 *
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_trg_elementor( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbex_filter_is_addon', '__return_empty_string' );

	/** Total Recipe Generator Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-trgel',
			'parent' => 'tbex-addons',
			'title'  => esc_attr__( 'Total Recipe Generator', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'options-general.php?page=trg_settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Total Recipe Generator', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-trgel-adspots',
				'parent' => 'ao-trgel',
				'title'  => esc_attr__( 'Ad Spots', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=trg_settings#trg_adspots' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Ad Spots', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-trgel-display',
				'parent' => 'ao-trgel',
				'title'  => esc_attr__( 'Display Settings', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=trg_settings#trg_display' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Display Settings', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-trgel-social',
				'parent' => 'ao-trgel',
				'title'  => esc_attr__( 'Social Sharing', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=trg_settings#trg_social' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Social Sharing', 'toolbar-extras' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-trgel-resources',
					'parent' => 'ao-trgel',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'support-contact',
				'trgel-contact',
				'group-trgel-resources',
				'https://1.envato.market/53mxN'
			);

			ddw_tbex_resource_item(
				'official-site',
				'trgel-site',
				'group-trgel-resources',
				'http://labs.saurabh-sharma.net/plugins/total-recipe-generator-el/'
			);

		}  // end if

}  // end function
