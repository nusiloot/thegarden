<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

include( 'templates/header.php' );

if( isset($_GET['logout']) )
{
    User::logout();
    header( 'Location: /' );
    exit();
}

if( $_user ) {
    header( 'Location: /profile.php' );
    exit();
}

$r_error = [];
$r_name = $r_email = $r_password = $r_confirm = null;

$l_error = [];
$l_email = $l_password  = null;

if( isset($_GET['register']) )
{
    if( !isset($_POST['name']) || ($r_name=trim($_POST['name']))=='' ) {
        $r_error['name'] = 'you need to enter a name';
    }
    if( !isset($_POST['email']) || ($r_email=trim($_POST['email']))=='' ) {
        $r_error['email'] = 'you need to enter a valid email';
    } elseif( User::checkUser( $r_email ) ) {
        $r_error['email'] = 'an account already exist with this email';
    }
    if( !isset($_POST['password']) || ($r_password=trim($_POST['password']))=='' ) {
        $r_error['password'] = 'you need to enter a password';
    }
    if( !isset($_POST['confirm']) || ($r_confirm=trim($_POST['confirm']))=='' ) {
        $r_error['confirm'] = 'you need to enter a confirmation';
    } elseif( $r_confirm != $r_password ) {
        $r_error['confirm'] = 'confirmation should match the password';
    }

    if( !count($r_error) )
    {
        $user = new User();
        $user->setName( $r_name );
        $user->setEmail( $r_email );
        $user->setPassword( $r_password );

        if( $user->save() ) {
            Util::setNotification( 'success', 'Your account has been successfully created.' );
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }

        $l = '/login.php?email='.$r_email;
        if( isset($_POST['r']) ) {
            $l .= '&r='.$_POST['r'];
        }

        header( 'Location: '.$l );
        exit();
    }
}
elseif( isset($_GET['login']) )
{
    if( !isset($_POST['email']) || ($l_email=trim($_POST['email']))=='' ) {
        $l_error['email'] = 'you need to enter a valid email';
    }
    if( !isset($_POST['password']) || ($l_password=trim($_POST['password']))=='' ) {
        $l_error['password'] = 'you need to enter a password';
    }

    if( !count($l_error) )
    {
        $u = USer::checkUser2( $l_email );
        
        if( !$u ) {
            $l_error['email'] = 'email not found';
        }
        else {
            if( md5($l_password) == $u->getPassword() ) {
                User::setCurrentUserId( $u->getId() );
                if( isset($_POST['r']) ) {
                    header( 'Location: '.$_POST['r'] );
                } else {
                    header( 'Location: /' );
                }
                exit(); 
            }
            else {
                $l_error['password'] = 'wrong password';      
            }
        }
    }
}
elseif( isset($_GET['email']) )
{
    $l_email = $_GET['email'];
}

?>

<div id="page-content" class="page-login col-sm-10">
    <div class="row">
        <div class="col-sm-5">
            <h3>Register</h3>
        </div>
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-5">
            <h3>Login</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <form action="?register" method="post" <?php if( count($r_error) ) {?> class="was-validated" <?php } ?>>
                <?php if( isset($_GET['r']) ) { ?><input type="hidden" name="r" value="<?php echo $_GET['r']; ?>" /><?php } ?>
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="name" value="<?php if( !isset($r_error['name']) ) { echo $r_name; } ?>" class="form-control" required="required" />
                    <?php if( isset($r_error['name']) ) { ?><div class="invalid-feedback"><?php echo $r_error['name']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" value="<?php if( !isset($r_error['email']) ) { echo $r_email; } ?>" class="form-control" required="required" />
                    <?php if( isset($r_error['email']) ) { ?><div class="invalid-feedback"><?php echo $r_error['email']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" value="<?php if( !isset($r_error['password']) ) { echo $r_password; } ?>" class="form-control" required="required" />
                    <?php if( isset($r_error['password']) ) { ?><div class="invalid-feedback"><?php echo $r_error['password']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Confirm</label>
                    <input type="password" name="confirm" value="<?php if( !isset($r_error['confirm']) ) { echo $r_confirm; } ?>" class="form-control" required="required" />
                    <?php if( isset($r_error['confirm']) ) { ?><div class="invalid-feedback"><?php echo $r_error['confirm']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-5">
            <form action="?login" method="post" <?php if( count($l_error) ) {?> class="was-validated" <?php } ?>>
                <?php if( isset($_GET['r']) ) { ?><input type="hidden" name="r" value="<?php echo $_GET['r']; ?>" /><?php } ?>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" value="<?php if( !isset($l_error['email']) ) { echo $l_email; } ?>" class="form-control" required="required" />
                    <?php if( isset($l_error['email']) ) { ?><div class="invalid-feedback"><?php echo $l_error['email']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" value="" class="form-control" required="required" />
                    <?php if( isset($l_error['password']) ) { ?><div class="invalid-feedback"><?php echo $l_error['password']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

<?php

include( 'templates/footer.php' );

?>
