<?php

/**
* @package inc
* @subpackage utility
*/

/**
 *
 * SimpleXMLExtended class for use with CDATA-tags
 *
 * @author Felix Rupp <kontakt@felixrupp.com>
 * @version $Id$
 * @copyright Copyright (c) 2011, Felix Rupp, Nicole Reinhardt
 * @license http://www.opensource.org/licenses/mit-license.php MIT-License
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package inc
 * @subpackage utility
 */
class SimpleXMLExtended extends SimpleXMLElement {
	
	
	/**
	 * Method to append proper CDATA to a node
	 * 
	 * @param string $cdata_text
	 * 
	 * @return void
	 */
	public function addCData($cdata_text){
		
		$node = dom_import_simplexml($this);
		$no = $node->ownerDocument;
		$node->appendChild($no->createCDATASection($cdata_text));
		
	} // End of method declaration
	
	
	
	/**
	 * Create a child with CDATA value
	 * 
	 * @param string $name The name of the child element to add.
	 * @param string $cdataText The CDATA value of the child element.
	 * 
	 * @return Child element that has been added as SimpleXMLExtended object
	 */
	public function addChildCData($name, $cdataText="") {
		
		$child = $this->addChild($name);
				
		if(strlen($cdataText)>0) {
			
			$child->addCData($cdataText);
			
		}
		
		return $child;
		
	} // End of method declaration
	
	
	
	/**
	 * Method to remove a node
	 * 
	 * @return void
	 */
	public function removeNode() {
		
		$node = dom_import_simplexml($this);
		$node->parentNode->removeChild($node);
		
	} // End of method declaration
	
}
?>