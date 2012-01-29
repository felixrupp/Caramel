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
		        <th width="60%">Sitename</th>
		        <th width="10%">Options</th>
	        </tr>
	      </thead>
	      <tbody>
	        <?php foreach($pages as $naventry) { ?>
            <tr>
		          <td><a href="?q=editpages&id=<?php echo $naventry["id"] ?>"><?php echo $naventry["navigation"]; ?></a></td> 
              <td><a href="#" class="delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/inactive.png" width=" 15px" title="Delete" alt="Delete"></a></td>
		        </tr>
        		<?php if(isset($naventry["subpages"]) && count($naventry["subpages"]>0)) {?>
        				<?php foreach($naventry["subpages"] as $subentry) {?>
        					<tr>
                   <td><a href="?q=editpages&id=<?php echo $subentry["id"] ?>"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/subpage.png" title="Subpage" alt="Subpage"><?php echo $subentry["navigation"]; ?></a></td>
                   <td><a href="#" class="delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}"><img src="<?php echo TEMPLATEDIR; ?>/Backend/images/inactive.png" width=" 15px" title="Delete" alt="Delete"></a></td>
        				  </tr>
                <?php } ?>
        		<?php } ?>
        	<?php } ?>
        </tbody>
      </table>

<!-- 
<ul>
	<?php foreach($pages as $naventry) { ?>

		<li><a href="?q=editpages&id=<?php echo $naventry["id"] ?>"><?php echo $naventry["navigation"]; ?></a><span> | <a href="?q=editpages&id=<?php echo $naventry["id"] ?>&delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}">Delete</a></span>
		
		<?php if(isset($naventry["subpages"]) && count($naventry["subpages"]>0)) {?>
			<ul>
				<?php foreach($naventry["subpages"] as $subentry) {?>
					<li><a href="?q=editpages&id=<?php echo $subentry["id"] ?>"><?php echo $subentry["navigation"]; ?></a><span> | <a href="?q=editpages&id=<?php echo $subentry["id"] ?>&delete" onClick="javascript:if(confirm('Really delete this page with all records?')) {return true;} else {return false;}">Delete</a></span></li>
				<?php } ?>
			</ul>
		<?php } ?>
		</li>
	<?php } ?>
</ul>
 -->
</div>