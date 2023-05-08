<?php 

/**
 * 
 */
class Block_Salesman_Edit extends Block_Core_Template
{
	protected $_row = Null;
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/edit.phtml');
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