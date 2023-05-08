<?php 

class Block_Core_Grid extends Block_Core_Template
{
	protected $_columns = [];
	protected $_actions = [];
	protected $_buttons = [];
	protected $_title = Null;

	//to set columns of the table 
	public function setColumns(array $columns)
	{
		$this->_columns = $columns;
		return $this;
	}
	//get the columns of the tables
	public function getColumns()
	{
		return $this->_columns;
	}
	//adding one colum
	public function addColumn($key, $value)
	{
		$this->_columns[$key] = $value;
		return $this;
	}
	//remove that column
	public function removeColumn($key)
	{
		unset($this->_columns[$key]);
		return $this;
	}
	// to ge that column
	public function getColumn($key)
	{
		if(array_key_exists($key, $this->_columns)){
			return $this->_columns[$key];
		}
		return false;
	}
	// prepare all columns
	protected function _prepareColumns()
	{
		return $this;
	}
	// to setting actions like edit, delete
	public function setActions(array $actions)
	{
		$this->_actions = $actions;
		return $this;
	}

	public function getActions()
	{
		return $this->_actions;
	}
	//add actions edit delete
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

	public function getDeleteUrl($row, $key)
	{
		return $this->getUrl($key,Null,['id'=>$row->getId()]);
	}
	//to setting buttons just like add
	public function setButtons(array $buttons)
	{
		$this->_buttons = $buttons;
		return $this;
	}

	public function getButtons()
	{
		return $this->_buttons;
	}
	//adding the add or other buttons
	public function addButton($key, $value)
	{
		$this->_buttons[$key] = $value;
		return $this;
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
	// to setting a title 
	public function setTitle($title)
	{
		$this->_title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	
}

?>