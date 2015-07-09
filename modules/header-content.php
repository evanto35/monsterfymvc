<div class="container-fluid" id="fluid-content">
    <div class="row-fluid">
        <div id="main-wrapper">
            <form action="index.php" id="frm" method="post">
                <input type="hidden" name="action" id="btnHidden" />
                <input type="hidden" name="module" id="moduleHidden" />
            </form>

            <?php Alert::showAll(); ?>

            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <?php 
                    foreach ($View->menu as $Tab): ?>
                        <li class="<?php echo $Tab->active ? 'active' : ''; ?> list-Tab">
                            <a href="#" data-action="<?php echo $Tab->action; ?>" data-module="<?php echo $Tab->module; ?>" class="call-action" data-toggle="Tab">
                                <?php echo $Tab->title; ?>
                            </a>
                        </li>
                    <?php 
                    endforeach; ?>
                </ul>                       
                <div class="tab-content" style="overflow: visible">
                    <div class="tab-pane active" id="main-panel">