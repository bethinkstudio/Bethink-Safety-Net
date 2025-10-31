<?php
/**
 * Admin page for Bethink Safety Net plugin.
 *
 * @package Bethink\SafetyNet
 */

namespace Bethink\SafetyNet;

// Hook to add the admin page under Tools
add_action( 'admin_menu', __NAMESPACE__ . '\bsn_add_tools_page' );

/**
 * Register the Safety Net admin page under Tools.
 */
function bsn_add_tools_page() {
	add_management_page(
		__( 'Safety Net Site Details', 'safetynet' ),
		__( 'Safety Net', 'safetynet' ),
		'manage_options',
		'bsn-site-details',
		__NAMESPACE__ . '\bsn_render_tools_page'
	);
}

/**
 * Render the Safety Net admin page.
 */
function bsn_render_tools_page() {
	$site_details = get_stored_site_details();
	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'Safety Net Site Details', 'safetynet' ) . '</h1>';
	if ( empty( $site_details ) ) {
		echo '<p>' . esc_html__( 'No site details are currently stored.', 'safetynet' ) . '</p>';
	} else {
		echo '<table class="widefat fixed" style="max-width:600px;">';
		echo '<thead><tr><th>' . esc_html__( 'Key', 'safetynet' ) . '</th><th>' . esc_html__( 'Value', 'safetynet' ) . '</th></tr></thead><tbody>';
		foreach ( $site_details as $key => $value ) {
			echo '<tr><td>' . esc_html( $key ) . '</td><td>' . esc_html( $value ) . '</td></tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';
}
