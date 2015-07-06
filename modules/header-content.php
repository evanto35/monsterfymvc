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
                    foreach ($PageContent->menu as $tab): ?>
                        <li class="<?php echo $tab->active ? 'active' : ''; ?> list-tab">
                            <a href="#" data-action="<?php echo $tab->action; ?>" data-module="<?php echo $tab->module; ?>" class="call-action" data-toggle="tab">
                                <?php echo $tab->title; ?>
                            </a>
                        </li>
                    <?php 
                    endforeach; ?>
                </ul>                       
                <div class="tab-content" style="overflow: visible">
                    <div class="tab-pane active" id="main-panel"> 