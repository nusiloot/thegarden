<?php

/**
 * I don't believe in license
 * You can do what you want with this program
 * - gwen -
 */

class Product
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


    private $descr;

    public function getDescr() {
        return $this->descr;
    }
    public function setDescr( $v ) {
        $this->descr = $v;
        return true;
    }


    private $price;

    public function getPrice() {
        return $this->price;
    }
    public function setPrice( $v ) {
        $this->price = $v;
        return true;
    }


    private $image;

    public function getImage() {
        return $this->image;
    }
    public function setImage( $v ) {
        $this->image = $v;
        return true;
    }


    private $createdAt;

    public function getCreatedAt() {
        return $this->createdAt;
    }
    public function setCreatedAt( $v ) {
        $this->createdAt = $v;
        return true;
    }


    public static function getProduct( $id )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM product WHERE id='".$id."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object('Product');
    }

    
    public static function getProductList()
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM product ORDER by id";
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        $t = [];
        while( ($o=$r->fetch_object('Product')) ) {
            $t[ $o->getId() ] = $o;
        }

        return $t;
    }

    
    public static function getTotalProduct()
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT COUNT(*) FROM product";
        $r = $db->query( $q );
        if( !$r ) {
            return false;
        }

        return $r->fetch_row()[0];
    }
}
