<?php

// includes/elementor-addons/items-header-footer-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_header_footer_builder', 100 );
/**
 * Items for Add-On: Header Footer Builder for Elementor (free, by Brainstorm Force)
 *
 * @since 1.0.0
 * @since 1.3.5 Added BTC plugin support.
 *
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_header_footer_builder( $admin_bar ) {

	/** Header Footer for Elementor */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-hfbuilder',
			'parent' => 'group-creative-content',
			'title'  => esc_attr__( 'Header Footer Builder', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=elementor-hf' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_addon_title_attr( __( 'Header Footer Builder for Elementor', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-hfbuilder-all',
				'parent' => 'ao-hfbuilder',
				'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=elementor-hf' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-hfbuilder-new',
				'parent' => 'ao-hfbuilder',
				'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=elementor-hf' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				)
			)
		);

		if ( ddw_tbex_is_elementor_active() && \Elementor\User::is_current_user_can_edit_post_type( 'elementor-hf' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-hfbuilder-builder',
					'parent' => 'ao-hfbuilder',
					'title'  => esc_attr__( 'New Template Builder', 'toolbar-extras' ),
					'href'   => esc_attr( \Elementor\Utils::get_create_new_post_url( 'elementor-hf' ) ),
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
					'id'     => 'ao-hfbuilder-categories',
					'parent' => 'ao-hfbuilder',
					'title'  => ddw_btc_string_template( 'template' ),
					'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=elementor-hf' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_html( ddw_btc_string_template( 'template' ) ),
					)
				)
			);

		}  // end if

		/** Group: Resources for Header Footer Builder */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-hfbuilder-resources',
					'parent' => 'ao-hfbuilder',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'support-forum',
				'hfbuilder-support',
				'group-hfbuilder-resources',
				'https://wordpress.org/support/plugin/header-footer-elementor'
			);

			ddw_tbex_resource_item(
				'translations-community',
				'hfbuilder-translate',
				'group-hfbuilder-resources',
				'https://translate.wordpress.org/projects/wp-plugins/header-footer-elementor'
			);

			ddw_tbex_resource_item(
				'github',
				'hfbuilder-github',
				'group-hfbuilder-resources',
				'https://github.com/Nikschavan/header-footer-elementor'
			);

		}  // end if

}  // end function
