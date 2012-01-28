<!-- This is our default template -->
<div id="container">

  <div id="wrapper">
    <div id="menu">
    	<ul>
    	 <li class="logo"><a href="./"><img src="<?php echo TEMPLATEDIR; ?>/Default/images/logo.png" title="Caramel CMS" alt="Caramel CMS Logo"></a></li>
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
    
    
    <div id="content">
    	<?php echo $content; ?><br>
    </div>
  </div>
  
  <div id="footer">
  	<div class="footer_left"><?php echo $footer; ?></div>
  </div>
  
</div>