<!-- This is our test template -->

<div id="site">
  <h1>CARAMEL CMS</h1>
	<div id="wrapper">
	
	  <div id="content">
	   <?php echo $content; ?>
    </div>
    
	</div>
	
  <div id="menu">
  	<ul>
  	 <li class="logo">Caramel</li>
    <?php foreach($navigation as $naventry) { ?>
  			
  		<li><?php echo $naventry["link"]; ?>
  		
  		<?php 
  		if(isset($naventry["subpages"]) && count($naventry["subpages"]>0)) {?>
  			<ul>
  		<?php foreach($naventry["subpages"] as $subentry) {?>
  				<li><?php echo $subentry["link"]; ?></li>
  		<?php } ?>
  			</ul>
  		<?php } ?>
  		  </li>
  	<?php } ?>
  	</ul>
  </div>

  <div id="footer">
  	<div class="footer_left"><?php echo $footer; ?></div>
  </div>

</div>