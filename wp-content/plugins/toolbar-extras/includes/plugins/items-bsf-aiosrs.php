<?php

// includes/plugins/items-bsf-aiosrs

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_site_items_bsf_aiosrs' );
/**
 * Items for Plugin: All In One Schema Rich Snippets (free, by Brainstorm Force)
 *
 * @since 1.3.2
 *
 * @uses ddw_tbex_rand()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_site_items_bsf_aiosrs( $admin_bar ) {

	$rand = ddw_tbex_rand();

	/** For: Elements */
	$admin_bar->add_node(
		array(
			'id'     => 'bsf-aiosrs',
			'parent' => 'tbex-sitegroup-elements',
			'title'  => esc_attr__( 'Rich Snippets', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'admin.php?page=rich_snippet_dashboard' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Rich Snippets', 'toolbar-extras' ),
			)
		)
	);

		/** Group: Settings */
		$admin_bar->add_group(
			array(
				'id'     => 'group-aiosrs-settings',
				'parent' => 'bsf-aiosrs',
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'bsf-aiosrs-configuration',
				'parent' => 'group-aiosrs-settings',
				'title'  => esc_attr__( 'Configuration', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=rich_snippet_dashboard&rand=' . $rand . '#tab-1' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Configuration', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'bsf-aiosrs-customization',
				'parent' => 'group-aiosrs-settings',
				'title'  => esc_attr__( 'Customization', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=rich_snippet_dashboard&rand=' . $rand . '#tab-4' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Customization', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'bsf-aiosrs-usage',
				'parent' => 'group-aiosrs-settings',
				'title'  => esc_attr__( 'How to use?', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=rich_snippet_dashboard&rand=' . $rand . '#tab-2' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'How to use?', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'bsf-aiosrs-faqs',
				'parent' => 'group-aiosrs-settings',
				'title'  => esc_attr__( 'FAQs', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=rich_snippet_dashboard&rand=' . $rand . '#tab-3' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'FAQs', 'toolbar-extras' ),
				)
			)
		);

		/** Group: External Tools */
		$admin_bar->add_group(
			array(
				'id'     => 'group-aiosrs-external',
				'parent' => 'bsf-aiosrs',
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'bsf-aiosrs-faqs',
				'parent' => 'group-aiosrs-external',
				'title'  => esc_attr__( 'Google Test Tool', 'toolbar-extras' ),
				'href'   => 'http://www.google.com/webmasters/tools/richsnippets',
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Google Test Tool', 'toolbar-extras' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-aiosrs-resources',
					'parent' => 'bsf-aiosrs',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'support-forum',
				'aiosrs-support',
				'group-aiosrs-resources',
				'https://wordpress.org/support/plugin/all-in-one-schemaorg-rich-snippets'
			);

			ddw_tbex_resource_item(
				'translations-community',
				'aiosrs-translate',
				'group-aiosrs-resources',
				'https://translate.wordpress.org/projects/wp-plugins/all-in-one-schemaorg-rich-snippets'
			);

			ddw_tbex_resource_item(
				'github',
				'aiosrs-github',
				'group-aiosrs-resources',
				'https://github.com/brainstormforce/all-in-one-schemaorg-rich-snippets'
			);

			ddw_tbex_resource_item(
				'official-site',
				'aiosrs-site',
				'group-aiosrs-resources',
				'https://wpschema.com/free-rich-snippets-schema-plugin-for-wordpress/'
			);

		}  // end if

}  // end function
