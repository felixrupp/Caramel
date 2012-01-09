<h1>Global configuration:</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
			<label for="website_title"><?php echo $globals["website_title"]['label']; ?></label> <input type="text" name="website_title" id="website_title" value='<?php echo $globals["website_title"]["value"]; ?>'>
			<br>
			<label for="website_title_seperator"><?php echo $globals["website_title_seperator"]['label']; ?></label> <input type="text" name="website_title_seperator" id="website_title_seperator" value='<?php echo $globals["website_title_seperator"]["value"]; ?>'>
			<br>
			<label for="startpage"><?php echo $globals["startpage"]['label']; ?></label> <select name="startpage" id="startpage">
				<?php foreach($globals["startpage"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$globals["startpage"]["value"]){echo 'selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>	
			<br>
		</fieldset>
		
		<input type="hidden" name="editglobals" id="editglobals">
		<label>&nbsp;</label> <input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>
