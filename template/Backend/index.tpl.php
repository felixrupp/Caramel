<!-- This is our admin template -->

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

<?php } ?>


<div id="content">
	
	<?php if(isset($content) && $content=="login") {?>
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


