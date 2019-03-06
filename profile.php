<?php

include( 'header.php' );


if( !$_user ) {
    header( 'Location: /login.php' );
    exit();
}

$r_error = [];
$r_email = $_user->getEmail();
$r_name = $_user->getName();
$r_address = $_user->getAddress();
$r_zipcode = $_user->getZipcode();
$r_country = $_user->getCountry();

if( isset($_GET['updateinfos']) )
{
    if( !isset($_POST['email']) || ($r_email=trim($_POST['email']))=='' ) {
        $r_error['email'] = 'you need to enter a valid email';
    } elseif( User::checkUser( $r_email ) ) {
        $r_error['email'] = 'an account already exist with this email';
    }
    if( !isset($_POST['name']) || ($r_name=trim($_POST['name']))=='' ) {
        $r_error['name'] = 'you need to enter a name';
    }
    if( !isset($_POST['address']) || ($r_address=trim($_POST['address']))=='' ) {
        $r_error['address'] = 'you need to enter a address';
    }
    if( !isset($_POST['zipcode']) || ($r_zipcode=trim($_POST['zipcode']))=='' ) {
        $r_error['zipcode'] = 'you need to enter a zipcode';
    }
    if( !isset($_POST['country']) || ($r_country=trim($_POST['country']))=='' ) {
        $r_error['country'] = 'you need to enter a country';
    }

    if( !count($r_error) )
    {
        $_user->setEmail( $r_email );
        $_user->setName( $r_name );
        $_user->setAddress( $r_address );
        $_user->setZipcode( $r_zipcode );
        $_user->setCountry( $r_country );
        
        if( $_user->updateInfos() ) {
            Util::setNotification( 'success', 'Your profile has been successfully updated.' );
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }

        header( 'Location: /profile.php' );
        exit();
    }
}

$l_error = [];
$l_password  = null;

if( isset($_GET['updatepassword']) )
{   
    if( !isset($_POST['password']) || ($l_password=trim($_POST['password']))=='' ) {
        $l_error['password'] = 'you need to enter a password';
    }
    if( !isset($_POST['confirm']) || ($l_confirm=trim($_POST['confirm']))=='' ) {
        $l_error['confirm'] = 'you need to enter a confirmation';
    } elseif( $l_confirm != $l_password ) {
        $l_error['confirm'] = 'confirmation should match the password';
    }

    if( !count($l_error) )
    {
        $_user->setPassword( $l_password );

        if( $_user->updatePassword() ) {
            Util::setNotification( 'success', 'Your profile has been successfully updated.' );
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }
        
        header( 'Location: /profile.php' );
        exit();
    }
}

?>

<div id="page-content" class="page-profile col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>My profile</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <form action="?updateinfos" method="post" <?php if( count($r_error) ) {?> class="was-validated" <?php } ?>>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" value="<?php if( !isset($r_error['email']) ) { echo $r_email; } ?>" class="form-control" required="required">
                    <?php if( isset($r_error['email']) ) { ?><div class="invalid-feedback"><?php echo $r_error['email']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="name" value="<?php if( !isset($r_error['name']) ) { echo $r_name; } ?>" class="form-control" required="required">
                    <?php if( isset($r_error['name']) ) { ?><div class="invalid-feedback"><?php echo $r_error['name']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php if( !isset($r_error['address']) ) { echo $r_address; } ?>" class="form-control" required="required">
                    <?php if( isset($r_error['address']) ) { ?><div class="invalid-feedback"><?php echo $r_error['address']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Zipcode</label>
                    <input type="text" name="zipcode" value="<?php if( !isset($r_error['zipcode']) ) { echo $r_zipcode; } ?>" class="form-control" required="required">
                    <?php if( isset($r_error['zipcode']) ) { ?><div class="invalid-feedback"><?php echo $r_error['zipcode']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="<?php if( !isset($r_error['country']) ) { echo $r_country; } ?>" class="form-control" required="required">
                    <?php if( isset($r_error['country']) ) { ?><div class="invalid-feedback"><?php echo $r_error['country']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-5">
            <form action="?updatepassword" method="post" <?php if( count($l_error) ) {?> class="was-validated" <?php } ?>>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" value="" class="form-control" required="required">
                    <?php if( isset($l_error['password']) ) { ?><div class="invalid-feedback"><?php echo $l_error['password']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Confirm</label>
                    <input type="text" name="confirm" value="" class="form-control" required="required">
                    <?php if( isset($l_error['confirm']) ) { ?><div class="invalid-feedback"><?php echo $l_error['confirm']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php

include( 'footer.php' );

?>