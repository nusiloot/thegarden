<?php

include( 'templates/header.php' );

$t_product = Product::getProductList();

?>

<div id="page-content" class="page-products col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <?php if( $_user && $_user->getIsAdmin() ) { ?>
                <div class="admin-action">
                    <a href="/product_new.php" class="btn btn-danger" role="button">Add product</a>
                </div>
            <?php } ?>
            <h3>Products</h3>
        </div>
    </div>
    <div class="row" style="margin-left:0px;">
        <?php
            foreach( $t_product as $o ) {
                include( 'templates/product-card.php' );
        } ?>
    </div>
</div>

<?php

include( 'templates/footer.php' );

?>