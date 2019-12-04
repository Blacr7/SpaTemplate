<?php

// includes/elementor-addons/items-jetblocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_jetblocks', 100 );
/**
 * Items for Add-On: JetBlocks (Premium, by Zemez Jet/ Crocoblock)
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_jetblocks( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbex_filter_is_addon', '__return_empty_string' );

	/** JetBlocks Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-jetblocks',
			'parent' => 'tbex-addons',
			'title'  => esc_attr__( 'JetBlocks', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'admin.php?page=jet-blocks-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'JetBlocks', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-jetblocks-settings',
				'parent' => 'ao-jetblocks',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=jet-blocks-settings' ) ),
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
					'id'     => 'group-jetblocks-resources',
					'parent' => 'ao-jetblocks',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'jetblocks-docs',
				'group-jetblocks-resources',
				'https://documentation.zemez.io/wordpress/index.php?project=jetblocks'
			);

			ddw_tbex_resource_item(
				'facebook-group',
				'jetblocks-facebook',
				'group-jetblocks-resources',
				'https://www.facebook.com/groups/CrocoblockCommunity/'
			);

			ddw_tbex_resource_item(
				'changelog',
				'jetblocks-changelog',
				'group-jetblocks-resources',
				'http://documentation.zemez.io/wordpress/index.php?project=jetblocks&lang=en&section=jetblocks-changelog',
				ddw_tbex_string_version_history( 'addon' )
			);

			ddw_tbex_resource_item(
				'official-site',
				'jetblocks-site',
				'group-jetblocks-resources',
				'https://jetblocks.zemez.io/'
			);

		}  // end if

}  // end function
