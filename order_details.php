<?php

include( 'header.php' );

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php' );
    exit();
}

$o = Order::getOrder( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php' );
    exit();
}

$c = unserialize( $o->getCart() );
$t_product = Product::getProductList();

?>

<div id="page-content" class="page-order-details col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>Order details #<?php echo $o->getId(); ?></h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-8 bordered">
            <div class="row form-group bbordered">
                <div class="col-sm-5">
                    Date:
                </div>
                <div class="col-sm-6">
                    <?php echo $o->getCreatedAt(); ?>
                </div>
            </div>
            <div class="row form-group bbordered">
                <div class="col-sm-5">
                    Name:
                </div>
                <div class="col-sm-6">
                    <?php echo $o->getName(); ?>
                </div>
            </div>
            <div class="row form-group bbordered">
                <div class="col-sm-5">
                    Address:
                </div>
                <div class="col-sm-6">
                    <?php echo $o->getAddress(); ?><br />
                    <?php echo $o->getZipcode(); ?><br />
                    <?php echo $o->getCountry(); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-5">
                    Credit card:
                </div>
                <div class="col-sm-6">
                <?php echo $o->getCardNumber(); ?><br />
                <?php echo $o->getCardExpiration(); ?><br />
                <?php echo $o->getCardCvv(); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row form-group">
                <div class="col-sm-6">
                    <?php if( !is_array($c) || !count($c) ) { ?>
                        -
                    <?php } else { ?>
                        Product list:
                        <br /><br />
                        <table class="table-sm table-responsive-sm">
                            <?php foreach( $c as $i ) {
                                $id = $i->getProductId();
                            ?>
                                <tr>
                                    <td><?php echo ucfirst($t_product[$id]->getName()); ?></td>
                                    <td width="20" class="text-center">*</td>
                                    <td><?php echo $i->getQuantity(); ?></td>
                                    <td width="20" class="text-center">=</td>
                                    <td class="text-right"><?php echo $i->getTotalPrice(); ?>$</td>
                                </tr>
                        <?php } ?>
                                <tr class="sum-total">
                                    <td class="text-right" colspan="3">Total</td>
                                    <td>=</td>
                                    <td><?php echo $o->getAmount(); ?>$</td>
                                </tr>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include( 'footer.php' );

?>