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
			<label for="admin_username"><?php echo $admin["admin_username"]['label']; ?></label> <input type="text" name="admin_username" id="admin_username" value='<?php echo $admin["admin_username"]["value"]; ?>'>
			<br>
			<label for="admin_password"><?php echo $admin["admin_password"]['label']; ?></label> <input type="password" name="admin_password" id="admin_password" value="">
			<br>
			<label for="password_verification">Please re-type the new password:</label> <input type="password" name="password_verification" id="password_verification" value="">
			<br>
			<label for="admin_email"><?php echo $admin["admin_email"]['label']; ?></label> <input type="text" name="admin_email" id="admin_email" value='<?php echo $admin["admin_email"]["value"]; ?>'>
			<br>
			<label for="contact_email"><?php echo $admin["contact_email"]['label']; ?></label> <input type="text" name="contact_email" id="contact_email" value='<?php echo $admin["contact_email"]["value"]; ?>'>
			<br>
		</fieldset>
			
		<input type="hidden" name="editusers" id="editusers">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>
