<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Administrator</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
		
			<?php foreach($admin as $key => $value) {?>
				<label for="<?php echo $key ?>"><?php echo $value['label']; ?>:<?php if($value['blank']=="false"){echo " <span>*</span>";}?></label> 
				<?php if($value['type']=="select") {?>
					<select data-blank="<?php echo $value['blank']?>" data-validate="<?php echo $value['validate']?>" name="<?php echo $key ?>" id="<?php echo $key ?>">
					<?php foreach($value['acceptedValues'] as $langCode => $langName) {?>
						<option value="<?php echo $langCode; ?>" <?php if($langCode==$value['value']) {echo "selected";} ?>><?php echo $langName; ?></option>
					<?php } ?>
					</select>
				<?php } else if($value['type']=="text" || $value['type']=="password") {?>
					<input data-blank="<?php echo $value['blank']?>" data-validate="<?php echo $value['validate']?>" type="<?php echo $value['type']?>" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $value['value']; ?>">
				<?php }?>
				<br>
			<?php }?>
			
		</fieldset>
			
		<span class="smallText">* Mandatory fields</span>
		<br>
		
		<input type="hidden" name="editusers" id="editusers">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>