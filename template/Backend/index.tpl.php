<div id="header">
	<div id="logo"><a href="./" title="back to start of AdminPanel">CARAMEL LOGO HERE</a></div>
	
	<?php if(isset($navigation) && $navigation!=FALSE) {?>
		<div id="logoutbutton"><a href="?q=logout" title="Logout">Logout</a></div>
	<?php } ?>
</div>



<?php if(isset($navigation) && $navigation!=FALSE) {?>

	<div id="nav">
		<ul id="adminnavigation">
			<li><a href="?q=newpage">Add new page</a></li>
			<li><a href="?q=editpages">Manage pages</a></li>
			<li><a href="?q=editusers">Manage user</a></li>
			<li><a href="?q=edittemplates">Manage templates</a></li>
			<li><a href="?q=editglobals">Global config</a></li>
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
		
			<div id="wrapper">
	
				<h2>Please login below:</h2>

				<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
					<fieldset>
						<label for="username">Username:</label> <input type="text" name="username" id="username">
						<br>
						<label for="password">Password:</label> <input type="password" name="password" id="password">
					</fieldset>
					
					<label>&nbsp;</label> <input type="submit" value="Login" id="submit" name="submit">
				</form>
			
			</div>
		
		</div>
	<?php } ?>
	
	
	<?php 
	
	if(isset($newpage) && $newpage!=FALSE) {
		include "newpage.tpl.php";
	}
	if(isset($editpages) && $editpages!=FALSE) {
		include "editpages.tpl.php";
	}
	if(isset($editusers) && $editusers!=FALSE) {
		include "editusers.tpl.php";
	}
	if(isset($edittemplates) && $edittemplates!=FALSE) {
		include "edittemplates.tpl.php";
	}
	if(isset($editglobals) && $editglobals!=FALSE) {
		include "editglobals.tpl.php";
	}
	
	?>

</div>


