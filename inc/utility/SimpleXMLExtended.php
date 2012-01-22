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
	 */
	public function addCData($cdata_text){
		
		$node = dom_import_simplexml($this);
		$no = $node->ownerDocument;
		$node->appendChild($no->createCDATASection($cdata_text));
		
	}
}
?>