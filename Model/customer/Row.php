<?php

class Model_Customer_Row extends Model_Core_Table_Row
{
	function __construct()
	{
		parent::__construct();
		$this->setTableClass('Model_Customer');
	}



	public function getBillingAddress($id)
	{
		$address = Ccc::getModel('Customer_Address_Row');
		$request = Ccc::getModel('Core_Request');
		$id = $request->getParams('id');
		if ($id) {
			

			$sql = "SELECT * FROM `customer_address` WHERE `address_id` = $id;";
			$address = $address->fetchRow($sql);

		}
		return $address;
	}

	 public function getShippingAddress($id)
    {
		$address = Ccc::getModel('Customer_Address');
		$request = Ccc::getModel('Core_Request');
		$id = $request->getParams('id');
		if($id){
			
			$sql = "SELECT * FROM `customer_address` WHERE `address_id` = $id;";
			$address = $address->fetchRow($sql);
		}
		return $address;
    }

   
    // public function getAddresses()
	// {
	// 	$sql = "SELECT * FROM `customer_address` where `customer_id` = Null;";
	// 	$modelAddress = Ccc::getModel('Customer_Address_Row');
	// 	$addresses = $modelAddress->fetchAll($sql);
	// 	return $addresses;
	// }
    


}	