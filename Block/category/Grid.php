<?php


/**
 * 
 */
class Block_Category_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Category Content');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('category_id',[
			'title' => 'Category Id'
		]);
		$this->addColumn('name',[
			'title' => 'Name'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
		]);
		$this->addColumn('description',[
			'title' => 'Description'
		]);
		$this->addColumn('inserted_at',[
			'title' => 'Created at'
		]);
		$this->addColumn('updated_at',[
			'title' => 'Updated at'
		]);

		return parent::_prepareColumns();
	}

	protected function _prepareActions()
	{
		$this->addAction('edit',[
			'title' => 'Edit',
			'method' => 'getEditUrl'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl'
		]);

		return parent::_prepareActions();
	}

	protected function _prepareButtons()
	{
		$this->addButton('category_id',[
			'title' => 'Add Category',
			'url' => $this->getUrl('add')
		]);

		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `category` WHERE `category_id` ORDER BY `path` ASC";

		$row = Ccc::getModel('Category');
		$categorys = $row->fetchAll($sql);
		return $categorys->getData();
	}
}


  ?>