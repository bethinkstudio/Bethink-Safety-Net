<?php
/**
 * Header of template displayed when site details have changed.
 */

namespace Bethink\SafetyNet;

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
			background: #f1f1f1;
            padding: 0 20px;
		}
		body {
			background: #fff;
			border: 1px solid #ccd0d4;
			color: #444;
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			max-width: 1000px;
			-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
			box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
		}
		h1 {
			border-bottom: 1px solid #dadada;
			clear: both;
			color: #d9534f;
			font-size: 24px;
			margin: 30px 0 0 0;
			padding: 0;
			padding-bottom: 7px;
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

        ul.changed-details-list li {
            list-style-type: none;
            display: inline;
            font-weight: 700;
        }
        ul.changed-details-list li::after {
            content: ', ';
        }
        ul.changed-details-list li:last-child::after {
            content: '';
        }
        div.acknowledgement-forms {
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
		div.acknowledgement-forms form {
			margin: 20px auto;
			padding: 1em 2em;
			max-width: 40%;
            display: block;;
            background: #f1f1f1;
            overflow: hidden;

            border: 1px solid #ccd0d4;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
			box-shadow: 0 1px 1px rgba(0, 0, 0, .04);

            transition: background-color 0.3s ease;
		}
        div.acknowledgement-forms form:hover,
        div.acknowledgement-forms form:focus-within {
            background: #e1e1e1;
        }

        div.acknowledgement-forms form label {
            display: block;
            margin-top: 10px;
            font-weight: 700;
        }
        div.acknowledgement-forms form input[type="text"],
        div.acknowledgement-forms form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        div.acknowledgement-forms form input[type="submit"] {
            margin-top: 15px;
            float: right;
            padding: 10px 15px;
            background-color: #0073aa;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        div.acknowledgement-forms form input[type="submit"]:hover {
            background-color: #005177;
        }
        .technical-details {
            display: block;
            margin-top: 20px;
            cursor: pointer;
            color: #0073aa;
            font-size: 0.8em;
        }
        .technical-details + aside {
            margin-top: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            font-size: 0.9em;
        }
        .technical-details + aside code.constants {
            background-color: #eaeaea;
            border: 1px solid #ccc;
            padding: 1em 2em;
            margin: 1em 0;
            display: block;
            font-size: 0.9em;
            font-family: Consolas, Monaco, 'Andale Mono WT', 'Andale Mono', 'DejaVu Sans Mono', 'Bitstream Vera Sans Mono', 'Liberation Mono', 'Nimbus Mono L', Monaco, 'Courier New', Courier, monospace;
        }
        .default-hidden {
            display: none;
        }
	</style>
</head>
<body>
	<h1><?php esc_html_e( 'Warning: Site Details Have Changed', 'safetynet' ); ?></h1>
