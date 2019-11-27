<?php

// includes/elementor-addons/items-templementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_templementor', 100 );
/**
 * Items for Add-On:
 *   Templementor – Persistent Elementor Templates (free, by Lcweb)
 *
 * @since 1.0.0
 * @since 1.3.5 Added BTC plugin support.
 *
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_templementor( $admin_bar ) {

	/** Templementor Templates */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-templementor',
			'parent' => 'group-creative-content',
			'title'  => esc_attr__( 'Templementor', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=tpm_templates' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_addon_title_attr( __( 'Templementor - Persistant Elementor Templates', 'toolbar-extras' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-templementor-all',
				'parent' => 'ao-templementor',
				'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=tpm_templates' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Templates', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-templementor-new',
				'parent' => 'ao-templementor',
				'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=tpm_templates' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Template', 'toolbar-extras' ),
				)
			)
		);

		if ( ddw_tbex_is_elementor_active() && \Elementor\User::is_current_user_can_edit_post_type( 'tpm_templates' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-templementor-builder',
					'parent' => 'ao-templementor',
					'title'  => esc_attr__( 'New Template Builder', 'toolbar-extras' ),
					'href'   => esc_attr( \Elementor\Utils::get_create_new_post_url( 'tpm_templates' ) ),
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
					'id'     => 'ao-templementor-categories',
					'parent' => 'ao-templementor',
					'title'  => ddw_btc_string_template( 'template' ),
					'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=tpm_templates' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_html( ddw_btc_string_template( 'template' ) ),
					)
				)
			);

		}  // end if

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-templementor-resources',
					'parent' => 'ao-templementor',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'support-forum',
				'templementor-support',
				'group-templementor-resources',
				'https://wordpress.org/support/plugin/templementor'
			);

			ddw_tbex_resource_item(
				'translations-community',
				'templementor-translate',
				'group-templementor-resources',
				'https://translate.wordpress.org/projects/wp-plugins/templementor'
			);

		}  // end if

}  // end function
