<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

class Database
{
	private function __construct() {
    }
    

	private static $instance = null;

    public static function getInstance() {
		if( is_null(self::$instance) ) {
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}
    
    
    public function connect( $host, $user, $pass, $base ) {
        return $this->con = mysqli_connect( $host, $user, $pass, $base );
    }
    public function close( $v ) {
        return mysqli_close( $this->con );
    }

    
    private $con;

    public function getConnection() {
        return $this->con;
    }
    public function setConnection( $v ) {
        $this->con = $v;
        return true;
    }
 }
