<?php

// includes/plugins-forms/items-wpforms

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Check if WPForms Pro plugin is active or not.
 *
 * @since 1.4.0
 *
 * @return bool TRUE if conditions are met, FALSE otherwise.
 */
function ddw_tbex_is_wpforms_pro_active() {

	if ( ( defined( 'WPFORMS_PLUGIN_SLUG' ) && 'wpforms' === WPFORMS_PLUGIN_SLUG )
		|| class_exists( 'WPForms_Pro' )
	) {
		return TRUE;
	}

	return FALSE;

}  // end function


/**
 * Check if WPForms Conversational Forms Add-On plugin is active or not.
 *
 * @since 1.4.9
 *
 * @return bool TRUE if conditions are met, FALSE otherwise.
 */
function ddw_tbex_is_wpforms_conversational_active() {

	return defined( 'WPFORMS_CONVERSATIONAL_FORMS_VERSION' );

}  // end function


/**
 * Check if WPForms Form Pages Add-On plugin is active or not.
 *
 * @since 1.4.9
 *
 * @return bool TRUE if conditions are met, FALSE otherwise.
 */
function ddw_tbex_is_wpforms_formpages_active() {

	return defined( 'WPFORMS_FORM_PAGES_VERSION' );

}  // end function


/**
 * Check if Entries for WPForms plugin is active or not.
 *
 * @since 1.4.3
 *
 * @return bool TRUE if conditions are met, FALSE otherwise.
 */
function ddw_tbex_is_entries_for_wpforms_active() {

	return defined( 'WPFORMS_ENTRIES_PLUGIN_FILE' );

}  // end function


/**
 * Check if Database for WPforms plugin is active or not.
 *
 * @since 1.4.3
 *
 * @return bool TRUE if conditions are met, FALSE otherwise.
 */
function ddw_tbex_is_database_for_wpforms_active() {

	return function_exists( 'wpforms_db_init' );

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbex_site_items_wpforms' );
/**
 * Items for Plugin: WPForms Lite/Pro (free/Premium, by WPForms LLC)
 *
 * @since 1.3.1
 * @since 1.4.9 Added Pro Add-Ons integration; added/tweaked resources.
 *
 * @uses wpforms_decode()	// by WPForms!
 * @uses ddw_tbex_is_wpforms_conversational_active()
 * @uses ddw_tbex_is_wpforms_formpages_active()
 * @uses ddw_tbex_is_wpforms_pro_active()
 * @uses ddw_tbex_is_entries_for_wpforms_active()
 * @uses ddw_tbex_is_database_for_wpforms_active()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_site_items_wpforms( $admin_bar ) {

	/** For: Forms */
	$admin_bar->add_node(
		array(
			'id'     => 'forms-wpforms',
			'parent' => 'tbex-sitegroup-forms',
			'title'  => esc_attr__( 'WPForms', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'admin.php?page=wpforms-overview' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'WPForms', 'toolbar-extras' ),
			)
		)
	);

		/**
		 * Dynamic section: Add each individual form as an item.
		 *   Forms are saved as a post type therefore a query necessary.
		 * @since 1.3.1
		 * @since 1.4.9 Lots of additions; "Special Forms" and Add-Ons.
		 */
		$args = array(
			'post_type'      => 'wpforms',
			'posts_per_page' => -1,
		);

		$forms = get_posts( $args );

		/** Proceed only if there are any forms */
		if ( $forms && function_exists( 'wpforms_decode' ) ) {

			/** Add group */
			$admin_bar->add_group(
				array(
					'id'     => 'group-wpforms-edit-forms',
					'parent' => 'forms-wpforms',
				)
			);

			/** Add optional group */
			if ( ddw_tbex_is_wpforms_conversational_active() || ddw_tbex_is_wpforms_formpages_active() ) {

				$admin_bar->add_group(
					array(
						'id'     => 'group-wpforms-special-forms',
						'parent' => 'forms-wpforms',
					)
				);

			}  // end if

			/** Loop through all forms */
			foreach ( $forms as $form ) {

				$form_title = esc_attr( $form->post_title );
				$form_id    = absint( $form->ID );

				/** Needed for Add-Ons support! */
				$form_data = ! empty( $form->post_content ) ? wpforms_decode( $form->post_content ) : array();

				/** Add item per form */
				$admin_bar->add_node(
					array(
						'id'     => 'forms-wpforms-form-' . $form_id,
						'parent' => 'group-wpforms-edit-forms',
						'title'  => $form_title,
						'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder&view=fields&form_id=' . $form_id ) ),
						'meta'   => array(
							'target' => ddw_tbex_meta_target( 'builder' ),
							'title'  => esc_attr__( 'Edit Form', 'toolbar-extras' ) . ': ' . $form_title,
						)
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'forms-wpforms-form-' . $form_id . '-builder',
							'parent' => 'forms-wpforms-form-' . $form_id,
							'title'  => esc_attr__( 'Form Builder', 'toolbar-extras' ),
							'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder&view=fields&form_id=' . $form_id ) ),
							'meta'   => array(
								'target' => ddw_tbex_meta_target( 'builder' ),
								'title'  => esc_attr__( 'Form Builder', 'toolbar-extras' ),
							)
						)
					);

					$admin_bar->add_node(
						array(
							'id'     => 'forms-wpforms-form-' . $form_id . '-preview',
							'parent' => 'forms-wpforms-form-' . $form_id,
							'title'  => esc_attr__( 'Preview', 'toolbar-extras' ),
							'href'   => esc_url( site_url( '/wpforms-preview/?wpforms_preview=form&form_id=' . $form_id ) ),
							'meta'   => array(
								'target' => ddw_tbex_meta_target(),
								'title'  => esc_attr__( 'Preview', 'toolbar-extras' ),
							)
						)
					);

					/** Pro Add-On: Conversational Forms (extra view) */
					if ( ddw_tbex_is_wpforms_conversational_active() ) {

						if ( ! empty( $form_data[ 'settings' ][ 'conversational_forms_enable' ] ) ) {

							$admin_bar->add_node(
								array(
									'id'     => 'forms-wpforms-form-' . $form_id . '-conversational-view',
									'parent' => 'forms-wpforms-form-' . $form_id,
									'title'  => esc_attr__( 'Conversational View', 'toolbar-extras' ),
									'href'   => esc_url( home_url( $form->post_name ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Conversational View', 'toolbar-extras' ),
									)
								)
							);

						}  // end if

					}  // end if

					/** Pro Add-On: Form Pages (extra view) */
					if ( ddw_tbex_is_wpforms_formpages_active() ) {

						if ( ! empty( $form_data[ 'settings' ][ 'form_pages_enable' ] ) ) {

							$admin_bar->add_node(
								array(
									'id'     => 'forms-wpforms-form-' . $form_id . '-formpage-view',
									'parent' => 'forms-wpforms-form-' . $form_id,
									'title'  => esc_attr__( 'Form Page View', 'toolbar-extras' ),
									'href'   => esc_url( home_url( $form->post_name ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Form Page View', 'toolbar-extras' ),
									)
								)
							);

						}  // end if

					}  // end if

					/** Entries (Pro feature) */
					if ( ddw_tbex_is_wpforms_pro_active() ) {

						$admin_bar->add_node(
							array(
								'id'     => 'forms-wpforms-form-' . $form_id . '-entries',
								'parent' => 'forms-wpforms-form-' . $form_id,
								'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								'href'   => esc_url( admin_url( 'admin.php?page=wpforms-entries&view=list&form_id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								)
							)
						);

					}  // end if

					/**
					 * Third-party Add-On:
					 *   Entries For WPForms (free, by Sanjeev Aryal)
					 */
					if ( ddw_tbex_is_entries_for_wpforms_active() ) {

						$admin_bar->add_node(
							array(
								'id'     => 'forms-wpforms-form-' . $form_id . '-entries-efwpf',
								'parent' => 'forms-wpforms-form-' . $form_id,
								'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								'href'   => esc_url( admin_url( 'admin.php?page=wpforms-entires-list-table&form_id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								)
							)
						);

					}  // end if

					/**
					 * Third-party Add-On:
					 *   Database for WPforms (free, by Arshid)
					 */
					if ( ddw_tbex_is_database_for_wpforms_active() ) {

						$admin_bar->add_node(
							array(
								'id'     => 'forms-wpforms-form-' . $form_id . '-entries-efwpf',
								'parent' => 'forms-wpforms-form-' . $form_id,
								'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								'href'   => esc_url( admin_url( 'admin.php?page=wp-forms-db-list.php&fid=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Entries', 'toolbar-extras' ),
								)
							)
						);

					}  // end if

				/**
				 * Optional "collectors group" for Special Forms:
				 *   Conversational Forms & Form Pages (both via Add-Ons)
				 * @since 1.4.9
				 */
				if ( ddw_tbex_is_wpforms_conversational_active() || ddw_tbex_is_wpforms_formpages_active() ) {

					/** Conversational Forms */
					if ( ! empty( $form_data[ 'settings' ][ 'conversational_forms_enable' ] ) ) {

						$admin_bar->add_node(
							array(
								'id'     => 'forms-wpforms-conversational-forms',
								'parent' => 'group-wpforms-special-forms',
								'title'  => esc_attr__( 'Conversational Forms', 'toolbar-extras' ),
								'href'   => FALSE,
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Conversational Forms', 'toolbar-extras' ),
								)
							)
						);

							$admin_bar->add_node(
								array(
									'id'     => 'forms-wpforms-conversational-forms-' . $form_id,
									'parent' => 'forms-wpforms-conversational-forms',
									'title'  => $form_title,
									'href'   => esc_url( home_url( $form->post_name ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Conversational Form', 'toolbar-extras' ) . ': ' . $form_title,
									)
								)
							);

								$admin_bar->add_node(
									array(
										'id'     => 'forms-wpforms-conversational-forms-' . $form_id . '-view',
										'parent' => 'forms-wpforms-conversational-forms-' . $form_id,
										'title'  => esc_attr__( 'View Form Page', 'toolbar-extras' ),
										'href'   => esc_url( home_url( $form->post_name ) ),
										'meta'   => array(
											'target' => ddw_tbex_meta_target(),
											'title'  => esc_attr__( 'Conversational View', 'toolbar-extras' ),
										)
									)
								);

								$admin_bar->add_node(
									array(
										'id'     => 'forms-wpforms-conversational-forms-' . $form_id . '-edit',
										'parent' => 'forms-wpforms-conversational-forms-' . $form_id,
										'title'  => esc_attr__( 'Edit Form', 'toolbar-extras' ),
										'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder&view=fields&form_id=' . $form_id ) ),
										'meta'   => array(
											'target' => ddw_tbex_meta_target( 'builder' ),
											'title'  => esc_attr__( 'Edit Conversational Form', 'toolbar-extras' ),
										)
									)
								);

					}  // end if Special: Conversational

					/** Form Pages */
					if ( ! empty( $form_data[ 'settings' ][ 'form_pages_enable' ] ) ) {

						$admin_bar->add_node(
							array(
								'id'     => 'forms-wpforms-formpage-forms',
								'parent' => 'group-wpforms-special-forms',
								'title'  => esc_attr__( 'Form Pages', 'toolbar-extras' ),
								'href'   => FALSE,
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Form Pages', 'toolbar-extras' ),
								)
							)
						);

							$admin_bar->add_node(
								array(
									'id'     => 'forms-wpforms-formpage-forms-' . $form_id,
									'parent' => 'forms-wpforms-formpage-forms',
									'title'  => $form_title,
									'href'   => esc_url( home_url( $form->post_name ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Form Page', 'toolbar-extras' ) . ': ' . $form_title,
									)
								)
							);

								$admin_bar->add_node(
									array(
										'id'     => 'forms-wpforms-formpage-forms-' . $form_id . '-view',
										'parent' => 'forms-wpforms-formpage-forms-' . $form_id,
										'title'  => esc_attr__( 'View Form Page', 'toolbar-extras' ),
										'href'   => esc_url( home_url( $form->post_name ) ),
										'meta'   => array(
											'target' => ddw_tbex_meta_target(),
											'title'  => esc_attr__( 'Form Page View', 'toolbar-extras' ),
										)
									)
								);

								$admin_bar->add_node(
									array(
										'id'     => 'forms-wpforms-formpage-forms-' . $form_id . '-edit',
										'parent' => 'forms-wpforms-formpage-forms-' . $form_id,
										'title'  => esc_attr__( 'Edit Form', 'toolbar-extras' ),
										'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder&view=fields&form_id=' . $form_id ) ),
										'meta'   => array(
											'target' => ddw_tbex_meta_target( 'builder' ),
											'title'  => esc_attr__( 'Edit Form Page', 'toolbar-extras' ),
										)
									)
								);

					}  // end if Special: Form Pages

				}  // end if Special Forms

			}  // end foreach Forms loop

		}  // end if Forms exist check


		/** General WPForms items */
		$admin_bar->add_node(
			array(
				'id'     => 'forms-wpforms-all-forms',
				'parent' => 'forms-wpforms',
				'title'  => esc_attr__( 'All Forms', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wpforms-overview' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Forms', 'toolbar-extras' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'forms-wpforms-new-form',
				'parent' => 'forms-wpforms',
				'title'  => esc_attr__( 'New Form', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder' ) ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target( 'builder' ),
					'title'  => esc_attr__( 'New Form', 'toolbar-extras' ),
				)
			)
		);

		/** Optional: All Entries */
		if ( ddw_tbex_is_wpforms_pro_active() || ddw_tbex_is_entries_for_wpforms_active() || ddw_tbex_is_database_for_wpforms_active() ) {

			$entries_url = FALSE;

			/** 1) only WPForms Pro */
			if ( ddw_tbex_is_wpforms_pro_active()
				&& ! ( ddw_tbex_is_entries_for_wpforms_active() || ddw_tbex_is_database_for_wpforms_active() )
			) {
				$entries_url = 'admin.php?page=wpforms-entries';
			}

			/** 2) only Entries for WPForms */
			if ( ddw_tbex_is_entries_for_wpforms_active()
				&& ! ( ddw_tbex_is_wpforms_pro_active() || ddw_tbex_is_database_for_wpforms_active() )
			) {
				$entries_url = 'admin.php?page=wpforms-entires-list-table';
			}

			/** 3) only Database for WPForms */
			if ( ddw_tbex_is_database_for_wpforms_active()
				&& ! ( ddw_tbex_is_wpforms_pro_active() || ddw_tbex_is_entries_for_wpforms_active() )
			) {
				$entries_url = 'admin.php?page=wp-forms-db-list.php';
			}

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-all-entries',
					'parent' => 'forms-wpforms',
					'title'  => esc_attr__( 'All Entries', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( $entries_url ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Entries', 'toolbar-extras' ),
					)
				)
			);

		}  // end if

		/** Settings */
		$admin_bar->add_node(
			array(
				'id'     => 'forms-wpforms-settings',
				'parent' => 'forms-wpforms',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-general',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'General', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=general' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'General', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-email',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'Email', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=email' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Email', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-recaptcha',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'reCAPTCHA', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=recaptcha' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'reCAPTCHA', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-validation',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'Validation', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=validation' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Validation', 'toolbar-extras' ),
					)
				)
			);

			/** Payments (Pro feature) */
			if ( ddw_tbex_is_wpforms_pro_active() ) {

				$admin_bar->add_node(
					array(
						'id'     => 'forms-wpforms-settings-payments',
						'parent' => 'forms-wpforms-settings',
						'title'  => esc_attr__( 'Payments', 'toolbar-extras' ),
						'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=payments' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Payments', 'toolbar-extras' ),
						)
					)
				);

			}  // end if

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-integrations',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'Integrations', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=integrations' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Integrations', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-settings-misc',
					'parent' => 'forms-wpforms-settings',
					'title'  => esc_attr__( 'Misc', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-settings&view=misc' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Misc', 'toolbar-extras' ),
					)
				)
			);

		/** Tools */
		$admin_bar->add_node(
			array(
				'id'     => 'forms-wpforms-tools',
				'parent' => 'forms-wpforms',
				'title'  => esc_attr__( 'Tools', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wpforms-tools' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Tools', 'toolbar-extras' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-tools-import',
					'parent' => 'forms-wpforms-tools',
					'title'  => esc_attr__( 'Import', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-tools&view=import' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Import', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-tools-export',
					'parent' => 'forms-wpforms-tools',
					'title'  => esc_attr__( 'Export', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-tools&view=export' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Export', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-tools-system',
					'parent' => 'forms-wpforms-tools',
					'title'  => esc_attr__( 'System Info', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-tools&view=system' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'System Info', 'toolbar-extras' ),
					)
				)
			);

		/** About */
		$admin_bar->add_node(
			array(
				'id'     => 'forms-wpforms-about',
				'parent' => 'forms-wpforms',
				'title'  => esc_attr__( 'About', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'admin.php?page=wpforms-about' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'About', 'toolbar-extras' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-about-getstarted',
					'parent' => 'forms-wpforms-about',
					'title'  => esc_attr__( 'Getting Started', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-about&view=getting-started' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Getting Started', 'toolbar-extras' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'forms-wpforms-about-devteam',
					'parent' => 'forms-wpforms-about',
					'title'  => esc_attr__( 'Developer Team', 'toolbar-extras' ),
					'href'   => esc_url( admin_url( 'admin.php?page=wpforms-about&view=about' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Developer Team', 'toolbar-extras' ),
					)
				)
			);

		/** Optionally, let other WPForms Add-Ons hook in */
		do_action( 'tbex_after_wpforms_settings', $admin_bar );

		/** Group: Resources for WPForms */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-wpforms-resources',
					'parent' => 'forms-wpforms',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			if ( ddw_tbex_is_wpforms_pro_active() ) {

				ddw_tbex_resource_item(
					'support-contact',
					'wpforms-contact',
					'group-wpforms-resources',
					'https://wpforms.com/account/support/'
				);

			} else {

				ddw_tbex_resource_item(
					'support-forum',
					'wpforms-support',
					'group-wpforms-resources',
					'https://wordpress.org/support/plugin/wpforms-lite'
				);

			}  // end if

			ddw_tbex_resource_item(
				'documentation',
				'wpforms-docs',
				'group-wpforms-resources',
				'https://wpforms.com/docs/'
			);

			ddw_tbex_resource_item(
				'facebook-group',
				'wpforms-fbgroup',
				'group-wpforms-resources',
				'https://www.facebook.com/groups/wpformsvip/'
			);

			if ( ! ddw_tbex_is_wpforms_pro_active() ) {

				ddw_tbex_resource_item(
					'translations-community',
					'wpforms-translate',
					'group-wpforms-resources',
					'https://translate.wordpress.org/projects/wp-plugins/wpforms-lite'
				);

			}  // end if

			ddw_tbex_resource_item(
				'official-site',
				'wpforms-site',
				'group-wpforms-resources',
				'https://wpforms.com/'
			);

			/** Developer documentation */
			if ( ddw_tbex_display_items_dev_mode() ) {

				ddw_tbex_resource_item(
					'documentation-dev',
					'wpforms-developer-docs',
					'group-wpforms-resources',
					'https://wpforms.com/developers/'		// 'https://developers.wpforms.com/'
				);

			}  // end if

		}  // end if

}  // end function


add_action( 'wp_before_admin_bar_render', 'ddw_tbex_remove_original_wpforms_newcontent' );
/**
 * Remove original "WPForms" item from New Content Group.
 *
 * @since 1.3.1
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_tbex_remove_original_wpforms_newcontent() {

	/** Bail early if items display is not wanted */
	if ( ! ddw_tbex_display_items_new_content() ) {
		return;
	}

	$GLOBALS[ 'wp_admin_bar' ]->remove_node( 'wpforms' );

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_new_content_wpforms', 80 );
/**
 * Items for "New Content" section: New WPForms Form
 *
 * @since 1.3.1
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbex_aoitems_new_content_wpforms( $admin_bar ) {

	/** Bail early if items display is not wanted */
	if ( ! ddw_tbex_display_items_new_content() ) {
		return $admin_bar;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'tbex-wpforms-form',
			'parent' => 'new-content',
			'title'  => ddw_tbex_string_new_form( 'WPForms' ),
			'href'   => esc_url( admin_url( 'admin.php?page=wpforms-builder' ) ),
			'meta'   => array(
				'target' => ddw_tbex_meta_target( 'builder' ),
				'title'  => ddw_tbex_string_add_new_item( ddw_tbex_string_new_form( 'WPForms' ) ),
			)
		)
	);

}  // end function


add_action( 'admin_init', 'ddw_tbex_plugins_view_filter_wpforms_pro', 100 );
/**
 * On the Plugins page add a new filter view to only list all
 *   (official) WPForms Main & Add-On plugins by WPForms LLC.
 *
 * @since 1.4.9
 *
 * @uses \DDW\TBEX\Group_Plugins()
 */
function ddw_tbex_plugins_view_filter_wpforms_pro() {

	/** Bail early if not in a WPForms Pro context */
	if ( ! ddw_tbex_is_wpforms_pro_active() ) {
		return;
	}

	/** Load the class */
	if ( ! class_exists( '\DDW\TBEX\Group_Plugins' ) ) {
		require_once TBEX_PLUGIN_DIR . 'includes/class-group-plugins.php';
	}

	/** Instantiate the class with given params */
	$wpml_plugins = new \DDW\TBEX\Group_Plugins();
	$wpml_plugins->init(
		'wpforms-pro',
		'WPForms',
		array(
			'author-name'      => 'WPForms',
			'plugin-name'      => 'WPForms',
			//'description-word' => '',
			'check-type'       => 'and',
		)
	);

}  // end function
