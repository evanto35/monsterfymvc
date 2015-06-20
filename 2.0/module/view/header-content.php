<div id="wrap" class="colorskin-0">
    <div id="sticker">
        <div id="user" style="position:absolute;top:16px;right:20px;">
				<form method="POST" action="./">
					<font color="#FFFFF">
    					Bem-vindo <strong><?php echo $PageContent->CurrentUser; ?></strong>&nbsp;&nbsp;&nbsp;|&nbsp;
    				</font>
					<input type="hidden" name="action" value="logout">
					<input type="submit" value="Logout" style="padding: 5px;" />
				</form>
    	</div>
    </div>

    <section id="headline2" style="height:10px;padding:10px;">
        <h3 style="font-size:22pt; margin:1px;"><strong><?php echo $PageContent->title; ?></strong></h3>
    </section>
</div>

<br />

<?php Alert::echo(); ?>