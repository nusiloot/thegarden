<?php

include( 'templates/header.php' );

if( !$_user || !$_user->getIsAdmin() ) {
    header( 'Location: /404.php' );
    exit();
}

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php' );
    exit();
}

$o = Product::getProduct( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php' );
    exit();
}

if( $o->delete() ) {
    Util::setNotification( 'success', 'The product been added successfully deleted.' );
} else {
    Util::setNotification( 'danger', 'An error occured.' );
}

header( 'Location: /' );
exit();