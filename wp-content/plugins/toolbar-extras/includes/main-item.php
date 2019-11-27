<?php

// includes/main-item

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_toolbar_main_item', ddw_tbex_main_item_priority() );
/**
 * Add main Toolbar item: when a supported Page Builder is active it gets hooked
 *   in, otherwise fallback to the Customizer.
 *   Note: Currently only Elementor is supported.
 *
 * @since 1.0.0
 * @since 1.4.0 Implemented settings support for fallback item, as well as URL
 *              support for both items.
 * @since 1.4.5 Added additional filter 'tbex_filter_set_builder_is_active' to
 *              catch cases were a default builder is set in settings but that
 *              builder plugin is not activated.
 *
 * @uses ddw_tbex_get_default_pagebuilder()
 * @uses ddw_tbex_is_pagebuilder_active()
 * @uses ddw_tbex_get_pagebuilders()
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbex_id_main_item()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbex_string_main_item()
 * @uses ddw_tbex_string_fallback_item()
 * @uses ddw_tbex_customizer_start()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_toolbar_main_item( $admin_bar ) {

	/** Get default Page Builder */
	$default_builder = ddw_tbex_get_default_pagebuilder();

	/** Get link target */
	$link_target = ddw_tbex_get_option( 'general', 'main_item_target' );

	if ( ddw_tbex_is_pagebuilder_active()
		&& ! empty( $default_builder )
		&& 'default-none' !== $default_builder
		&& apply_filters( 'tbex_filter_set_builder_is_active', TRUE )
	) {

		/** Get all registered Page Builders */
		$all_builders = (array) ddw_tbex_get_pagebuilders();

		/** Set Main URL */
		$main_url = ddw_tbex_get_option( 'general', 'main_item_url' );
		$main_url = ( ! empty( $main_url ) ) ? $main_url : $all_builders[ $default_builder ][ 'admin_url' ];

		/** Add main node for Page Builder context */
		$admin_bar->add_node(
			array(
				'id'     => ddw_tbex_id_main_item(),
				'title'  => ddw_tbex_item_title_with_settings_icon( ddw_tbex_string_main_item(), 'general', 'main_item_icon' ),
				'href'   => esc_url( $main_url ),
				'meta'   => array(
					'class'  => 'tbex-main',
					'target' => sanitize_key( $link_target ),
					'rel'    => ddw_tbex_meta_rel(),
					'title'  => ddw_tbex_string_main_item(),
				)
			)
		);

	} else {

		/** Set Fallback URL */
		$fallback_url = ddw_tbex_get_option( 'general', 'fallback_item_url' );
		$fallback_url = ( ! empty( $fallback_url ) ) ? esc_url( $fallback_url ) : ddw_tbex_customizer_start();

		/** Add main node for fallback context */
		$admin_bar->add_node(
			array(
				'id'     => ddw_tbex_id_main_item(),
				'title'  => ddw_tbex_item_title_with_settings_icon( ddw_tbex_string_fallback_item(), 'general', 'fallback_item_icon' ),
				'href'   => $fallback_url,
				'meta'   => array(
					'class'  => 'tbex-main',
					'target' => sanitize_key( $link_target ),		// empty( $fallback_url ) ? '' : ddw_tbex_meta_target(),
					'rel'    => ddw_tbex_meta_rel(),
					'title'  => ddw_tbex_string_fallback_item(),
				)
			)
		);

	}   // end if

	/** Action Hook: After Main Item */
	do_action( 'tbex_after_main_item', $admin_bar );

}  // end function
