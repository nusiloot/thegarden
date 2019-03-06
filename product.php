<?php

include( 'templates/header.php' );

if( isset($_POST['product_id']) && isset($_POST['quantity']) )
{
    $cart = Cart::getInstance();
    $cart->addProduct( $_POST['product_id'], $_POST['quantity'] );

    Util::setNotification( 'success', 'This item been added successfully to your cart.' );

    header( 'Location: /product.php?id='.$_POST['product_id'] );
    exit();
}

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php' );
    exit();
}

$o = Product::getProduct( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php' );
    exit();
}

?>

<div id="page-content" class="page-product col-sm-10">
    <div class="row">
        <div class="col-sm-6">
            <h3><?php echo ucfirst($o->getName()); ?></h3>
            <p><?php echo $o->getDescr(); ?></p>
            <form action="" method="post">
                <input type="hidden" name="product_id" value="<?php echo $o->getId(); ?>" />
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" value="<?php echo $o->getPrice(); ?>$">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="quantity">
                            <?php for( $i=1 ; $i<=10 ; $i++ ) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <img src="/products/<?php echo $o->getImage(); ?>" class="card-img-top" alt="<?php echo $o->getName(); ?>">
        </div>
    </div>
</div>

<?php

include( 'templates/footer.php' );

?>