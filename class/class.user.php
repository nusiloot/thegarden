<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

class User
{
    private $id;

    public function getId() {
        return $this->id;
    }
    public function setId( $v ) {
        $this->id = $v;
        return true;
    }


    private $name;

    public function getName() {
        return $this->name;
    }
    public function setName( $v ) {
        $this->name = $v;
        return true;
    }


    private $email;

    public function getEmail() {
        return $this->email;
    }
    public function setEmail( $v ) {
        $this->email = $v;
        return true;
    }


    private $password;

    public function getPassword() {
        return $this->password;
    }
    public function setPassword( $v ) {
        $this->password = $v;
        return true;
    }


    private $address;

    public function getAddress() {
        return $this->address;
    }
    public function setAddress( $v ) {
        $this->address = $v;
        return true;
    }



    private $zipcode;

    public function getZipcode() {
        return $this->zipcode;
    }
    public function setZipcode( $v ) {
        $this->zipcode = $v;
        return true;
    }



    private $country;

    public function getCountry() {
        return $this->country;
    }
    public function setCountry( $v ) {
        $this->country = $v;
        return true;
    }


    private $is_admin = 0;

    public function getIsAdmin() {
        return $this->is_admin;
    }
    public function setIsAdmin( $v ) {
        $this->is_admin = $v;
        return true;
    }


    private $created_at;

    public function getCreatedAt() {
        return $this->created_at;
    }
    public function setCreatedAt( $v ) {
        $this->created_at = $v;
        return true;
    }


    public static function getUser( $id )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM user WHERE id='".$id."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object(__CLASS__);
    }


    public static function checkUser( $email )
    {
        $db = Database::getInstance()->getConnection();
        
        $q = "SELECT COUNT(*) FROM user WHERE email='".$email."'";
        if( ($u=User::getCurrentUserId()) ) {
            $q .= " AND id!='".$u."'";
        }
        
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        return $r->fetch_row()[0];
    }


    public static function checkUser2( $email )
    {
        $db = Database::getInstance()->getConnection();
        
        $q = "SELECT * FROM user WHERE email='".$email."'";
        if( ($u=User::getCurrentUserId()) ) {
            $q .= " AND user_id!='".$u."'";
        }
        
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object( __CLASS__ );
    }


    public static function login( $email, $password )
    {
        $db = Database::getInstance()->getConnection();
        
        $q = "SELECT * FROM user WHERE email LIKE '".$email."' AND password LIKE '".md5($password)."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object( __CLASS__ );
    }


    public static function logout()
    {
        unset( $_SESSION['user_id'] );
    }


    public static function getCurrentUserId()
    {
        if( isset($_SESSION['user_id']) ) {
            return $_SESSION['user_id'];
        } else {
            return false;
        }
        $_SESSION['user_id'] = $user_id;
    }
    public static function getCurrentUser()
    {
        if( !isset($_SESSION['user_id']) || !$_SESSION['user_id'] ) {
            return false;
        }

        $db = Database::getInstance()->getConnection();
        
        $q = "SELECT * FROM user WHERE id='".$_SESSION['user_id']."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object( __CLASS__ );
    }
    public static function setCurrentUserId( $user_id )
    {
        $_SESSION['user_id'] = $user_id;
        return true;
    }


    public function save()
    {
        $db = Database::getInstance()->getConnection();

        $q = "INSERT INTO user (name,email,password,address,zipcode,country,is_admin) VALUES (
            '".$this->name."',
            '".$this->email."',
            '".md5($this->password)."',
            '".$this->address."',
            '".$this->zipcode."',
            '".$this->country."',
            '".$this->is_admin."'
        )";
        
        return $db->query( $q );
    }


    public function updateInfos()
    {
        $db = Database::getInstance()->getConnection();

        $q = "UPDATE
                    user
                SET
                    email='".$this->email."',
                    name='".$this->name."',
                    address='".$this->address."',
                    zipcode='".$this->zipcode."',
                    country='".$this->country."'
                WHERE id='".$this->id."'";
        
        return $db->query( $q );
    }


    public function updatePassword()
    {
        $db = Database::getInstance()->getConnection();

        $q = "UPDATE
                    user
                SET
                    password='".md5($this->password)."'
                WHERE id='".$this->id."'";

        return $db->query( $q );
    }


    public function delete()
    {
        $db = Database::getInstance()->getConnection();

        if( !Order::deleteUserOrders($this->id) ) {
            return false;
        }

        $q = "DELETE FROM user WHERE id='".$this->id."'";

        return $db->query( $q );
    }


    public static function getUserList( $offset=null, $limit=null )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM user ORDER by created_at DESC";
        if( !is_null($offset) && !is_null($limit) ) {
            $q .= " LIMIT ".$offset.",".$limit;
        }
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        $t = [];
        while( ($o=$r->fetch_object(__CLASS__)) ) {
            $t[ $o->getId() ] = $o;
        }

        return $t;
    }


    public static function getTotalUser()
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT COUNT(*) FROM user";
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        return $r->fetch_row()[0];
    }
}
