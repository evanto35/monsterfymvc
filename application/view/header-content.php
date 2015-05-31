<div id="wrap" class="colorskin-0">
    <div id="sticker">
        <header id="header">
	        <div class="four columns">
	            <div class="logo">
	                <a href="./">
	                    <img src="./assets/images/logo.png" width="200" id="img-logo" alt="logo" style="padding:10px 10px 0px;">
	                </a>
	            </div>
	            <div id="user" style="position:absolute;top:30px;right:20px;">
						<form method="POST" action="./">
		    				Bem-vindo <strong><?php echo $PageContent->CurrentUser; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="action" value="logout">
							<input type="submit" value="Logout" style="padding: 5px;" />
						</form>
	        	</div>
	        </div>
        </header>
    </div>

    <section id="headline2" style="height:10px;padding:10px;">
        <h3 style="font-size:22pt; margin:1px;"><strong><?php echo $PageContent->title; ?></strong></h3>
    </section>
</div>

<br />

<?php Alert::echoAll(); ?>