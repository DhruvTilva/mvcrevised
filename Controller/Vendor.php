<?php

class Controller_Vendor extends Controller_Core_Action 
{
	
	public function gridAction()
	{
		try {
			$query = "SELECT * FROM `vendor`";
			$vendors = Ccc::getModel('Vendor_Row')->fetchAll($query);
			if (!$vendors) {
				throw new Exception("Vendors not found", 1);
			}
			$this->getView()->setTemplate('vendor/grid.phtml')->setData(['vendors'=>$vendors]);
			$this->render();
		} catch (Exception $e) {
			echo "catch found";
		}
	}



	public function addAction()
	{
		$this->getView()->setTemplate('vendor/add.phtml');
		$this->render();
	}

	public function editAction()
	{
			$request = $this->getRequest();
			$id = $request->getParams('id');
			$vendor = Ccc::getModel('Vendor_Row')->load($id);
			$vendorAddress = Ccc::getModel('Vendor_Address_Row')->load($id);
			$this->getView()->setTemplate('vendor/edit.phtml')->setData(['vendor' => $vendor,'address' =>$vendorAddress]);
			$this->render();
	}

	public function saveAction()
	{
		try{
			$request=Ccc::getModel('Core_Request');
			if(!$request->isPost()){
				throw new Exception("Error Request");
			}
			$data = $request->getPost('vendor');
			if (!$data) {
				throw new Exception("no data posted");
			}
			$id=$request->getParams('id');
			if ($id) {
				$vendor=Ccc::getModel('Vendor_Row')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$vendor->updated_at=date('Y-m-d H:i:s');
			}
			else{
				$vendor= Ccc::getModel('Vendor_Row');
				date_default_timezone_set('Asia/Kolkata');
				$vendor->inserted_at = date("Y-m-d h:i:s");
			}
			$vendor->setData($data);
			$vendor->save();

			$postDataAddress = $this->getRequest()->getpost('address');
			// print_r($postDataAddress); die();
			if (!$postDataAddress) {
				throw new Exception("no data posted");
			}
		
			if ($id = (int)$this->getRequest()->getParams('id')) {
			$vendorAddress = Ccc::getModel('Vendor_Address_Row')->load($id);
			if (!$vendorAddress) {
				throw new Exception("Invalid id.", 1);
			}
		}
		else{
			$vendorAddress = Ccc::getModel('Vendor_Address_Row');
			$vendorAddress->vendor_id = $vendor->vendor_id;
		}
			$vendorAddress->setData($postDataAddress);
			$vendorAddress->save();
		}
		catch(Exception $e){	
				echo "catch found";
		}
		$this->redirect('grid', 'vendor', null, true);
	}
	

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `vendor` WHERE `vendor_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=vendor&a=grid");
	}
}
?>