<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

require( __DIR__.'/../config.php' );

$_db = Database::getInstance();
$_db->connect( $_config['DB_HOST'], $_config['DB_USER'], $_config['DB_PASS'], $_config['DB_BASE'] );

session_start();

$_user = User::getCurrentUser();
$_cart = Cart::getInstance();

?>

<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Buy fresh fruits and vegetables from the best garden ever!</title>
        <meta name="description" content="Buy fresh fruits and vegetables from the best garden ever!">
        <meta name="keywords" content="fruits, vegetables, garden">
        <link rel="stylesheet" href="/static/css/bootstrap-4.3.1.min.css">
        <link rel="stylesheet" href="/static/css/thegarden.css">
    </head>
    <body>
        <?php if( ($n=Util::getNotification()) ) { ?>
            <div id="alert-container" class="text-center">
                <div class="alert alert-<?php echo $n['type']; ?> text-center" role="alert">
                    <?php echo $n['text']; ?>
                </div>
            </div>
        <?php 
            Util::removeNotification();
        } ?>
        <div id="header">
            <h1>The garden</h1>
            <h2>fresh fruits and vegetables</h2>
        </div>
        <div id="page-container" class="container">
            <div class="row">
