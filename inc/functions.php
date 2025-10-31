<?php

namespace Bethink\SafetyNet;

define( 'SITE_DETAILS_OPTION', 'bsn_site_details' );
define( 'SITE_DETAILS_OPTION_HASH', 'bsn_site_details_hash' );

/**
 * Retrieve stored site details from the WordPress options table.
 *
 * @return mixed|null Site details array or null if not set.
 */
function get_stored_site_details() {
	return get_option( SITE_DETAILS_OPTION, null );
}

/**
 * Retrieve the hash of the stored site details.
 *
 * @return string|null Hash string or null if not set.
 */
function get_stored_site_details_hash() {
	return get_option( SITE_DETAILS_OPTION_HASH, null );
}

/**
 * Gather current site details including environment, URLs, server info, and database credentials.
 *
 * @return array Associative array of site details.
 */
function get_site_details() {
	$site_details = array();

	$site_details['env_type']        = wp_get_environment_type();
	$site_details['opt_home']        = get_option( 'home' );
	$site_details['opt_siteurl']     = get_option( 'siteurl' );
	$site_details['abspath']         = ABSPATH;
	$site_details['server_hostname'] = gethostname();
	$site_details['server_ip']       = $_SERVER['SERVER_ADDR'];
	$site_details['db']              = sprintf(
		'👤 %1$s 🌐 %2$s ⛃ %3$s',
		defined( 'DB_USER' ) ? DB_USER : '',
		defined( 'DB_HOST' ) ? DB_HOST : '',
		defined( 'DB_NAME' ) ? DB_NAME : ''
	);

	return $site_details;
}

/**
 * Generate a hash of the current site details.
 *
 * @param array|null $site_details Site details array.
 * @return string Hash string.
 */
function get_site_details_hash( $site_details = null ) {
	if ( null === $site_details ) {
		$site_details = get_site_details();
	}
	return sha1( wp_json_encode( $site_details ) );
}

/**
 * Check if the stored site details have changed.
 *
 * @param bool $details Whether to return the details of the change.
 * @return bool|array Truthy if site details have changed, false otherwise.
 */
function have_site_details_changed( $details = false ) {
	$site_details_hash        = get_site_details_hash();
	$stored_site_details_hash = get_stored_site_details_hash();

	if ( $site_details_hash !== $stored_site_details_hash ) {
		if ( $details ) {
			$site_details        = get_site_details();
			$stored_site_details = get_stored_site_details();
			return array(
				'current' => $site_details,
				'stored'  => $stored_site_details,
				'diff'    => array_diff_assoc( $site_details, $stored_site_details ),
			);
		}

		return true;
	}

	return false;
}

/**
 * Set or retrieve the site details from the WordPress options table.
 *
 * @return void
 */
function update_site_details() {
	update_option( SITE_DETAILS_OPTION, get_site_details() );
	update_option( SITE_DETAILS_OPTION_HASH, get_site_details_hash() );
}
