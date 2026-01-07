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

if ( is_admin() ) {
	require_once __DIR__ . '/inc/admin.php';
}

if ( get_option( 'bsn_limits_implemented', false ) ) {
	require_once __DIR__ . '/to51-safetynet/safety-net.php';
	return;
}

if ( have_site_details_changed() ) {
	if ( empty( get_stored_site_details() ) ) {
		// First run, store the details.
		store_site_details();
		return;
	}

	require_once ABSPATH . WPINC . '/pluggable.php';

	// Handle acceptance form submission.
	if ( isset( $_POST['bsn_acknowledge_changes'] ) ) {
		if ( hash_equals(
			sanitize_text_field( wp_unslash( $_POST['bsn_acknowledge_changes'] ) ),
			get_nonce( 'live' )
		) ) {
			if ( current_user_can( 'manage_options' ) ) {
				// User has acknowledged changes, update stored details.
				store_site_details();
			} elseif ( isset( $_POST['bsn_username'], $_POST['bsn_password'] ) ) {
				$user = wp_authenticate(
					sanitize_text_field( wp_unslash( $_POST['bsn_username'] ) ),
					sanitize_text_field( wp_unslash( $_POST['bsn_password'] ) )
				);
				if ( is_wp_error( $user ) ) {
					wp_die( esc_html__( 'Authentication failed. Please check your credentials and try again.', 'safetynet' ) );
				}
				if ( ! user_can( $user, 'manage_options' ) ) {
					wp_die( esc_html__( 'You do not have sufficient permissions to perform this action.', 'safetynet' ) );
				}
				// User has acknowledged changes, update stored details.
				store_site_details();
				wp_safe_redirect( admin_url() );
				exit;
			}
		} else {
			wp_die( esc_html__( 'Security check failed.', 'safetynet' ) );
		}
	} elseif ( defined( 'BSN_ACKNOWLEDGE_CHANGES' ) && hash_equals( BSN_ACKNOWLEDGE_CHANGES, get_site_details_hash() ) ) {
		store_site_details();
	// Handle limitations form submission.
	} elseif ( isset( $_POST['bsn_implement_limits'] ) ) {
		if ( hash_equals(
			sanitize_text_field( wp_unslash( $_POST['bsn_implement_limits'] ) ),
			get_nonce( 'stored' )
		) ) {
			if ( current_user_can( 'manage_options' ) ) {
				// User has requested to implement limits.
				implement_environment_limits();
			} elseif ( isset( $_POST['bsn_username'], $_POST['bsn_password'] ) ) {
				$user = wp_authenticate(
					sanitize_text_field( wp_unslash( $_POST['bsn_username'] ) ),
					sanitize_text_field( wp_unslash( $_POST['bsn_password'] ) )
				);
				if ( is_wp_error( $user ) ) {
					wp_die( esc_html__( 'Authentication failed. Please check your credentials and try again.', 'safetynet' ) );
				}
				if ( ! user_can( $user, 'manage_options' ) ) {
					wp_die( esc_html__( 'You do not have sufficient permissions to perform this action.', 'safetynet' ) );
				}
				// User has requested to implement limits.
				implement_environment_limits();
				wp_safe_redirect( admin_url() );
				exit;
			}
		} else {
			wp_die( esc_html__( 'Security check failed.', 'safetynet' ) );
		}
	} elseif ( defined( 'BSN_IMPLEMENT_LIMITS' ) && hash_equals( BSN_IMPLEMENT_LIMITS, get_stored_site_details_hash() ) ) {
		implement_environment_limits();
	// Site details have changed, show warning and prompt user!
	} else {
		if ( current_user_can( 'manage_options' ) ) {
			require_once __DIR__ . '/inc/tmpl-detected-changed-details.php';
			exit;
		}
		require_once __DIR__ . '/inc/tmpl-detected-changes-unauthed.php';
		exit;
	}
}
