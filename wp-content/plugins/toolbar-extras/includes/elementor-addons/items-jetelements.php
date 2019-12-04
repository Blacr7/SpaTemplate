<?php

// includes/elementor-addons/items-jetelements

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_jetelements', 100 );
/**
 * Items for Add-On: JetElements (Premium, by Zemez Jet/ Crocoblock)
 *
 * @since 1.1.0
 *
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_jetelements( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbex_filter_is_addon', '__return_empty_string' );

	/** JetElements Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-jetelements',
			'parent' => 'tbex-addons',
			'title'  => esc_attr__( 'JetElements', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'admin.php?page=jet-elements-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'JetElements', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-jetelements-settings',
				'parent' => 'ao-jetelements',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=jet-elements-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-jetelements-resources',
					'parent' => 'ao-jetelements',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'jetelements-docs',
				'group-jetelements-resources',
				'https://documentation.zemez.io/wordpress/index.php?project=jetelements'
			);

			ddw_tbex_resource_item(
				'facebook-group',
				'jetelements-facebook',
				'group-jetelements-resources',
				'https://www.facebook.com/groups/CrocoblockCommunity/'
			);

			ddw_tbex_resource_item(
				'changelog',
				'jetelements-changelog',
				'group-jetelements-resources',
				'https://documentation.zemez.io/wordpress/index.php?project=jetelements&lang=en&section=jetelements-changelog',
				ddw_tbex_string_version_history( 'addon' )
			);

			ddw_tbex_resource_item(
				'official-site',
				'jetelements-site',
				'group-jetelements-resources',
				'https://jetelements.zemez.io/'
			);

		}  // end if

}  // end function
