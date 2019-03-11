<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

mysqli_report( MYSQLI_REPORT_ALL & ~MYSQLI_REPORT_INDEX );

function __autoload( $c ) {
	$f = __DIR__.'/class/class.'.strtolower($c).'.php';
	if( is_file($f) ) {
		require_once( __DIR__.'/class/class.'.strtolower($c).'.php' );
	}
}

$_config['DB_HOST'] = 'localhost';
$_config['DB_BASE'] = 'thegarden';
$_config['DB_USER'] = 'test';
$_config['DB_PASS'] = 'test';

$_config['APP_PATH'] = __DIR__;
$_config['TEMPLATE_PATH'] = $_config['APP_PATH'].'/templates';
$_config['PRODUCT_PATH'] = $_config['APP_PATH'].'/products';

$_config['PRODUCTS_LIMIT'] = 9;
$_config['ORDERS_LIMIT'] = 10;
$_config['USERS_LIMIT'] = 10;
