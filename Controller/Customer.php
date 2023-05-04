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
			$customer = Ccc::getModel('Customer_Row')->load($id);
			$customerAddress = Ccc::getModel('Customer_Address_Row')->load($id);
			$this->getView()->setTemplate('customer/edit.phtml')->setData(['customer' => $customer,'address' =>$customerAddress]);
			$this->render();
	}

	public function saveAction()
	{
		try{
			$request=Ccc::getModel('Core_Request');
			if(!$request->isPost()){
				throw new Exception("Error Request");
			}
			$data = $request->getPost('customer');
			if (!$data) {
				throw new Exception("no data posted");
			}
			$id=$request->getParams('id');
			if ($id) {
				$customer=Ccc::getModel('Customer_Row')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$customer->updated_at=date('Y-m-d H:i:s');
			}
			else{
				$customer= Ccc::getModel('Customer_Row');
				date_default_timezone_set('Asia/Kolkata');
				$customer->inserted_at = date("Y-m-d h:i:s");
			}
			$customer->setData($data);
			$customer->save();

			$postDataAddress = $this->getRequest()->getpost('address');
			// print_r($postDataAddress); die();
			if (!$postDataAddress) {
				throw new Exception("no data posted");
			}
		
			if ($id = (int)$this->getRequest()->getParams('id')) {
			$customerAddress = Ccc::getModel('Customer_Address_Row')->load($id);
			if (!$customerAddress) {
				throw new Exception("Invalid id.", 1);
			}
		}
		else{
			$customerAddress = Ccc::getModel('Customer_Address_Row');
			$customerAddress->customer_id = $customer->customer_id;
		}
			$customerAddress->setData($postDataAddress);
			$customerAddress->save();
		}
		catch(Exception $e){	
				echo "catch found";
		}
		$this->redirect('grid', 'customer', null, true);
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