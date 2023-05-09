<?php 


class Controller_Customer extends Controller_Core_Action 
{
	public function render()
		{
			return $this->getView()->render();
		}
	public function gridAction()
	{
		// try {
			// echo 111; die;
			$layout = new Block_Core_Layout();
			$grid = $layout->createBlock('Customer_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			// echo $layout->toHtml();
			$layout->render();
		// } catch (Exception $e) {
		// 	echo "catch found";
		// }
	}

	public function addAction()
	{
		$message = Ccc::getModel('Core_Message');
		try 
		{
			$customer = Ccc::getModel('Customer');
			if(!$customer){
				throw new Exception("Invalid request.", 1);
			}
			
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Customer_Edit');
			$edit->setData(['customer'=>$customer]);
			$layout->getChild('content')->addChild('edit',$edit);
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Customer not Saved.',Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
			$message = Ccc::getModel('Core_Message');
		try 
		{
			$id =$this->getRequest()->getParams('id');
			if(!$id){
	    		throw new Exception("Invalid request.", 1);
			}
			

			$customer=Ccc::getModel('Customer')->load($id);
			$customerAddress=Ccc::getModel('Customer_Address')->load($id);
			if(!$customer){
				throw new Exception("Invalid Id.", 1);
			}

			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Customer_Edit');
			$edit->setData(['customer'=>$customer,'address'=>$customerAddress]);
			$layout->getChild('content')
					->addChild('edit',$edit);
			// $layout->render();
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Customer Not Saved',Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	// public function saveAction()
	// {
	// 	try{
	// 		$request=Ccc::getModel('Core_Request');
	// 		if(!$request->isPost()){
	// 			throw new Exception("Error Request");
	// 		}
	// 		$data = $request->getPost('customer');
	// 		if (!$data) {
	// 			throw new Exception("no data posted");
	// 		}
	// 		$id=$request->getParams('id');
	// 		if ($id) {
	// 			$customer=Ccc::getModel('Customer_Row')->load($id);
	// 			date_default_timezone_set('Asia/Kolkata');
	// 			$customer->updated_at=date('Y-m-d H:i:s');
	// 		}
	// 		else
	// 		{
	// 			$customer= Ccc::getModel('Customer_Row');
	// 			date_default_timezone_set('Asia/Kolkata');
	// 			$customer->inserted_at = date("Y-m-d h:i:s");
	// 		}
	// 		$customer->setData($data);
	// 		$customer->save();
			

	// 		$postBilling = $this->getRequest()->getpost('billingAddress');
	// 		if (!$postBilling) {
	// 			throw new Exception("no data posted");
	// 		}
	// 		if ($id = (int)$this->getRequest()->getParams('id')) {
	// 			$billingId = $customer->billing_id;
	// 			$billingAddress = $customer->getBillingAddress($billingId);
	// 		if (!$billingAddress) {
	// 			throw new Exception("Invalid id.", 1);
	// 		}
	// 	}
	// 	else{
	// 		$billingAddress = Ccc::getModel('Customer_Address_Row');
	// 		$billingAddress->customer_id=$customer->customer_id;
	// 	}
	// 		$billingAddress->setData($postBilling);
	// 		$billingAddress->save();
	// 		$customer->billing_id=$billingAddress->address_id;


	// 		$postShipping = $this->getRequest()->getpost('shippingAddress');
	// 		if (!$postShipping) {
	// 			throw new Exception("no data posted");
	// 		}
	// 		if ($id = (int)$this->getRequest()->getParams('id')) {
	// 			$shippingId = $customer->shipping_id;
	// 			$shippingAddress = $customer->getShippingAddress($shippingId);
	// 		if (!$shippingAddress) {
	// 			throw new Exception("Invalid id.", 1);
	// 		}
	// 	}
	// 	else{
	// 		$shippingAddress = Ccc::getModel('Customer_Address_Row');
	// 		$shippingAddress->customer_id=$customer->customer_id;
	// 	}
	// 		$shippingAddress->setData($postShipping);
	// 		$shippingAddress->save();
	// 		$customer->shipping_id = $shippingAddress->address_id;
	// 		$customer->setData($data);
	// 		$customer->save();
	// 	}

	// 	catch(Exception $e){	
	// 			echo "catch found";
	// 	}
	// 	$this->redirect('grid', 'customer', null, true);
	// }

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request.", 1);
			}

			$customer = $this->saveCustomer();
			$billingAddress = $this->saveBillingAddress($customer);
			$shippingAddress = $this->saveShippingAddress($customer);
			$customer->billing_id = $billingAddress->address_id;
			$customer->shipping_id = $shippingAddress->address_id;

			if (!$customer->save()) {
				throw new Exception("Customer data not saved.", 1);
			}

		} catch (Exception $e) {
			
		}
		$this->redirect('grid', 'customer', null, true);
	}

	public function saveCustomer()
	{
		$customerPost = $this->getRequest()->getPost('customer');
		// print_r($customerPost); die();
		if (!$customerPost) {
			throw new Exception("Data not found.", 1);
		}

		if ($id = (int) $this->getRequest()->getParams('id')) {
			$customer = Ccc::getModel('Customer_Row')->load($id);
			if (!$customer) {
				throw new Exception("Data not found.", 1);
			}
			$customer->updated_at = date('Y-m-d h:i:s');
			
		} else {
			$customer = Ccc::getModel('Customer_Row');
			$customer->inserted_at = date('Y-m-d h-i-s');
		}

		$customer->setData($customerPost);

		if (!$customer->save()) {
			throw new Exception("Customer data not saved Succesfully.", 1);
		} else {
			return $customer;
		}
	}

	public function saveBillingAddress($customer)
	{
		$billingData = $this->getRequest()->getPost('billingAddress');
		if (!$billingData) {
			throw new Exception("Data not found.", 1);
		}

		$bId = $customer->billing_address_id;

		$billingAddress = $customer->getBillingAddress($bId);
		if (!$billingAddress) {
			$billingAddress = Ccc::getModel('Customer_Address_Row');
			$billingAddress->customer_id = $customer->customer_id;
		}

		$billingAddress->setData($billingData);
		if (!$billingAddress->save()) {
			throw new Exception("Billing Address Data not saved.", 1);
		} else {
			return $billingAddress;
		}
	}

	public function saveShippingAddress($customer)
	{
		$shippingData = $this->getRequest()->getPost('shippingAddress');
		if (!$shippingData) {
			throw new Exception("Data not found.", 1);
		}
		
		$sId = $customer->shipping_address_id;

		$shippingAddress = $customer->getShippingAddress($sId);
		if (!$shippingAddress) {
			$shippingAddress = Ccc::getModel('Customer_Address_Row');
			$shippingAddress->customer_id = $customer->customer_id;
		} 

		$shippingAddress->setData($shippingData);
		if (!$shippingAddress->save()) {
			throw new Exception("Shipping Address Data not saved.", 1);
		} else {
			return $shippingAddress;
		}
	}
	

	public function deleteAction()
	{
		try
		{
		$message=Ccc::getModel('Core_Message');
		$request=$this->getRequest();
		$id = (int) $request->getParams('id');
		if(!$id){
			throw new Exception("Invalid ID.", 1);
		}
		$customerModeRow = Ccc::getModel('Customer'); 
		$customerModeRow->load($id);
		$customerResult = $customerModeRow->delete();
		if(!$customerResult)
		{
			throw new Exception("Error Data is Not Deleted", 1);
		}
		$message->addMessage('Customer Deleted Successfully',Model_Core_Message::SUCCESS);
		}
		catch(Exception $e)
		{
			$message->addMessage('Customer is Not Deleted',Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}

}

?>