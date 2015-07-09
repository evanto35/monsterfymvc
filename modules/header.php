<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-type" content="text/html;">
        <meta property="og:locale" content="pt_br" />

        <meta name="author" content="Leandro Melão Medeiros" ref="http://about.me/leandro.medeiros">
        <meta name="title" content="Monsterfy MVC - PHP Framework" />
        <meta name="version" content="<?php echo Config::APP_VERSION; ?>" />
        <meta name="package" content="Monsterfy MVC" ref="https://bitbucket.org/leandro_medeiros/monsterfymvc/">
        <meta name="keyword" content="Monsterfy, MVC, PHP, PHP Framework, Leandro Medeiros, Leandro Melão Medeiros" />
        <meta name="description" content="Monsterfy MVC é um Framework para PHP + MySQL desenvolvido por Leandro Medeiros desde 2012.
            Foi pensado para aplicações de pequeno à médio porte. Por padrão o Front-end é criado com o Twitter Bootstrap, porém é possível de forma muito fácil migrar para outro framework Web.
            Este software aberto e distribuído sob GPL 3." />


        <title><?php echo $View->title; ?></title>

        <link rel="icon" type="image/png" href="<?php echo APP_REMOTE_PATH; ?>/assets/images/favicon.png">

        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo APP_REMOTE_PATH; ?>/assets/js/jquery.min.js"></script>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap-theme.css.map">
        <script src="<?php echo APP_REMOTE_PATH; ?>/assets/js/bootstrap.min.js"></script>

        <!-- Monsterfy CSS -->
        <link type="text/css" href="<?php echo APP_REMOTE_PATH; ?>/assets/css/monsterfy.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo APP_REMOTE_PATH; ?>/plugins/DataTables/media/css/jquery.dataTables.css">

        <!-- jQuery ->
        <script type="text/javascript" charset="utf8" src="<?php echo APP_REMOTE_PATH; ?>/plugins/DataTables/media/js/jquery.js"></script-->

        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="<?php echo APP_REMOTE_PATH; ?>/plugins/DataTables/media/js/jquery.dataTables.js"></script>
    </head>

	<body>
        
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
                    <a href="./" class="navbar-brand" title="Página inicial">
                        <?php echo Config::APP_TITLE; ?>
                        <!--img src="<?php echo APP_REMOTE_PATH; ?>/assets/images/logo.png" width="156" height="40" alt="" /-->
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">                
                    <ul class="nav navbar-nav">
                        <?php foreach ($View->navigator as $Dto): ?>
                            <li class="<?php echo $Dto->name == $View->module ? 'active' : '';  ?>" >    
                                <a href="../<?php echo strtolower($Dto->name); ?>"><?php echo $Dto->title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a title="Minha conta" href="#account-modal" role="button" data-toggle="modal" 
                               class="navbar-link pull-right">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <?php echo $View->CurrentUser; ?>
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