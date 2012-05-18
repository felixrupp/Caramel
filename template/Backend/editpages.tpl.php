<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Page Management</h1>

<div class="pageManagement">

<p><a href="?q=newpage">Create new page &hellip;</a></p>

	<table id="pageManagementTable">
		<thead>
			<tr>
				<th>Sitename</th>
				<th width="15%" colspan="3">Options</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$pageCounter = 0;
		foreach($pages as $naventry) { ?> 
			<tr>
            	<td><a href="?q=editpages&id=<?php echo $naventry["id"] ?>"><?php echo $naventry["navigation"]; ?></a></td> 
			
            	<td>
            	<?php if($pageCounter!=0) { ?>
					<a href="?q=moveup&id=<?php echo $naventry["id"] ?>" class="moveup"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/up.png" width=" 15px" title="Move Up" alt="Move Up"></a>
				<?php } ?>
				</td>
				<td>
				<?php if($pageCounter<count($pages)-1) { ?>
					<a href="?q=movedown&id=<?php echo $naventry["id"] ?>" class="movedown"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/down.png" width=" 15px" title="Move Down" alt="Move Down"></a>
				<?php } ?>
				</td>
			
				<td><a href="?q=editpages&id=<?php echo $naventry["id"] ?>&delete" class="delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/inactive.png" width=" 15px" title="Delete" alt="Delete"></a></td>

			</tr>
			<?php if(isset($naventry["subpages"]) && count($naventry["subpages"]>0)) {?>
				<?php 
				$subpageCounter = 0;
				foreach($naventry["subpages"] as $subentry) {?>
					<tr>
						<td><a href="?q=editpages&id=<?php echo $subentry["id"] ?>"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/subpage.png" title="Subpage" alt="Subpage"><?php echo $subentry["navigation"]; ?></a></td>
						
						<td>
						<?php if($subpageCounter!=0) { ?>
							<a href="?q=moveup&id=<?php echo $subentry["id"] ?>" class="moveup"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/up.png" width=" 15px" title="Move Up" alt="Move Up"></a>
						<?php } ?>
						</td>
						
						<td>
						<?php if($subpageCounter<count($naventry["subpages"])-1) { ?>
							<a href="?q=movedown&id=<?php echo $subentry["id"] ?>" class="movedown"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/down.png" width=" 15px" title="Move Down" alt="Move Down"></a>
						</td>
						<?php } ?>
					
						<td><a href="?q=editpages&id=<?php echo $subentry["id"] ?>&delete" class="delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/inactive.png" width=" 15px" title="Delete" alt="Delete"></a></td>
					</tr>
                <?php 
                	$subpageCounter++;
				} ?>
        		<?php } ?>
        	<?php 
        	$pageCounter++;
		} ?>
        </tbody>
      </table>
      
</div>