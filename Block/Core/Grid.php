<?php 

class Block_Core_Grid extends Block_Core_Template
{
	protected $_columns = [];
	protected $_actions = [];
	protected $_buttons = [];
	protected $_title = Null;
	// protected $_pager = Null;
	// protected $_count = Null;
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/grid.phtml');
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Grid');
	}

	// public function setPagination(Model_Core_Pagination $pager)
	// {
	// 	$this->_pager = $pager;
	// 	return $this;
	// }

	// public function getPagination()
	// {
	// 	if($this->_pager){
	// 		return $this->_pager;
	// 	}

	// 	$request = Ccc::getModel('Core_Request');
    //     $currentPage = ($request->getParams('p',1));
    //     $recordPerPage = $request->getParams('rpp',10);
	// 	$pager = new Model_Core_Pagination($this->getCount(), $currentPage);
	// 	$pager->setRecordPerPage($recordPerPage);
	// 	$this->setPagination($pager);
	// 	return $pager;
	// }

	// public function getCount()
    // {
    //     return $this->_count;
    // }

    // public function setCount($count)
    // {
    //     $this->_count = $count;
    //     return $this;
    // }
	public function setColumns(array $columns)
	{
		$this->_columns = $columns;
		return $this;
	}

	public function getColumns()
	{
		return $this->_columns;
	}

	public function addColumn($key, $value)
	{
		$this->_columns[$key] = $value;
		return $this;
	}

	public function removeColumn($key)
	{
		unset($this->_columns[$key]);
		return $this;
	}

	public function getColumn($key)
	{
		if(array_key_exists($key, $this->_columns)){
			return $this->_columns[$key];
		}
		return false;
	}

	protected function _prepareColumns()
	{
		return $this;
	}

	public function setActions(array $actions)
	{
		$this->_actions = $actions;
		return $this;
	}

	public function getActions()
	{
		return $this->_actions;
	}

	public function addAction($key, $value)
	{
		$this->_actions[$key] = $value;
		return $this;
	}

	public function removeAction($key)
	{
		unset($this->_actions[$key]);
		return $this;
	}

	public function getAction($key)
	{
		if(array_key_exists($key, $this->_actions)){
			return $this->_actions[$key];
		}
		return false;
	}

	protected function _prepareActions()
	{
		return $this;
	}

	public function getEditUrl($row, $key)
	{
		return $this->getUrl($key,Null,['id'=>$row->getId()]);
	}

	public function getSalesmanPrice($row,$key)
	{			
		return $this->getUrl('grid','sprice',['id'=>$row->getId()]);

	}
	public function getMediaUrl($row,$key)
	{			
		return $this->getUrl('grid','media',['id'=>$row->getId()]);

	}

	public function getDeleteUrl($row, $key)
	{
		return $this->getUrl($key,Null,['id'=>$row->getId()]);
	}

	public function setButtons(array $buttons)
	{
		$this->_buttons = $buttons;
		return $this;
	}

	public function getButtons()
	{
		return $this->_buttons;
	}

	public function addButton($key, $value)
	{
		$this->_buttons[$key] = $value;
		return $this;
	}

// --------------------------------------
	public function paymentRedirect()
	{
	
		// return header("Location: http://localhost/Project/newmvc-dhruvtilva/View/order/payment.phtml");
	}

	public function removeButton($key)
	{
		unset($this->_buttons[$key]);
		return $this;
	}

	public function getButton($key)
	{
		if(array_key_exists($key, $this->_buttons)){
			return $this->_buttons[$key];
		}
		return false;
	}

	protected function _prepareButtons()
	{
		return $this;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function getColumnValue($row, $key)
	{
		if($key == 'status'){
			return $row->getStatusText();
		}
		return $row->$key;
	}
}