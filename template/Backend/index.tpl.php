<?php
/**
 * @package template
 * @subpackage Backend
 */

/**
 * Index template
 */
?>

<div id="container">

	<div id="header">Caramel CMS Backend
	
	<?php if(isset($navigation) && $navigation!=FALSE) {?>
		<a href="?q=logout" title="Logout" class="floatRight"><img src="../template/Backend/images/off.png" alt="Logout"> </a>
	<?php } ?>
	</div>
	
	
	<?php if(isset($navigation) && $navigation!=FALSE) {?>
  
	<div id="menu">
		<ul>
			<li><a href="?q=editglobals" class="settings"></a></li>
			<li><a href="?q=editusers" class="admin"></a></li>
			<li><a href="?q=editpages" class="site"></a></li>
			<li><a href="?q=edittemplates" class="template"></a></li>
		</ul>
	</div>
    
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
  					 <input type="submit" value="Login" id="submit" name="submit">
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
  	if(isset($editonepage) && $editonepage!=FALSE) {
  		include "editonepage.tpl.php";
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
  
	<div id="footer">
		<p>&copy; 2012 Caramel</p>
	</div>

</div>


