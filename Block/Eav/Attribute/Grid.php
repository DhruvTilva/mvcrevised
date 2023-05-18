<?php 

class Block_Eav_Attribute_Grid extends Block_Core_Grid
{
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Attributes');
	}

	public function getCollection()
	{
		$sql = "SELECT eav.*,et.name as `entity_name` 
		FROM `eav_attribute` eav 
		LEFT JOIN `entity_type` et 
		ON eav.entity_type_id=et.entity_type_id";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($sql);
		return $attributes->getData();

		
	}

	protected function _prepareColumns()
	{
		$this->addColumn('attribute_id',[
			'title' => 'Attribute Id'
		]);
		
		$this->addColumn('entity_name',[
			'title' => 'Entity Type Name'
		]);
		$this->addColumn('code',[
			'title' => 'Code'
		]);
		$this->addColumn('backend_type',[
			'title' => 'Backend Type'
		]);
		$this->addColumn('name',[
			'title' => 'Name'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
		]);
		$this->addColumn('backend_model',[
			'title' => 'Backend Model'
		]);
		
		$this->addColumn('input_type',[
			'title' => 'Input Type'
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
		return parent::_prepareActions() ;
	}

	protected function _prepareButtons()
	{
		$this->addButton('attribute_id',[
			'title' => 'Add Attribute',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}
}