                        </div> <!-- /.tab-pane -->

                    </div>  <!-- /.tab-content -->

                </div> <!-- /.tabbable -->

            </div> <!-- /.span10 -->

        </div> <!-- /.row-fluid -->

        <hr>

        <div>
            <?php BaseController::debuggingEcho(); ?>
        </div>

        <footer id="footer-fluid">            
            <p class="pull-right">Monsterfy &copy;<?php echo date('Y'); ?></p>
        </footer>

        </div> <!-- /.container-fluid --> 
    </body>
</html>
<?php 
    ob_end_flush();
?>