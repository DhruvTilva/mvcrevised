<?php 

/**
 * 
 */
class Block_Category_Edit extends Block_Core_Template
{
	protected $_row = Null;

	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('category/edit.phtml');
		$this->getCategory();
	}

	public function getCategory()
	{
		$request=Ccc::getModel('Core_Request');
		$id =$request->getParams('id');
		if ($id) {
			$category = Ccc::getModel('Category')->load($id);
		}
		else{
			$category = Ccc::getModel('Category');
		}
		$this->setData(['category'=>$category]);
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