<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:locale" content="pt_br" />

        <meta name="author" content="Leandro Melão Medeiros" ref="http://about.me/leandro.medeiros">
        <meta name="package" content="Monsterfy MVC" ref="https://bitbucket.org/leandro_medeiros/monsterfymvc/">
        <meta name="title" content="Monsterfy MVC - PHP Framework" />
        <meta name="keyword" content="Monsterfy, MVC, PHP, PHP Framework, Leandro Medeiros, Leandro Melão Medeiros" />
        <meta name="description" content="Monsterfy MVC é um Framework para PHP + MySQL desenvolvido por Leandro Medeiros desde 2012.
            Foi pensado para aplicações de pequeno à médio porte. Por padrão o Front-end é criado com o Twitter Bootstrap, porém é possível de forma muito fácil migrar para outro framework Web.
            Este software aberto e distribuído sob GPL 3." />

        <title><?php echo APP_TITLE; ?> - Login</title>

        <link rel="icon" type="image/png" href="<?php echo APP_REMOTE_PATH; ?>/assets/images/favicon.png">

        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo APP_REMOTE_PATH; ?>/assets/js/jquery.min.js"></script>
        
        <!-- Bootstrap core CSS -->
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/bootstrap-theme.css.map">
        <script src="<?php echo APP_REMOTE_PATH; ?>/assets/js/bootstrap.min.js"></script>
          
        <!-- Custom styles for this template -->
        <link href="<?php echo APP_REMOTE_PATH; ?>/assets/css/login.css" rel="stylesheet">
    </head>

    <body>
        <section id="headline2">
            <div class="container">
                <h1 id="title"><?php echo APP_TITLE; ?></h1>
            </div>
        </section>

        <div class="container">
            <form class="form-signin" id="login" method="post" action="./">
                <h3 class="form-signin-heading">Autenticação</h3>
                <input type="hidden" name="action" value="login" />
                <label for="inputEmail" class="sr-only">Usuário</label>
                <input type="email" name="username" id="inputEmail" class="form-control" placeholder="Endereço de e-mail" required autofocus>
                <label for="inputPassword" class="sr-only">Senha</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Senha" required>
                <button class="btn btn-lg btn-default btn-block" id="btn-signin" type="submit">Entrar</button>
            </form>
        
            <!-- Mensagem de erro no login -->
            <div id="login-msg">
                <?php Alert::showAll(); ?>
            </div>
            <!-- Fim da Mensagem de erro -->
        </div> <!-- /container -->
    </body>
</html>