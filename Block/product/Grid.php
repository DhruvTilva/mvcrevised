<?php

/**
 * 
 */

class Block_Product_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Product Content');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('product_id',[
			'title' => 'Product Id'
		]);
		$this->addColumn('name',[
			'title' => 'Name'
		]);
		$this->addColumn('sku',[
			'title' => 'SKU'
		]);
		$this->addColumn('cost',[
			'title' => 'COST'
		]);
		$this->addColumn('price',[
			'title' => 'PRICE'
		]);
		$this->addColumn('description',[
			'title' => 'Description'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
		]);
		$this->addColumn('color',[
			'title' => 'Color'
		]);
		$this->addColumn('material',[
			'title' => 'Material'
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
		$this->addAction('media',[
			'title' => 'Media',
			'method' => 'getMediaUrl'
		]);
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
		$this->addButton('product_id',[
			'title' => 'Add Product',
			'url' => $this->getUrl('add')
		]);

		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$pager = $this->getPager();
		$sql = "SELECT count(`product_id`) FROM `product` ";
		$adapter = Ccc::getModel('Core_Adapter');
		$totalRecord = $adapter->fetchOne($sql);
		$setRecords = $pager->setTotalRecord($totalRecord)->calculate();

		$sql = "SELECT * FROM `product` ORDER BY  `product_id` ASC LIMIT {$pager->startLimit},{$pager->recordPerPage} ";
		$row = Ccc::getModel('Product');
		$products = $row->fetchAll($sql);
		return $products->getData();
		// return $this;
		
	}
}



 ?>