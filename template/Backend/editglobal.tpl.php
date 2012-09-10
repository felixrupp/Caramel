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
		
			<?php foreach($globals as $key => $value) {?>
				<label for="<?php echo $key ?>"><?php echo $value['label']; ?>:<?php if($value['blank']=="false"){echo " <span>*</span>";}?></label> 
				
				<?php if($value['type']=="select") {?>
				
					<select data-blank="<?php echo $value['blank']?>" data-validate="<?php echo $value['validate']?>" name="<?php echo $key ?>" id="<?php echo $key ?>">
					
					<?php foreach($value['acceptedValues'] as $accKey => $accValue) {
					
						if(is_array($accValue) && isset($accValue["id"])) {?>
							<option value="<?php echo $accValue["id"]; ?>" <?php if($accValue["id"]==$value['value']) {echo "selected";} ?>><?php echo $accValue["path"]; ?></option>
							
						<?php } else {?>
						<option value="<?php echo $accKey; ?>" <?php if($accKey==$value['value']) {echo "selected";} ?>><?php echo $accValue; ?></option>
					<?php }} ?>
					
					</select>
				<?php } else if($value['type']=="text" || $value['type']=="password") {?>
					<input data-blank="<?php echo $value['blank']?>" data-validate="<?php echo $value['validate']?>" type="<?php echo $value['type']?>" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $value['value']; ?>">
				<?php } else if($value['type']=="checkbox") { ?>
					<input data-blank="<?php echo $value['blank']?>" data-validate="<?php echo $value['validate']?>" type="<?php echo $value['type']?>" name="<?php echo $key ?>" id="<?php echo $key ?>" value="true"<?php if ($value['value']=="true") echo 'checked="checked"'; ?>>
				 <?php }?>
				<br>
			<?php }?>
			
		</fieldset> 
		
		<span class="smallText">* Mandatory fields</span>
		<br>
			
		<input type="hidden" name="editglobal" id="editglobal">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>
