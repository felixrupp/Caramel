<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Edit page: "<?php echo $page["path"]["value"] ?>"</h1>

<p><a href="?q=editpages">back to page overview</a></p>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
	
		<fieldset>
			<legend>Page settings</legend>
			<label for="path"><?php echo $page["path"]["label"]; ?></label> <input type="text" name="path" id="path" value='<?php echo $page["path"]["value"]; ?>'>
			<br>
			<label for="stylesheet"><?php echo $page["stylesheet"]["label"]; ?></label> <input type="text" name="stylesheet" id="stylesheet" value='<?php echo $page["stylesheet"]["value"]; ?>'>
			<br>
			<label for="scriptfile"><?php echo $page["scriptfile"]["label"]; ?></label> <input type="text" name="scriptfile" id="scriptfile" value='<?php echo $page["scriptfile"]["value"]; ?>'>
			
		</fieldset>
	
		<?php foreach($page["records"] as $language => $record) { ?>
	
			<fieldset name="fieldset_<?php echo $language ?>">
				<legend class="collapsableFieldset">Language: <?php echo $language ?></legend>
								
				<label for="visible_<?php echo $language ?>"><?php echo $record["visible"]["label"]; ?></label> <input type="checkbox" name="visible_<?php echo $language ?>" id="visible_<?php echo $language ?>" value="true"<?php if($record["visible"]["value"]=="true") echo " checked"?>>
				<br>				
								
				<label for="navigation_<?php echo $language ?>"><?php echo $record["navigation"]["label"]; ?></label> <input type="text" name="navigation_<?php echo $language ?>" id="navigation_<?php echo $language ?>" value='<?php echo $record["navigation"]["value"]; ?>'>
				<br>
				
				<label for="title_<?php echo $language ?>"><?php echo $record["title"]["label"]; ?></label> <input type="text" name="title_<?php echo $language ?>" id="title_<?php echo $language ?>" value='<?php echo $record["title"]["value"]; ?>'>
				<br>
				
				<label for="titletag_<?php echo $language ?>"><?php echo $record["titletag"]["label"]; ?></label> <input type="text" name="titletag_<?php echo $language ?>" id="titletag_<?php echo $language ?>" value='<?php echo $record["titletag"]["value"]; ?>'>
				<br>
				
				<label for="metadescription_<?php echo $language ?>"><?php echo $record["metadescription"]["label"]; ?></label> <textarea name="metadescription_<?php echo $language ?>" id="metadescription_<?php echo $language ?>"><?php echo $record["metadescription"]["value"]; ?></textarea>
				<br>
				
				<label for="metakeywords_<?php echo $language ?>"><?php echo $record["metakeywords"]["label"]; ?></label> <input type="text" name="metakeywords_<?php echo $language ?>" id="metakeywords_<?php echo $language ?>" value='<?php echo $record["metakeywords"]["value"]; ?>'>
				<br>
				
				<label for="metaauthor_<?php echo $language ?>"><?php echo $record["metaauthor"]["label"]; ?></label> <input type="text" name="metaauthor_<?php echo $language ?>" id="metaauthor_<?php echo $language ?>" value='<?php echo $record["metaauthor"]["value"]; ?>'>
				<br>
				
				<label for="content_<?php echo $language ?>"><?php echo $record["content"]["label"]; ?></label>
				<br>
				<textarea class="ckContent" name="content_<?php echo $language ?>" id="content_<?php echo $language ?>"><?php echo $record["content"]["value"]; ?></textarea>
				<br>

			</fieldset>
			
		<?php } ?>
			
		<input type="hidden" name="editonepage" id="editonepage">
		<input type="hidden" name="pageid" id="pageid" value="<?php echo $page["id"] ?>">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>


</div>