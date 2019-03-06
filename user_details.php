<?php

include( 'templates/header.php' );

if( !isset($_GET['id']) ) {
    header( 'Location: /404.php' );
    exit();
}

$o = User::getUser( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php' );
    exit();
}

?>

<div id="page-content" class="page-user-details col-sm-10">
    <div class="row">
        <div class="col-sm-12">
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
</div>

<?php

include( 'templates/footer.php' );

?>