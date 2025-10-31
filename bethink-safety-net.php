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
	if ( empty( get_stored_site_details() ) ) {
		// First run, store the details.
		store_site_details();
	} else {
		// Details have changed, show warning.
		require_once __DIR__ . '/inc/tmpl-detected-changed-details.php';
		exit;
	}
}
