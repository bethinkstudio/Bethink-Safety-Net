<?php
/**
 * Plugin Name: Bethink Safety Net
 * Plugin URI: http://github.com/bethinkstudio/bethink-safety-net/
 * Description: A safety net to disable routine tasks on staging sites.
 * Author: George Stephanis / Bethink Studio
 * Version: 1.0.0
 * Author URI: https://bethink.studio/
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: safetynet
 * Domain Path: /languages
 *
 * @package Bethink\SafetyNet
 */

namespace Bethink\SafetyNet;

require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/admin.php';

if ( have_site_details_changed() ) {
	// Handle acceptance form submission.
	if ( isset( $_POST['bsn_acknowledge_changes'] ) ) {
		if ( hash_equals(
			sanitize_text_field( wp_unslash( $_POST['bsn_acknowledge_changes'] ) ),
			get_nonce( 'live' )
		) ) {
			// User has acknowledged changes, update stored details.
			store_site_details();
		} else {
			wp_die( esc_html__( 'Security check failed.', 'safetynet' ) );
		}
	// Handle limitations form submission.
	} elseif ( isset( $_POST['bsn_implement_limits'] ) ) {
		if ( hash_equals(
			sanitize_text_field( wp_unslash( $_POST['bsn_implement_limits'] ) ),
			get_nonce( 'stored' )
		) ) {
			// User has requested to implement limits.
			implement_environment_limits();
		} else {
			wp_die( esc_html__( 'Security check failed.', 'safetynet' ) );
		}
	// Handle initial storage for change detection.
	} elseif ( empty( get_stored_site_details() ) ) {
		// First run, store the details.
		store_site_details();
	// Site details have changed, show warning and prompt user!
	} else {
		if ( current_user_can( 'manage_options' ) ) {
			require_once __DIR__ . '/inc/tmpl-detected-changed-details.php';
			exit;
		}
		// For non-admin users, block access and show message.
		wp_die( esc_html__( 'Site details have changed. Please contact the site administrator.', 'safetynet' ) );
	}
}
