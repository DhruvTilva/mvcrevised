<?php 


class Controller_Customer extends Controller_Core_Action 
{
	
	public function gridAction()
	{
			try {
			$query = "SELECT * FROM `customer`";
			$customers = Ccc::getModel('Customer_Row')->fetchAll($query);
			if (!$customers) {
				throw new Exception("Customers not found", 1);
			}
			$this->getView()->setTemplate('customer/grid.phtml')->setData(['customers'=>$customers]);
			$this->render();
		} catch (Exception $e) {
			echo "catch found";
		}
	}

	public function addAction()
	{
		$this->getView()->setTemplate('customer/add.phtml');
		$this->render();
	}

	public function editAction()
	{
			$request = $this->getRequest();
			$id = $request->getParams('id');
			$product = Ccc::getModel('Product_Row')->load($id);
			$this->getView()->setTemplate('product/edit.phtml')->setData(['product' => $product]);
			$this->render();
	}

	public function saveAction()
	{
		try{
			$request=Ccc::getModel('Core_Request');
			if(!$request->isPost()){
				throw new Exception("Error Request");
			}
			$customer = $request->getPost('customer');
        	$address = $request->getPost('address');

			$id=$request->getParams('id');

			$customerModelRow=Ccc::getModel('Customer_Row');
			
			if ($id) {
				$customerModelRow->setData($customer);
				$customerModelRow->getData();
				
				$customerResult = $customerModelRow->save();

			
				$customerAddressModelRow=Ccc::getModel('CustomerAddress_Row');
				$customerAddressModelRow->setData($address);
				$customerAddressModelRow->getPrimaryKey();
				$customerResult = $customerAddressModelRow->save();
			}
			else{
				$customerModelRow=Ccc::getModel('Customer_Row');
				$customerModelRow->setData($customer);
				$customerResult = $customerModelRow->save();
				$address['customer_id'] = $customerResult;
				$customerAddressModelRow=Ccc::getModel('CustomerAddress_Row');
				$customerAddressModelRow->setData($address);
				$customerResult = $customerAddressModelRow->save();

			}
			
			$this->redirect('grid');
		}
		catch(Exception $e){
	
			$this->redirect('grid');
		}
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `customer` WHERE `customer_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=customer&a=grid");
	}

}

?>