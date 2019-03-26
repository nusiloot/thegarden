<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
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

        $q = "INSERT INTO product (name,descr,price,image) VALUES (
            '".$this->name."',
            '".$this->descr."',
            '".$this->price."',
            '".$this->image."'
        )";
        
        return $db->query( $q );
    }


    public function update()
    {
        $db = Database::getInstance()->getConnection();

        $q = "UPDATE product set 
                    name='".$this->name."'
                    , descr='".$this->descr."'
                    , price='".$this->price."'
                WHERE id='".$this->getId()."'";
        
        return $db->query( $q );
    }


    public function delete()
    {
        $db = Database::getInstance()->getConnection();

        $q = "DELETE FROM product WHERE id='".$this->id."'";
        
        return $db->query( $q );
    }

    
    public static function getProduct( $id )
    {
        $db = Database::getInstance()->getConnection();

        /*$q = "SELECT * FROM product WHERE id=?";
        $stmt = $db->prepare( $q );
        $stmt->bind_param( 'd', $id );
        $stmt->execute();
        $r = $stmt->get_result();
        return $r->fetch_object( __CLASS__ );*/

        $q = "SELECT * FROM product WHERE id='".$id."'";
        $r = $db->query( $q );
        if( !$r || !$r->num_rows ) {
            return false;
        }

        return $r->fetch_object( __CLASS__ );
    }

    
    public static function getProductList( $offset=null, $limit=null )
    {
        $db = Database::getInstance()->getConnection();

        $q = "SELECT * FROM product ORDER by created_at DESC";
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