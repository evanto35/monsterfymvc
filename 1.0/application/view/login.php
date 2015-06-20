<div id="wrap" class="colorskin-0">
    <div id="sticker">
        <header id="header">
            <div  class="container">
                <div class="four columns">
                    <div class="logo">
                        <a href="./">
                            <img src="./assets/images/logo.png" width="200" id="img-logo" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <section id="headline2">
        <div class="container">
            <h3>MedeirosMVC - Framework para PHP</h3>
        </div>
    </section>
    
    <section class="container" >
        <hr class="vertical-space2">
        <article class="ten columns">
            <div class="sub-content">
                <h6 class="h-sub-content">Autenticação</h6>
            </div>
            
            <form name="login-form" action="./" method="POST">
                <div>
                    <input type="hidden" name="action" value="login" />
                    <label>Usuário: </label><input name="username" id="usuario" value="E-mail ou login" type="text" title="E-mail ou CPF" onblur="if(this.value==''){this.value='E-mail ou CPF'}" onfocus="if (this.value=='Informe o nome para login'){this.value=''}" />
                    <label>Senha:</label><input name="password" id="senha" title="Informe a sua senha de acesso" type="password" />
                    <input type="submit" name="submit" value="Acessar" />
                </div>

                <!-- Mensagem de erro no login -->
                <?php
                    if (isset($_SESSION[Controller::IDX_LOGIN_MSG])) {
                        echo "<div id='login-msg'>{$_SESSION[Controller::IDX_LOGIN_MSG]}</div>";
                        unset($_SESSION[Controller::IDX_LOGIN_MSG]);
                    }
                ?>
                <!-- Fim da Mensagem de erro -->
            </form>
        </article>
    </div>
</div>
<hr class="vertical-space2">

<hr class="vertical-space4">
</section>