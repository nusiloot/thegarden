<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

include( 'templates/header.php' );

if( !$_user || !$_user->getIsAdmin() ) {
    header( 'Location: /404.php', 404 );
    exit();
}

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php', 404 );
    exit();
}

$o = Order::getOrder( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php', 404 );
    exit();
}

if( $o->delete() ) {
    Util::setNotification( 'success', 'The order been added successfully deleted.' );
} else {
    Util::setNotification( 'danger', 'An error occured.' );
}

header( 'Location: /orders.php' );
exit();
