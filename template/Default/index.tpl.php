<!-- This is our default template -->

<?php 
/**
 * @package template
 * @subpackage Default
 */
?>

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


<div id="content">
	<?php echo $content; ?>
</div>


<div id="footer">
	<?php echo $footer; ?>
</div>