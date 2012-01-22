<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Template Management</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
			<!-- <label for="template"><?php echo $template["template"]['label']; ?></label> <input type="text" name="template" id="template" value='<?php echo $template["template"]["value"]; ?>'> -->
			
			<label for="template"><?php echo $template["template"]['label']; ?></label> <select name="template" id="template">
				<?php foreach($template["template"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$template["template"]["value"]){echo ' selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>
						
		</fieldset>
			
		<input type="hidden" name="edittemplates" id="edittemplates">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>
