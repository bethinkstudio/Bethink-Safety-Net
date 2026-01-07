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
	<table>
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Key', 'safetynet' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Previous Value', 'safetynet' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Current Value', 'safetynet' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $bsn_changes['current'] as $bsn_detail_key => $bsn_values_current ) : ?>
				<tr class="<?php echo esc_attr( isset( $bsn_changes['diff'][ $bsn_detail_key ] ) ? 'changed' : 'not-changed' ); ?>">
					<th scope="row"><?php echo esc_html( $bsn_detail_key ); ?></th>
					<td><?php echo esc_html( $bsn_changes['stored'][ $bsn_detail_key ] ); ?></td>
					<td><?php echo esc_html( $bsn_values_current ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="acknowledgement-forms">
		<form method="post">
			<input type="hidden" name="bsn_acknowledge_changes" value="<?php echo esc_attr( get_nonce( 'live' ) ) ?>" />
			<p><?php esc_html_e( 'If this is a production environment, and you want it to continue running as it has previously, please acknowledge the changes below:', 'safetynet' ); ?></p>
			<input type="submit" value="<?php esc_attr_e( 'Acknowledge Changes and Update Stored Details', 'safetynet' ); ?>">
		</form>
		<form method="post">
			<input type="hidden" name="bsn_implement_limits" value="<?php echo esc_attr( get_nonce( 'stored' ) ) ?>" />
			<p><?php esc_html_e( 'If this is a DEVELOPMENT or NON-PRODUCTION environment, and you want to implement lockdown measures accordingly, please indicate changes below:', 'safetynet' ); ?></p>
			<input type="submit" value="<?php esc_attr_e( 'Implement Limits to Environment', 'safetynet' ); ?>">
		</form>
	</div>
<?php
require_once __DIR__ . '/partial/tmpl-footer.php';
