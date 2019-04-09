<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 * - gwen -
 */

include( 'templates/header.php' );

if( !$_user || !$_user->getIsAdmin() ) {
    header( 'Location: /404.php', 404 );
    exit();
}

$f_error = [];
$f_name = $f_descr = $f_price = $f_image = null;

if( isset($_GET['create']) )
{
    if( !isset($_POST['name']) || ($f_name=trim($_POST['name']))=='' ) {
        $f_error['name'] = 'you need to enter a name';
    }
    if( !isset($_POST['descr']) || ($f_descr=trim($_POST['descr']))=='' ) {
        $f_error['descr'] = 'you need to enter a description';
    }
    if( !isset($_POST['price']) || ($f_price=trim($_POST['price']))=='' ) {
        $f_error['price'] = 'you need to enter a price';
    }
    if( !isset($_FILES['image']) || !$_FILES['image']['size'] ) {
        $f_error['image'] = 'you need to choose an image';
    }

    if( !count($f_error) )
    {
        $f_image = Util::generateFilename( $f_name, Util::getFileExtension($_FILES['image']['name']) );
        $i_dest = $_config['PRODUCT_PATH'].'/'.$f_image;
        
        $product = new Product();
        $product->setName( $f_name );
        $product->setDescr( $f_descr );
        $product->setPrice( $f_price );
        $product->setImage( $f_image );
        
        if( $product->update() ) {
            $c = copy( $_FILES['image']['tmp_name'], $i_dest );
            if( $c ) {
                Util::setNotification( 'success', 'The product has been successfully created.' );
            } else {
                Util::setNotification( 'danger', 'An error occured.' );
            }
        } else {
            Util::setNotification( 'danger', 'An error occured.' );
        }

        header( 'Location: /' );
        exit();
    }
}

?>

<div id="page-content" class="page-product-new col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <h3>New product</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <form action="?create" method="post" enctype="multipart/form-data" <?php if( count($f_error) ) {?> class="was-validated" <?php } ?>>
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
                    <input type="file" name="image" class="custom-file-input" required="required" />
                    <?php if( isset($f_error['image']) ) { ?><div class="invalid-feedback"><?php echo $f_error['image']; ?></div><?php } ?>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>

<?php

include( 'templates/footer.php' );

?>