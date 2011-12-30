<!-- This is our default template -->

<div id="nav">

	<ul>
	<?php foreach($navigation as $naventry) { ?>
			
		<li><?php echo $naventry["link"]; ?></li>
		
		<?php 
		if(isset($naventry["subpages"]) && count($naventry["subpages"]>0)) {?>
			<ul>
		<?php foreach($naventry["subpages"] as $subentry) {?>
				<li><?php echo $subentry["link"]; ?></li>
		<?php } ?>
			</ul>
		<?php } ?>
		
	<?php } ?>
	</ul>
</div>


<div id="content">
	<?php echo $content; ?>
</div>


<div id="footer">
	<?php echo $footer; ?>
</div>