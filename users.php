<?php

include( 'templates/header.php' );

if( !$_user ) {
    header( 'Location: /404.php' );
    exit();
}

$t_user = User::getUserList();

?>

<div id="page-content" class="page-users col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>All users</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if( !Order::getTotalOrder($_user->getId()) ) { ?>
                No order yet.
            <?php } else { ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-center">Date</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $t_user as $o ) { ?>
                        <tr>
                            <td class="text-center"><?php echo $o->getId(); ?></td>
                            <td><?php echo $o->getName(); ?></td>
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
</div>

<?php

include( 'templates/footer.php' );

?>