<div class="card text-center">
    <div class="card-header">
        <?php echo ucfirst($o->getName()); ?>
    </div>
    <div class="card-body">
        <p class="card-text">
            <a href="/product.php?id=<?php echo $o->getId(); ?>"><img src="/products/<?php echo $o->getImage(); ?>" class="card-img-top" alt="<?php echo $o->getName(); ?>" /></a>
        </p>
    </div>
    <div class="card-footer text-muted">
        Price: <?php echo $o->getPrice(); ?>$
    </div>
</div>
