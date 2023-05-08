<?php

/**
 * 
 */

class Block_Salesman_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Salesman Content');
		// $this->setTemplate('core/grid.phtml');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('salesman_id',[
			'title' => 'Salesman Id'
		]);
		$this->addColumn('firstname',[
			'title' => 'First Name'
		]);
		$this->addColumn('lastname',[
			'title' => 'Last NAme'
		]);
		$this->addColumn('mail',[
			'title' => 'Email'
		]);
		$this->addColumn('gender',[
			'title' => 'GENDER'
		]);
		$this->addColumn('no',[
			'title' => 'MObile'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
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
		$this->addButton('salesman_id',[
			'title' => 'Add Salesman',
			'url' => $this->getUrl('add')
		]);

		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `salesman` ORDER BY `salesman_id` DESC";
		$row = Ccc::getModel('Salesman');
		$salesmans = $row->fetchAll($sql);
		return $salesmans->getData();
		
	}
}



 ?>