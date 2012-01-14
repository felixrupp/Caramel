<div id="container">

  <div id="header">
    <div class="header_left"></div>
    <div class="header_center">Caramel CMS Backend </div>
    <div class="header_right">
      <?php if(isset($navigation) && $navigation!=FALSE) {?>
        <a href="?q=logout" title="Logout" class="right"><img src="../template/Backend/images/off.png" border="0"/></a>
      <?php } ?>
    </div>
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
  					<fieldset class="formButtons">
  					 <label>&nbsp;</label> <input type="submit" value="Login" id="submit" name="submit">
  					</fieldset>
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
  
  <div id="footer">
    <div class="footer_left"></div>
    <div class="footer_center"></div>
    <div class="footer_right">&copy; 2012 Caramel</div>
  </div>

</div>


