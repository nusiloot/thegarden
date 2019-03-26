<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

class Cart
{
    private function __construct() {
    }
    

	private static $instance = null;

    public static function getInstance() {
		if( is_null(self::$instance) ) {
			$c = __CLASS__;
			self::$instance = new $c();
        }
        if( !isset($_SESSION['cart']) || !is_array($_SESSION['cart']) ) {
            $_SESSION['cart'] = [];
        }
		return self::$instance;
    }
    

    public function getCart()
    {
        return $_SESSION['cart'];
    }


    public function getTotalItem()
    {
        return count($_SESSION['cart']);
    }


    public function getTotalAmount()
    {
        $total = 0;

        foreach( $_SESSION['cart'] as $o ) {
            $total += $o->getTotalPrice();
        }

        return $total;
    }


    public function addProduct( $product_id, $quantity )
    {
        $p = Product::getProduct( $product_id );

        $item = new CartItem();
        $item->setProductId( $product_id );
        $item->setQuantity( $quantity );
        $item->setUnitPrice( $p->getPrice() );
        $item->setTotalPrice( $quantity*$p->getPrice() );

        $_SESSION['cart'][$product_id] = $item;
    }


    public function removeProduct( $product_id )
    {
        unset( $_SESSION['cart'][$product_id] );
    }


    public function flush()
    {
        $_SESSION['cart'] = [];
    }
}
 