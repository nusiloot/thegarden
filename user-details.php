<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

include( 'templates/header.php' );

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php', 404 );
    exit();
}

$o = User::getUser( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php', 404 );
    exit();
}

$t_order = Order::getOrderList( $o->getId() );
$n_order = count( $t_order );

?>

<div id="page-content" class="page-user-details col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <?php if( $_user && $_user->getIsAdmin() ) { ?>
                <div class="admin-action">
                    <a href="/user-delete.php?id=<?php echo $o->getId(); ?>" class="btn btn-dark" role="button">Delete</a>
                </div>
            <?php } ?>
            <h3>User details #<?php echo $o->getId(); ?></h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-8">
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
                    Email:
                </div>
                <div class="col-sm-6">
                    <?php echo $o->getEmail(); ?>
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
                    Is admin:
                </div>
                <div class="col-sm-6">
                    <?php if( $o->getIsAdmin() ) { ?>
                        <span class="is-admin">yes</span>
                    <?php } else { ?>
                        <span class="is-not-admin">no</span>
                    <?php } ?>
                </div>
            </div>
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
                            <th class="text-right">Amount</th>
                            <th class="text-center">Created at</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $t_order as $o ) { ?>
                        <tr>
                            <td class="text-center"><?php echo $o->getId(); ?></td>
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
</div>

<?php

include( 'templates/footer.php' );

?>