<?php

include( 'templates/header.php' );

if( isset($_POST['product_id']) )
{
    $_cart->removeProduct( $_POST['product_id'] );

    Util::setNotification( 'success', 'This item has been successfully removed from your cart.' );

    header( 'Location: /cart.php' );
    exit();
}

$t_product = Product::getProductList();

?>

<div id="page-content" class="page-cart col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>My cart</h3>
        </div>
    </div>
    <?php if( $_cart->getTotalItem() ) { ?>
    <div class="total-amount row">
        <div class="col-sm-2 form-group mb-2">
            <label class="sr-only">Total amount</label>
            <input type="text" readonly class="form-control-plaintext"  value="Total amount" />
        </div>
        <div class="col-sm-1 form-group mx-sm-1 mb-2">
        <label class="sr-only">Total amount</label>
            <input type="text" readonly class="form-control-plaintext"  value="<?php echo $_cart->getTotalAmount(); ?>$" />
        </div>
        <div class="col-sm-2">
            <a href="/checkout.php" class="btn btn-success" role="button">Checkout</a>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-12">
            <?php if( !$_cart->getTotalItem() ) { ?>
                Your cart is empty.
            <?php } else { ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $_cart->getCart() as $o ) {
                            $id = $o->getProductId();
                        ?>
                        <tr>
                            <td><?php echo ucfirst($t_product[$id]->getName()); ?></td>
                            <td class="text-center"><?php echo $o->getUnitPrice(); ?>$</td>
                            <td class="text-center"><?php echo $o->getQuantity(); ?></td>
                            <td class="text-center"><?php echo $o->getTotalPrice(); ?>$</td>
                            <td>
                                <form action="/cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>" />
                                    <button type="submit" class="btn btn-warning">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
    <?php if( $_cart->getTotalItem() ) { ?>
        <div class="total-amount row">
        <div class="col-sm-2 form-group mb-2">
            <label class="sr-only">Total amount</label>
            <input type="text" readonly class="form-control-plaintext"  value="Total amount" />
        </div>
        <div class="col-sm-1 form-group mx-sm-1 mb-2">
        <label class="sr-only">Total amount</label>
            <input type="text" readonly class="form-control-plaintext"  value="<?php echo $_cart->getTotalAmount(); ?>$" />
        </div>
        <div class="col-sm-2">
            <a href="/checkout.php" class="btn btn-success" role="button">Checkout</a>
        </div>
    </div>
    <?php } ?>
</div>

<?php

include( 'templates/footer.php' );

?>