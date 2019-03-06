<?php

include( 'templates/header.php' );

if( !$_cart->getTotalItem() ) { 
    header( 'Location: /index.php' );
    exit();
}

if( !$_user ) {
    header( 'Location: /login.php' );
    exit();
}

$f_error = [];
$f_name = $_user->getName();
$f_address = $_user->getAddress();
$f_zipcode = $_user->getZipcode();
$f_country = $_user->getCountry();
$f_card_number = $f_card_expiration = $f_card_cvv = null;

if( isset($_GET['confirm']) )
{
    if( !isset($_POST['name']) || ($f_name=trim($_POST['name']))=='' ) {
        $f_error['name'] = 'you need to enter a name';
    }
    if( !isset($_POST['address']) || ($f_address=trim($_POST['address']))=='' ) {
        $f_error['address'] = 'you need to enter a address';
    }
    if( !isset($_POST['zipcode']) || ($f_zipcode=trim($_POST['zipcode']))=='' ) {
        $f_error['zipcode'] = 'you need to enter a zipcode';
    }
    if( !isset($_POST['country']) || ($f_country=trim($_POST['country']))=='' ) {
        $f_error['country'] = 'you need to enter a country';
    }
    if( !isset($_POST['card_number']) || ($f_card_number=trim($_POST['card_number']))=='' ) {
        $f_error['card_number'] = 'you need to enter a card number';
    }
    if( !isset($_POST['card_expiration']) || ($f_card_expiration=trim($_POST['card_expiration']))=='' ) {
        $f_error['card_expiration'] = 'you need to enter an expiration date';
    }
    if( !isset($_POST['card_cvv']) || ($f_card_cvv=trim($_POST['card_cvv']))=='' ) {
        $f_error['card_cvv'] = 'you need to enter a cvv';
    }

    if( !count($f_error) )
    {
        $order= new Order();
        $order->setUserId( $_user->getId() );
        $order->setName( $f_name );
        $order->setAddress( $f_address );
        $order->setZipcode( $f_zipcode );
        $order->setCountry( $f_country );
        $order->setCardNumber( $f_card_number );
        $order->setCardExpiration( $f_card_expiration );
        $order->setCardCvv( $f_card_cvv );
        $order->setAmount( $_cart->getTotalAmount() );
        $order->setCart( $_cart->getCart() );

        if( $order->save() ) {
            $_cart->flush();
            Util::setNotification( 'success', 'Your order has been successfully submitted.' );
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }

        header( 'Location: /index.php' );
        exit();
    }
}


?>

<div id="page-content" class="page-checkout col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>Checkout</h3>
        </div>
    </div>
    <form action="?confirm" method="post" <?php if( count($f_error) ) {?> class="was-validated" <?php } ?>>
        <div class="total-amount row">
            <div class="col-sm-2 form-group mb-2">
                <label class="sr-only">Total amount</label>
                <input type="text" readonly class="form-control-plaintext"  value="Total amount">
            </div>
            <div class="col-sm-1 form-group mx-sm-1 mb-2">
            <label class="sr-only">Total amount</label>
                <input type="text" readonly class="form-control-plaintext"  value="<?php echo $_cart->getTotalAmount(); ?>$">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success mb-2">Confirm</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                    <div class="form-group">
                        <label >Name</label>
                        <input type="text" name="name" value="<?php if( !isset($f_error['name']) ) { echo $f_name; } ?>" class="form-control" required="required">
                        <?php if( isset($f_error['name']) ) { ?><div class="invalid-feedback"><?php echo $f_error['name']; ?></div><?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php if( !isset($f_error['address']) ) { echo $f_address; } ?>" class="form-control" required="required">
                        <?php if( isset($f_error['address']) ) { ?><div class="invalid-feedback"><?php echo $f_error['address']; ?></div><?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Zipcode</label>
                        <input type="text" name="zipcode" value="<?php if( !isset($f_error['zipcode']) ) { echo $f_zipcode; } ?>" class="form-control" required="required">
                        <?php if( isset($f_error['zipcode']) ) { ?><div class="invalid-feedback"><?php echo $f_error['zipcode']; ?></div><?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="country" value="<?php if( !isset($f_error['country']) ) { echo $f_country; } ?>" class="form-control" required="required">
                        <?php if( isset($f_error['country']) ) { ?><div class="invalid-feedback"><?php echo $f_error['country']; ?></div><?php } ?>
                    </div>
            </div>
            <div class="col-sm-1">&nbsp;</div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label>Credit card</label>
                    <input type="text" name="card_number" value="<?php if( !isset($f_error['card_number']) ) { echo $f_card_number; } ?>" class="form-control" required="required" placeholder="1234123412341234" maxlength="16">
                    <?php if( isset($f_error['card_number']) ) { ?><div class="invalid-feedback"><?php echo $f_error['card_number']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Expiration</label>
                    <input type="text" name="card_expiration" value="<?php if( !isset($f_error['card_expiration']) ) { echo $f_card_expiration; } ?>" class="form-control" required="required" placeholder="09/19" maxlength="5">
                    <?php if( isset($l_error['card_expiration']) ) { ?><div class="invalid-feedback"><?php echo $l_error['card_expiration']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" name="card_cvv" value="<?php if( !isset($f_error['card_cvv']) ) { echo $f_card_cvv; } ?>" class="form-control" required="required" placeholder="123" maxlength="3">
                    <?php if( isset($l_error['card_cvv']) ) { ?><div class="invalid-feedback"><?php echo $l_error['card_cvv']; ?></div><?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-11 text-right">
                <button type="submit" class="btn btn-success">Confirm</button>
            </div>
        </div>
    </form>
</div>

<?php

include( 'templates/footer.php' );

?>
