<?php

// items-anywhere-elementor
// items-anywhere-elementor-pro

// includes/elementor-addons/items-anywhere-elementor


/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_anywhere_elementor', 100 );
/**
 * Items for Add-On: AnyWhere Elementor (free, by WebTechStreet)
 *
 * @since 1.0.0
 * @since 1.3.5 Added BTC plugin support.
 *
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_anywhere_elementor( $admin_bar ) {

	$type = 'ae_global_templates';

	/** AnyWhere Elementor */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-awelementor',
			'parent' => 'group-creative-content',
			'title'  => esc_attr__( 'AnyWhere Elementor', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_addon_title_attr( __( 'AnyWhere Elementor Global Templates', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-awelementor-all',
				'parent' => 'ao-awelementor',
				'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-awelementor-new',
				'parent' => 'ao-awelementor',
				'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				)
			)
		);

		if ( ddw_tbex_is_elementor_active() && \Elementor\User::is_current_user_can_edit_post_type( $type ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-awelementor-builder',
					'parent' => 'ao-awelementor',
					'title'  => esc_attr__( 'New Template Builder', 'toolbar-extras' ),
					'href'   => esc_attr( \Elementor\Utils::get_create_new_post_url( $type ) ),
					'meta'   => array(
						'target' => ddw_tbex_meta_target( 'builder' ),
						'title'  => esc_attr__( 'New Template Builder', 'toolbar-extras' ),
					)
				)
			);

		}  // end if

		/** Template categories, via BTC plugin */
		if ( ddw_tbex_is_btcplugin_active() ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-awelementor-categories',
					'parent' => 'ao-awelementor',
					'title'  => ddw_btc_string_template( 'template' ),
					'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_html( ddw_btc_string_template( 'template' ) ),
					)
				)
			);

		}  // end if

		/** Group: Resources for AnyWhere Elementor */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-awelementor-resources',
					'parent' => 'ao-awelementor',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'support-forum',
				'awelementor-support',
				'group-awelementor-resources',
				'https://wordpress.org/support/plugin/anywhere-elementor'
			);

			ddw_tbex_resource_item(
				'translations-community',
				'awelementor-translate',
				'group-awelementor-resources',
				'https://translate.wordpress.org/projects/wp-plugins/anywhere-elementor'
			);

		}  // end if

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_anywhere_elementor_pro', 100 );
/**
 * Items for Add-On: AnyWhere Elementor Pro (Premium, by WebTechStreet)
 *
 * @since 1.0.0
 *
 * @since ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_anywhere_elementor_pro( $admin_bar ) {

	/** Bail early if Pro version is not active */
	if ( ! function_exists( 'ae_pro_load_plugin_textdomain' ) ) {
		return $admin_bar;
	}

	/** Pro Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-awelementor-settings',
			'parent' => 'ao-awelementor',
			'title'  => esc_attr__( 'Pro: Settings', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=ae_global_templates&page=aepro-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Pro: Settings', 'toolbar-extras' ),
			)
		)
	);

	/** Pro Resources */
	if ( ddw_tbex_display_items_resources() ) {

		ddw_tbex_resource_item(
			'pro-documentation',
			'awelementor-docs',
			'group-awelementor-resources',
			'https://aedocs.webtechstreet.com/'
		);

		ddw_tbex_resource_item(
			'pro-facebook',
			'awelementor-facebook',
			'group-awelementor-resources',
			'https://www.facebook.com/groups/1570986849635310/'
		);

		ddw_tbex_resource_item(
			'pro-support',
			'awelementor-pro-support',
			'group-awelementor-resources',
			'https://shop.webtechstreet.com/support/'
		);

		ddw_tbex_resource_item(
			'pro-official-site',
			'awelementor-site',
			'group-awelementor-resources',
			'https://www.elementoraddons.com/anywhere-elementor-pro/'
		);

	}  // end if

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbex_new_content_aetemplate' );
/**
 * Items for "New Content" section: New AE Global Template
 *
 * @since 1.0.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_new_content_aetemplate( $admin_bar ) {

	$type = 'ae_global_templates';

	/** Bail early if items display is not wanted */
	if ( ! ddw_tbex_display_items_new_content() || ! \Elementor\User::is_current_user_can_edit_post_type( $type ) ) {
		return $admin_bar;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'aetemplate-with-builder',
			'parent' => 'new-' . $type,
			'title'  => ddw_tbex_string_newcontent_with_builder(),
			'href'   => esc_attr( \Elementor\Utils::get_create_new_post_url( $type ) ),
			'meta'   => array(
				'target' => ddw_tbex_meta_target( 'builder' ),
				'title'  => ddw_tbex_string_newcontent_create_with_builder(),
			)
		)
	);

}  // end function
