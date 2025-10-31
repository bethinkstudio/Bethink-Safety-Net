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
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
			background-color: #f9f9f9;
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
		<tfoot>
			<tr>
				<th scope="col"><?php esc_html_e( 'Key', 'safetynet' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Previous Value', 'safetynet' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Current Value', 'safetynet' ); ?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ( $bsn_changes['current'] as $bsn_detail_key => $bsn_values_current ) : ?>
				<tr>
					<th scope="row"><?php echo esc_html( $bsn_detail_key ); ?></th>
					<td><?php echo esc_html( $bsn_changes['previous'][ $bsn_detail_key ] ); ?></td>
					<td><?php echo esc_html( $bsn_values_current ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>
