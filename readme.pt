
==========================
|						 |
| MonsterfyMVC Framework |
|						 |
==========================

Copyright (C)2012
http://bitbucket.org/leandro_medeiros/monsterfymvc


| SOBRE |
---------
MonsterfyMVC é um projeto sem fins lucrativos idealizado e mantido por
Leandro Medeiros <http://about.me/leandro.medeiros>.

Este framework permite o desenvolvimento do back-end de aplicações WEB baseado na arquitetura
Model-View-Controller. As classes-base aqui disponibilizadas controlam a comunicação com a
base de dados (DAOs e DTOs) e o fluxo do sistema (Controllers e Views).


| LICENÇA |
-----------
Este software é gratuito e distribuído sob a GPLv3. Veja <licence/gpl.txt> OU
<http://www.gnu.org/licenses/> para maiores informações.


| ADD-ONS |
-----------
Junto ao Monsterfy são distribuídas cópias de softwares complementares:

- O front-end é construído sobre o framework Bootstrap <http://getbootstrap.com>.
- As grades são reprocessadas pelo plugin DataTables <http://datatables.net>.


| PRÉ-REQUISITOS |
------------------
Ambiente de desenvolvimento:

1. MySQL Server 5.0+ <http://dev.mysql.com/downloads/>. (Pode-se rodar o MySQL em qualquer outro
computador, desde que o usuário tenha permissões remotas);
2. Apache Server 2.2+ <http://apache.org> OU NGINX 1.7.10+ <http://nginx.org>;
3. Pré-processador PHP 5.5+ <http://php.net/downloads.php>;

Obs.: Desenvolvedores iniciantes ou preguiçosos podem usar uma SolutionStack como o MAMP (Mac OS X),
WAMP (MS Windows) ou LAMP (OS baseado em Linux).


| INSTALAÇÃO |
--------------
Após a configuração do ambiente de desenvolvimento a instalação do framework é bastante simples:

1. Copiar a pasta completa do MonsterfyMVC para o diretório ROOT configurado no seu servidor HTTP;
2. Executar o script <documentation/mysql/scripts/01-create.sql> (renomeie o banco de dados à vontade);
3. Alterar as constantes da classe Config <commons/Config.php> com os dados de acesso ao seu servidor
MySQL (host, porta, nome do banco, usuário e senha);
4. Pronto! Ao acessar <http://localhost/monsterfymvc> você deverá ver a tela de autenticação do Monsterfy MVC!


| USO |
-------
O primeiro usuário criado é o Administrador, seu login é "admin@monsterfymvc.com" e a senha
"Develop#23". Ao logar, se tudo estiver correto, será apresentada a página inicial do módulo Dashboard, que
é basicamente uma listagem dos módulos disponíveis.

Para começar a desenvolver uma aplicação crie seu próprio módulo com 3 passos simples (considerando
o módulo "Foo bar"):

1. Acesso o banco de dados e, na tabela "module", insira um registro com o nome "foobar", título "Foo bar", e
ativo "1";
1.1. Dê acesso aos seus usuários inserindo um registro na tabela "user_module";

2. Crie o arquivo <controllers/FoobarController.php>;
2.1. Declare a classe FoobarController estendendo BaseController;
2.2. Implemente o método "Página Inicial" [ goHome() { return $this->getView(); } ] e "Definir Abas" [ setTabs() {} ];

3. Copie a pasta <modules/dashboard> para <modules/foobar>;
3.1. Abra o arquivo <modules/foobar/index.php> e substitua "new DashboardController();" por "new FoobarController();"
3.2. Apague o conteúdo do arquivo <modules/foobar/view.php>;

Pronto, agora há um novo item na barra de navegação de seu sistema que lhe dá ao módulo Foo bar!

Obs.: Note que os diretórios aqui descritos são meras sugestões de organização, você está livre para salvar
suas classes onde bem entender, desde que altere ou crie funções Loader em <bootstrap.php>, adapte o método
View::load() em <commons/View.php> e modifique as constantes de diretórios em <commons/Config.php>.


------------------------
! CONSIDERAÇÕES FINAIS !
------------------------
Este conjunto de bibliotecas foi desenvolvido durante o tempo livre de um programador que têm experiência demais em
desenvolvimento de sistemas desktop e embarcados e experiência "de menos" em sistemas WEB. O objetivo dele foi criar
uma aplicação WEB completa, cujo back-end fosse próprio.

Acredite ou não, desde que comecei à estudar PHP em 2012 já usei este lixo como base para desenvolver 3
plataformas (+1k acessos/dia), o que dobrou minha preguiça em aprender um Laravel da vida.

