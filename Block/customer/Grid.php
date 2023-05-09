<?php 

/**
 * 
 */
class Block_Customer_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Customer Content');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('customer_id',[
			'title' => 'Customer Id'
		]);
		$this->addColumn('firstname',[
			'title' => 'First Name'
		]);
		$this->addColumn('lastname',[
			'title' => 'Last Name'
		]);
		$this->addColumn('email',[
			'title' => 'Email'
		]);
		$this->addColumn('gender',[
			'title' => 'Gender'
		]);
		$this->addColumn('mobile',[
			'title' => 'Mobile'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
		]);
		$this->addColumn('created_at',[
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
		$this->addButton('customer_id',[
			'title' => 'Add Customer',
			'url' => $this->getUrl('add')
		]);

		return parent::_prepareButtons();
	}

	public function getCollection()
	{				
		$sql = "SELECT * FROM customer c INNER JOIN customer_address d ON c.customer_id = d.customer_id;";
		$customerRow = Ccc::getModel('Customer'); 
        $customers = $customerRow->fetchAll($sql);
        $this->setData(['customers'=>$customers]);
        return $customers;
	}
}


 ?>