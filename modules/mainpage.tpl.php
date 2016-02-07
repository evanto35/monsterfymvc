<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-type" content="text/html;">
        <meta name="og:locale" content="pt_br" />

        <meta name="author" content="Leandro Melão Medeiros - http://about.me/leandro.medeiros">
        <meta name="title" content="Monsterfy MVC - PHP Framework" />
        <meta name="version" content="<?php echo Config::APP_VERSION; ?>" />
        <meta name="package" content="Monsterfy MVC - https://bitbucket.org/leandro_medeiros/monsterfymvc/">
        <meta name="keyword" content="Monsterfy, MVC, PHP, PHP Framework, Leandro Medeiros, Leandro Melão Medeiros" />
        <meta name="description" content="Monsterfy MVC é um Framework para PHP + MySQL desenvolvido por Leandro Medeiros desde 2012.
            Foi pensado para aplicações de pequeno à médio porte. Por padrão o Front-end é criado com o Twitter Bootstrap, porém é possível de forma muito fácil migrar para outro framework Web.
            Este software aberto e distribuído sob GPL 3." />


        <title><?php echo $this->title; ?></title>

        <link rel="icon" type="image/png" href="<?php echo PATH_IMAGE; ?>favicon.png">

        <!-- Bootstrap core CSS -->
        <link href="<?php echo PATH_CSS; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo PATH_CSS; ?>bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo PATH_CSS; ?>bootstrap-theme.css.map">

        <!-- Monsterfy -->
        <link type="text/css" href="<?php echo PATH_CSS; ?>monsterfy.css" rel="stylesheet">


        <!-- JavaScript -->
        <script data-main="<?php echo PATH_JS; ?>main" src="<?php echo PATH_JS; ?>vendor/require.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PATH_PLUGIN; ?>DataTables/datatables.min.css">
    </head>

	<body style="height:100%">
        
        <!-- Navigation bar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <!-- Container -->
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Navegar I/O</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Be sure to leave the brand out there if you want it shown -->
                    <a href="javascript:;" style="padding-right:10px" class="call-action" data-module="<?php echo $this->module; ?>" id="brand-logo" title="Página inicial">
                        <img style="padding-top:10px" src="<?php echo PATH_IMAGE; ?>/logo.png" width="147" height="40" alt="" /> Lite
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">                
                    <ul class="nav navbar-nav">
                        <?php foreach ($this->navigator as $Dto): ?>
                            <?php if ($Dto->menuOrder && $Dto->active): ?>
                                <li class="<?php echo $Dto->name == $this->module ? 'active' : '';  ?>" >    
                                    <a href="../<?php echo strtolower($Dto->name); ?>"><?php echo $Dto->title; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a title="Minha conta" href="#account-modal" role="button" data-toggle="modal" 
                               class="navbar-link pull-right">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <?php echo $this->CurrentUser->name; ?>
                            </a>
                        </li>
                        <li>
                            <form class="navbar-form" method="POST" action="./">
                                <div class="form-group">
                                    <input type="hidden" name="action" value="logout">
                                </div>
                                <button type="submit" class="btn btn-danger">
                                    Sair <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid" id="fluid-content">
            <div class="row-fluid">
                <div id="main-wrapper">
                    <form action="index.php" id="frm-hidden" method="post">
                        <input type="hidden" name="action" id="btn-hidden" />
                        <input type="hidden" name="module" id="module-hidden" />
                    </form>

                    <div id="display-message">
                        <?php Alert::showAll(); ?>
                    </div>

                    <div id="main-panel" style="height:100%; width:100%; padding:5px;">
                        <!-- Conteúdo do Módulo Atual -->
                        <?php include "{$this->module}/content.php"; ?>
                    </div>

                </div> <!-- /.span10 -->

            </div> <!-- /.row-fluid -->
        </div> <!-- /.container-fluid --> 

        <footer id="footer" class="monsterfy-footer">
            <hr>

            <div><?php BaseController::debuggingEcho(); ?></div>

            <div class="pull-right">
                <span>Cortex &copy;2015-<?php echo date('Y'); ?></span>

                <br>
                
                <span><i>Powered by &reg; MonsterfyMVC</i></span>
            </div>
        </footer>
    </body>
</html>
