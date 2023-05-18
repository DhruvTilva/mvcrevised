<?php 

/**
 * 
 */
class Model_Eav_Attribute_Option extends Model_Core_Table
{
	
	public $resourceClass='Model_Eav_Attribute_Option_Resource';
	public $collectionClass='Model_Eav_Attribute_Option_Collection';
	protected $_attribute=null;

	public function setAttribute($attribute)
	{
		$this->_attribute=$attribute;
		return $this;
	}

	public function getAttribute()
	{
		return $this->_attribute;
	}	

}

?>