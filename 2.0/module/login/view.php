<div id="wrap" class="colorskin-0">
    <section id="headline2">
        <div class="container">
            <h3>TAM Viagens: Controle de Ligações</h3>
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
                    <label>Usuário: </label><input name="username" id="usuario" value="E-mail" type="text" title="E-mail" onblur="if(this.value==''){this.value='E-mail'}" onfocus="if (this.value=='E-mail'){this.value=''}" />
                    <label>Senha:</label><input name="password" id="senha" title="Informe a sua senha de acesso" type="password" />
                    <input type="submit" name="submit" value="Acessar" />
                </div>


                <!-- Mensagem de erro no login -->
                <div id='login-msg'>
                    <label>
                        <pre><?php print_r($_SESSION) ?></pre>
                        <?php
                            if (isset($_SESSION[ControllerBase::IDX_LOGIN_MSG])) {
                                echo $_SESSION[ControllerBase::IDX_LOGIN_MSG];
                                unset($_SESSION[ControllerBase::IDX_LOGIN_MSG]);
                            }

                            if (isset($data)) echo $data;
                        ?>
                    <label>
                </div>
                <!-- Fim da Mensagem de erro -->
            </form>
        </article>
    </div>
</div>
<hr class="vertical-space2">

<hr class="vertical-space4">
</section>