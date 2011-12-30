<h1>Global configuration:</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
		
			<?php foreach($globals as $key => $globalSetting) {?>
				<label for="<?php echo $key; ?>"><?php echo $globalSetting['label']; ?></label> <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value='<?php echo $globalSetting["value"]; ?>'>
				<br>
			<?php } ?>
		</fieldset>
		
		<input type="hidden" name="editglobals" id="editglobals">
		<label>&nbsp;</label> <input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>