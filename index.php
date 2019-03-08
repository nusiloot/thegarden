<?php

include( 'templates/header.php' );

$n_product = Product::getTotalProduct();
$limit = $_config['PRODUCTS_LIMIT'];
$n_page = ceil( $n_product / $limit );

if( isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $n_page ) {
    $page = $_GET['p'];
} else {
    $page = 1;
}

$offset = $limit * ($page-1);
$t_product = Product::getProductList( $offset, $limit );

?>

<div id="page-content" class="page-products col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <?php if( $_user && $_user->getIsAdmin() ) { ?>
                <div class="admin-action">
                    <a href="/product-new.php" class="btn btn-danger" role="button">Add product</a>
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
    <?php include( 'templates/pagination.php' ); ?>
</div>

<?php

include( 'templates/footer.php' );

?>