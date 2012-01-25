<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Global Settings</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
			<label for="website_title"><?php echo $globals["website_title"]['label']; ?></label> <input type="text" name="website_title" id="website_title" value='<?php echo $globals["website_title"]["value"]; ?>'>
			<br>
			<label for="website_title_seperator"><?php echo $globals["website_title_seperator"]['label']; ?></label> <input type="text" name="website_title_seperator" id="website_title_seperator" value='<?php echo $globals["website_title_seperator"]["value"]; ?>'>
			<br>
			<label for="startpage"><?php echo $globals["startpage"]['label']; ?></label> <select name="startpage" id="startpage">
				<?php foreach($globals["startpage"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option["id"]; ?>"<?php if($option["id"]==$globals["startpage"]["value"]){echo ' selected';} ?>><?php echo $option["path"]; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="base"><?php echo $globals["base"]['label']; ?></label> <input type="text" name="base" id="base" value='<?php echo $globals["base"]["value"]; ?>'>
			<br>
			<label for="robots"><?php echo $globals["robots"]['label']; ?></label> <select name="robots" id="robots">
				<?php foreach($globals["robots"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$globals["robots"]["value"]){echo ' selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="speaking_urls"><?php echo $globals["speaking_urls"]['label']; ?></label> <input type="checkbox" name="speaking_urls" id="speaking_urls" value="true"<?php if($globals["speaking_urls"]["value"]=="true") echo " checked"?>>
		</fieldset>
			
		<fieldset>
			<label for="navigation_active_marker_position"><?php echo $globals["navigation_active_marker_position"]['label']; ?></label> <select name="navigation_active_marker_position" id="navigation_active_marker_position">
				<?php foreach($globals["navigation_active_marker_position"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$globals["navigation_active_marker_position"]["value"]){echo ' selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="navigation_active_marker"><?php echo $globals["navigation_active_marker"]['label']; ?></label> <input type="text" name="navigation_active_marker" id="navigation_active_marker" value='<?php echo $globals["navigation_active_marker"]["value"]; ?>'>
			<br>
			<label for="navigation_class"><?php echo $globals["navigation_class"]['label']; ?></label> <input type="text" name="navigation_class" id="navigation_class" value='<?php echo $globals["navigation_class"]["value"]; ?>'>
		</fieldset>
		
		<fieldset>
			<label for="language_selector_in_footer"><?php echo $globals["language_selector_in_footer"]['label']; ?></label> <input type="checkbox" name="language_selector_in_footer" id="language_selector_in_footer" value="true"<?php if($globals["language_selector_in_footer"]["value"]=="true") echo " checked"?>>
			<br>
			<label for="language_selector_seperator"><?php echo $globals["language_selector_seperator"]['label']; ?></label> <input type="text" name="language_selector_seperator" id="language_selector_seperator" value='<?php echo $globals["language_selector_seperator"]["value"]; ?>'>
		</fieldset>
			
		<input type="hidden" name="editglobals" id="editglobals">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>
