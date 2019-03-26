<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

class CartItem
{
    private $product_id;

    public function getProductId() {
        return $this->product_id;
    }
    public function setProductId( $v ) {
        $this->product_id = $v;
        return true;
    }


    private $quantity;

    public function getQuantity() {
        return $this->quantity;
    }
    public function setQuantity( $v ) {
        $this->quantity = $v;
        return true;
    }


    private $unit_price;

    public function getUnitPrice() {
        return $this->unit_price;
    }
    public function setUnitPrice( $v ) {
        $this->unit_price = $v;
        return true;
    }



    private $total_price;

    public function getTotalPrice() {
        return $this->total_price;
    }
    public function setTotalPrice( $v ) {
        $this->total_price = $v;
        return true;
    }
}
 