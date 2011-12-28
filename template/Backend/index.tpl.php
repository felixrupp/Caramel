<!-- This is our admin template -->


<div id="header">
	<div id="logo"><a href="./" title="back to start of AdminPanel">CARAMEL LOGO HERE</a></div>
	
	<?php if(isset($navigation) && $navigation!=FALSE) {?>
		<div id="logoutbutton"><a href="?q=logout" title="Logout">Logout</a></div>
	<?php } ?>
</div>



<?php if(isset($navigation) && $navigation!=FALSE) {?>

	<div id="nav">
		<ul id="adminnavigation">
			<li><a href="?q=newpage">Neue Seite anlegen</a></li>
			<li><a href="?q=editpages">Bestehende Seiten verwalten</a></li>
			<li><a href="?q=editusers">Benutzer verwalten</a></li>
			<li><a href="?q=edittemplates">Templates verwalten</a></li>
			<li><a href="?q=editglobals">Globale Konfiguration</a></li>
		</ul>
	</div>
	
	<div class="clearboth"><div>

<?php } ?>




<div id="content">

	<?php if(isset($welcome) && $welcome!=FALSE) {?>
		<div id="welcome">
	
			<h1>Welcome at admin backend of Caramel CMS</h1>
			<p>It's great to have you here!</p>
		
		</div>
	<?php } ?>

	
	<?php if(isset($login) && $login!=FALSE) {?>
		<div id="adminlogin">
	
			<p>Please login below:</p>

			<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
				<label for="username">Username:</label> <input type="text" name="username" id="username">
				<br>
				<label for="password">Password:</label> <input type="password" name="password" id="password">
				<br>
				<label>&nbsp;</label> <input type="submit" value="Login" id="submit" name="submit">
			</form>
		
		</div>
	<?php } ?>


</div>


