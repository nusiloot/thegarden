<?php

include( 'templates/header.php' );

$t_product = Product::getProductList();

?>

<div id="page-content" class="page-products col-sm-10">
    <div class="row">
        <div class="col-sm-12">
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