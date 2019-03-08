
                <div id="menu" class="col-sm-2">
                    <?php include( 'templates/menu.php' ); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-10"></div>
            <div class="col-sm-2">
                <div id="copyright">
                    &copy; gwen001 - <?php echo date('Y'); ?>
                </div>
            </div>
        </div>
        </div>
        <script src="/static/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                window.setTimeout(() => {
                    $('#alert-container').fadeOut();
                }, 2000);
            });
        </script>
    </body>

</html>
