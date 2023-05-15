<?php

/**
 * 
 */

class Block_Vendor_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage VEndor Content');
		// $this->setTemplate('core/grid.phtml');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('vendor_id',[
			'title' => 'Vendor Id'
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
		$this->addButton('vendor_id',[
			'title' => 'Add Vendor',
			'url' => $this->getUrl('add')
		]);

		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$pager = $this->getPager();
		$sql = "SELECT count(`vendor_id`) FROM `vendor` ";
		$adapter = Ccc::getModel('Core_Adapter');
		$totalRecord = $adapter->fetchOne($sql);
		$setRecords = $pager->setTotalRecord($totalRecord)->calculate();

		$sql = "SELECT * FROM `vendor` ORDER BY  `vendor_id` ASC LIMIT {$pager->startLimit},{$pager->recordPerPage}";
		$row = Ccc::getModel('Vendor');
		$vendors = $row->fetchAll($sql);
		return $vendors->getData();
		
	}
}



 ?>