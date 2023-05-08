<?php 

/**
 * 
 */
class Block_Product_Edit extends Block_Core_Template
{
	protected $_row = Null;
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/edit.phtml');
	}

	public function setRow($row)
	{
		$this->_row = $row;
		return $this;
	}

	public function getRow()
	{
		return $this->_row;
	}

	
}

 ?>