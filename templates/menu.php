<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/">Products</a>
        <span class="badge badge-primary badge-pill"><?php echo Product::getTotalProduct(); ?></span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/cart.php">My cart</a>
        <?php if( ($n=$_cart->getTotalItem()) ) { ?><span class="badge badge-primary badge-pill"><?php echo $n; ?></span> <?php } ?>
    </li>
    <?php if( $_user ) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/orders.php">My Orders</a>
    <?php if( ($n=Order::getTotalOrder($_user->getId())) ) { ?><span class="badge badge-primary badge-pill"><?php echo $n; ?></span><?php } ?>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/profile.php">My profile</a>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/login.php?logout">Logout</a>
    </li>
    <?php } else { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/login.php">Register</a>
        <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/login.php">Login</a>
    </li>
    <?php } ?>
</ul>