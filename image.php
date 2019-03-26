<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

include( 'config.php' );

if( !isset($_GET['f']) ) {
    exit();
}

$f = $_config['PRODUCT_PATH'].'/'.$_GET['f'];

if( !is_file($f) ) {
    exit();
}

echo file_get_contents( $f );
exit();

?>