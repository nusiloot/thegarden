<?php

include( 'templates/header.php' );

if( !$_user ) {
    header( 'Location: /404.php' );
    exit();
}

$n_user = User::getTotalUser();
$limit = $_config['USERS_LIMIT'];
$n_page = ceil( $n_user / $limit );

if( isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $n_page ) {
    $page = $_GET['p'];
} else {
    $page = 1;
}

$offset = $limit * ($page-1);
$t_user = User::getUserList( $offset, $limit );

?>

<div id="page-content" class="page-users col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>All users</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if( !$n_user ) { ?>
                No user yet.
            <?php } else { ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Email</th>
                            <th class="text-center">Orders</th>
                            <th class="text-center">Created at</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $t_user as $o ) { ?>
                        <tr>
                            <td class="text-center"><?php echo $o->getId(); ?></td>
                            <td><?php echo $o->getEmail(); ?></td>
                            <td class="text-center"><?php echo Order::getTotalOrder($o->getId()); ?></td>
                            <td class="text-center"><?php echo date('Y-m-d',strtotime($o->getCreatedAt())); ?></td>
                            <td>
                                <a href="/user_details.php?id=<?php echo $o->getId(); ?>" class="btn btn-warning" role="button">Details</a>
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