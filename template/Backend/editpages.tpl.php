<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Page Management</h1>

<div>

	<form action="#" method="post">
		<fieldset>
		  <table>
		    <thead>
		      <tr>
		        <th></th>
		        <th>Sitename</th>
		        <th>Active</th>
		        <th>Typ</th>
		        <th>Menu</th>
		        <th>Position</th>
	        </tr>
	      </thead>
	      <tbody>
	        <tr>
	         <td><input type="radio" name="page" id="page" value="caramel"></td>
           <td>Caramel</td>
           <td><img src="../template/Backend/images/active.png" class="position"/></td>
           <td>Standard</td>
           <td>Caramel</td>
           <td><img src="../template/Backend/images/down.png" class="position"/></td>
          </tr>
          <tr>
		       <td><input type="radio" name="page" id="page" value="download"></td> 
           <td>Download</td>
           <td><img src="../template/Backend/images/inactive.png" class="position"/></td>
           <td>Standard</td>
           <td>Download</td>
           <td><img src="../template/Backend/images/up.png" class="position"/><img src="../template/Backend/images/down.png" class="position"/></td>
          </tr>
          <tr>
		       <td><input type="radio" name="page" id="page" value="dokumentation"></td>
           <td>Dokumentation</td>
           <td><img src="../template/Backend/images/active.png" class="position"/></td>
           <td>Standard</td>
           <td>Dokumentation</td>
           <td><img src="../template/Backend/images/up.png" class="position"/></td>
          </tr>
        </tbody>
      </table>
		</fieldset>
		
		<fieldset class="formButtons">
		  <label>&nbsp;</label> <input type="submit" name="submit" id="submit" value="Save">
		</fieldset>
	</form>

</div>