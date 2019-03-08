<?php

include( 'templates/header.php' );

if( !$_user || !$_user->getIsAdmin() ) {
    header( 'Location: /404.php' );
    exit();
}

$f_error = [];

if( isset($_GET['edit']) )
{
    if( !isset($_POST['id']) ) {
        Util::setNotification( 'danger', 'An error occured.' );
        header( 'Location: /404.php' );
        exit();
    }
    
    $product = Product::getProduct( $_POST['id'] );
    if( !$product ) {
        Util::setNotification( 'danger', 'An error occured.' );
        header( 'Location: /404.php' );
        exit();
    }
    
    if( !isset($_POST['name']) || ($f_name=trim($_POST['name']))=='' ) {
        $f_error['name'] = 'you need to enter a name';
    }
    if( !isset($_POST['descr']) || ($f_descr=trim($_POST['descr']))=='' ) {
        $f_error['descr'] = 'you need to enter a description';
    }
    if( !isset($_POST['price']) || ($f_price=trim($_POST['price']))=='' ) {
        $f_error['price'] = 'you need to enter a price';
    }

    if( !count($f_error) )
    {
        $product->setName( $f_name );
        $product->setDescr( $f_descr );
        $product->setPrice( $f_price );
        
        if( $product->update() ) {
            if( isset($_FILES['image']) && $_FILES['image']['size'] ) {
                //$f_image = Util::generateFilename( $f_name, Util::getFileExtension($_FILES['image']['name']) );
                $i_dest = $_config['PRODUCT_PATH'].'/'.$product->getImage();
                $c = copy( $_FILES['image']['tmp_name'], $i_dest );
                if( $c ) {
                    Util::setNotification( 'success', 'The product has been successfully created.' );
                } else {
                    Util::setNotification( 'danger', 'An error occured.' );
                }
            } else {
                Util::setNotification( 'success', 'The product has been successfully created.' );
            }
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }

        header( 'Location: /product.php?id='.$product->getId() );
        exit();
    }

    $_GET['id'] = $_POST['id'];
}


if( !isset($_GET['id']) ) {
    header( 'Location: /404.php' );
    exit();
}

$o = Product::getProduct( $_GET['id'] );
if( !$o ) {
    header( 'Location: /404.php' );
    exit();
}

$f_name = $o->getName();
$f_descr = $o->getDescr();
$f_price = $o->getPrice();
$f_image = null;

?>

<div id="page-content" class="page-product-edit col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <?php if( $_user && $_user->getIsAdmin() ) { ?>
                <div class="admin-action">
                    <a href="/product-delete.php?id=<?php echo $o->getId(); ?>" class="btn btn-dark" role="button">Delete</a>
                </div>
            <?php } ?>
            <h3>Edit product</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <form action="?edit" method="post" enctype="multipart/form-data" <?php if( count($f_error) ) {?> class="was-validated" <?php } ?>>
                <input type="hidden" name="id" value="<?php echo $o->getId(); ?>" />
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="name" value="<?php if( !isset($f_error['name']) ) { echo $f_name; } ?>" class="form-control" required="required" />
                    <?php if( isset($f_error['name']) ) { ?><div class="invalid-feedback"><?php echo $f_error['name']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="descr" rows="3" required="required"><?php if( !isset($f_error['descr']) ) { echo $f_descr; } ?></textarea>
                    <?php if( isset($f_error['descr']) ) { ?><div class="invalid-feedback"><?php echo $f_error['descr']; ?></div><?php } ?>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" name="price" value="<?php if( !isset($f_error['price']) ) { echo $f_price; } ?>" class="form-control" required="required" />
                    </div>
                    <?php if( isset($f_error['price']) ) { ?><div class="invalid-feedback"><?php echo $f_error['price']; ?></div><?php } ?>
                </div>
                <div>
                    <label>Image</label>
                </div>
                <div class="custom-file">
                    <label class="custom-file-label">Choose file...</label>
                    <input type="file" name="image" class="custom-file-input" />
                    <?php if( isset($f_error['image']) ) { ?><div class="invalid-feedback"><?php echo $f_error['image']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <div class="col-sm-6">
            <img src="/image.php?f=<?php echo $o->getImage(); ?>" class="card-img-top" alt="<?php echo $o->getName(); ?>" />
        </div>
    </div>
</div>

<?php

include( 'templates/footer.php' );

?>