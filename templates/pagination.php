<div class="row">
    <div class="col-sm-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm justify-content-center">
                <li class="page-item <?php if( $page == 1 ) { ?>disabled<?php } ?>">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?p=<?php echo $page-1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for( $i=1 ; $i<=$n_page ; $i++ ) { ?>
                <li class="page-item <?php if( $i == $page ) { ?>disabled<?php } ?>"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item <?php if( $page == $n_page ) { ?>disabled<?php } ?>">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?p=<?php echo $page+1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
