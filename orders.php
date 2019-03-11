<?php

include( 'templates/header.php' );

if( !$_user ) {
    header( 'Location: /404.php', 404 );
    exit();
}

if( $_user->getIsAdmin() && isset($_GET['all']) ) {
    $n_order = Order::getTotalOrder();
} else {
    $n_order = Order::getTotalOrder( $_user->getId() );
}

$limit = $_config['ORDERS_LIMIT'];
$n_page = ceil( $n_order / $limit );

if( isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $n_page ) {
    $page = $_GET['p'];
} else {
    $page = 1;
}

$offset = $limit * ($page-1);

if( $_user->getIsAdmin() && isset($_GET['all']) ) {
    $t_order = Order::getOrderList( null, $offset, $limit );
} else {
    $t_order = Order::getOrderList( $_user->getId(), $offset, $limit );
}

$n_order = count( $t_order );

?>

<div id="page-content" class="page-orders col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <?php if( $_user->getIsAdmin() ) { ?>
                <h3>All orders</h3>
            <?php } else { ?>
                <h3>My orders</h3>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if( !$n_order ) { ?>
                No order yet.
            <?php } else { ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-right">Amount</th>
                            <th class="text-center">Created at</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $t_order as $o ) { ?>
                        <tr>
                            <td class="text-center"><?php echo $o->getId(); ?></td>
                            <td><?php echo $o->getName(); ?></td>
                            <td class="text-right"><?php echo $o->getAmount(); ?>$</td>
                            <td class="text-center"><?php echo date('Y-m-d',strtotime($o->getCreatedAt())); ?></td>
                            <td>
                                <a href="/order-details.php?id=<?php echo $o->getId(); ?>" class="btn btn-warning" role="button">Details</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
    <?php include( 'templates/pagination.php' ); ?>
</div>

<?php

include( 'templates/footer.php' );

?>