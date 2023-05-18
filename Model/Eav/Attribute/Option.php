<?php 

/**
 * 
 */
class Model_Eav_Attribute_Option extends Model_Core_Table
{
	
	public function __construct()
	{
		$this->setResourceClass('Model_Eav_Attribute_Option_Resource')
			->setCollectionClass('Model_Eav_Attribute_Option_Collection');
	}
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