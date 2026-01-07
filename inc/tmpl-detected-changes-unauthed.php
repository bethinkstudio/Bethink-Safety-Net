<?php
/**
 * Template for displaying detected changed site details.
 *
 * @package Bethink\SafetyNet
 */

namespace Bethink\SafetyNet;

require_once __DIR__ . '/partial/tmpl-header.php';
$bsn_changes = have_site_details_changed( true );
?>
	<p><?php esc_html_e( 'The following site details have changed since the last check:', 'safetynet' ); ?></p>
	<?php /* As this template is for cases where the user is not authenticated, we don't want to show the values, just notate which have changed. */ ?>
	<ul class="changed-details-list">
		<?php
		foreach ( $bsn_changes['diff'] as $bsn_detail_key => $bsn_values ) {
			printf( '<li>%s</li>', esc_html( $bsn_detail_key ) );
		}
		?>
	</ul>

	<div class="acknowledgement-forms">
		<form method="post">
			<input type="hidden" name="bsn_acknowledge_changes" value="<?php echo esc_attr( get_nonce( 'live' ) ) ?>" />
			<p><?php esc_html_e( 'If this is a PRODUCTION environment, and you want it to continue running as it has previously, please acknowledge the changes below:', 'safetynet' ); ?></p>

			<label for="user_login"><?php _e( 'Username or Email Address', 'safetynet' ); ?></label>
			<input type="text" name="bsn_username" id="user_login" class="input" value="" size="20" autocapitalize="off" autocomplete="username" required="required" />

			<label for="user_pass"><?php _e( 'Password', 'safetynet' ); ?></label>
			<input type="password" name="bsn_password" id="user_pass" class="input password-input" value="" size="20" autocomplete="current-password" spellcheck="false" required="required" />

			<input type="submit" value="<?php esc_attr_e( 'Acknowledge Changes and Update Stored Details', 'safetynet' ); ?>">
		</form>
		<form method="post">
			<input type="hidden" name="bsn_implement_limits" value="<?php echo esc_attr( get_nonce( 'stored' ) ) ?>" />
			<p><?php esc_html_e( 'If this is a DEVELOPMENT or NON-PRODUCTION environment, and you want to implement lockdown measures accordingly, please indicate changes below:', 'safetynet' ); ?></p>

			<label for="user_login_dev"><?php _e( 'Username or Email Address', 'safetynet' ); ?></label>
			<input type="text" name="bsn_username" id="user_login_dev" class="input" value="" size="20" autocapitalize="off" autocomplete="username" required="required" />

			<label for="user_pass_dev"><?php _e( 'Password', 'safetynet' ); ?></label>
			<input type="password" name="bsn_password" id="user_pass_dev" class="input password-input" value="" size="20" autocomplete="current-password" spellcheck="false" required="required" />

			<input type="submit" value="<?php esc_attr_e( 'Implement Limits to Environment', 'safetynet' ); ?>">
		</form>
	</div>

	<a href="javascript:;" class="technical-details" onclick="this.nextElementSibling.classList.toggle('default-hidden');"><?php esc_html_e( 'Technical details for Administrators &raquo;', 'safetynet' ); ?></a>
	<aside class="default-hidden">
		<p><?php printf( esc_html__( 'To acknowledge changes or implement limits, define one of the following constants in %s:', 'safetynet' ), '<code>wp-config.php</code>' ); ?></p>
		<?php printf( '<code class="constants">define( \'BSN_ACKNOWLEDGE_CHANGES\', \'%1$s\' );</code>', get_site_details_hash() ); ?>
		<p><?php esc_html_e( 'or', 'safetynet' ); ?></p>
		<?php printf( '<code class="constants">define( \'BSN_IMPLEMENT_LIMITS\', \'%1$s\' );</code>', get_stored_site_details_hash() ); ?>
	</aside>
<?php
require_once __DIR__ . '/partial/tmpl-footer.php';
