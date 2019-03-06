<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

class Order
{
    private $id;

    public function getId() {
        return $this->id;
    }
    public function setId( $v ) {
        $this->id = $v;
        return true;
    }


    private $user_id;

    public function getUserId() {
        return $this->user_id;
    }
    public function setUserId( $v ) {
        $this->user_id = $v;
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


    private $card_number;

    public function getCardNumber() {
        return $this->card_number;
    }
    public function setCardNumber( $v ) {
        $this->card_number = $v;
        return true;
    }


    private $card_expiration;

    public function getCardExpiration() {
        return $this->card_expiration;
    }
    public function setCardExpiration( $v ) {
        $this->card_expiration = $v;
        return true;
    }


    private $card_cvv;

    public function getCardCvv() {
        return $this->card_cvv;
    }
    public function setCardCvv( $v ) {
        $this->card_cvv = $v;
        return true;
    }


    private $amount;

    public function getAmount() {
        return $this->amount;
    }
    public function setAmount( $v ) {
        $this->amount = $v;
        return true;
    }


    private $cart;

    public function getCart() {
        return $this->cart;
    }
    public function setCart( $v ) {
        $this->cart = $v;
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


    public function save()
    {
        $db = Database::getInstance()->getConnection();

        $q = "INSERT INTO `order` (user_id,name,address,zipcode,country,card_number,card_expiration,card_cvv,amount,cart) VALUES (
            '".$this->user_id."',
            '".$this->name."',
            '".$this->address."',
            '".$this->zipcode."',
            '".$this->country."',
            '".$this->card_number."',
            '".$this->card_expiration."',
            '".$this->card_cvv."',
            '".$this->amount."',
            '".serialize($this->cart)."'
        )";
        
        return $db->query( $q );
    }


    public static function getOrder( $id )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM `order` WHERE id='".$id."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object( __CLASS__ );
    }

    
    public static function getOrderList( $user_id=null )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM `order`";
        if( $user_id ) {
            $q .= " WHERE user_id='".$user_id."'";
        }
        $q .= " ORDER by created_at DESC";
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


    public static function getTotalOrder( $user_id=null )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT COUNT(*) FROM `order`";
        if( $user_id ) {
            $q .= " WHERE user_id='".$user_id."'";
        }
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        return $r->fetch_row()[0];
    }
}
