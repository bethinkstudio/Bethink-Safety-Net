<?php
/**
 * Template for displaying detected changed site details.
 *
 * @package Bethink\SafetyNet
 */

namespace Bethink\SafetyNet;

$bsn_changes = have_site_details_changed( true );

header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php esc_html_e( 'Site Details Changed', 'safetynet' ); ?></title>
	<style>
		html {
			padding-left: 20px;
			padding-right: 20px;
		}
		body {
			font-family: Arial, sans-serif;
			margin: 20px auto;
			background-color: #f9f9f9;
			max-width: 1000px;
		}
		h1 {
			color: #d9534f;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}
		thead, tfoot {
			background-color: #f7f7f7;
		}
		th, td {
			border: 1px solid #ddd;
			padding: 8px;
		}
		th {
			background-color: #f2f2f2;
			text-align: left;
		}
		tr.changed {
			background-color: #f8d7da;
		}
		tr.not-changed {
			background-color: #d4edda;
		}
		form {

			margin: 20px auto;
			max-width: 60%;
		}
	</style>
</head>
<body>
	<h1><?php esc_html_e( 'Warning: Site Details Have Changed', 'safetynet' ); ?></h1>
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
	<p><?php esc_html_e( 'If you believe this message is in error, or are not sure what this means, please contact your site administrator.', 'safetynet' ); ?></p>
</body>
</html>
