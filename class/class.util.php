<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

 class Util
{
    public static function getNotification()
    {
        if( !isset($_SESSION['notif']) || !is_array($_SESSION['notif']) ) {
            return false;
        }

        return $_SESSION['notif'];
    }


    public static function setNotification( $type, $text )
    {
        $_SESSION['notif'] = [
            'type' => $type,
            'text' => $text,
        ];
        return true;
    }


    public static function removeNotification()
    {
        unset( $_SESSION['notif'] );
        return true;
    }
}
