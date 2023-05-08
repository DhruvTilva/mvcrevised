<?php

class Controller_Vendor extends Controller_Core_Action 
{
	public function render()
		{
			return $this->getView()->render();
		}
	
	public function gridAction()
	{
		try {
			// $query = "SELECT * FROM `vendor`";
			// $vendors = Ccc::getModel('Vendor_Row')->fetchAll($query);
			// if (!$vendors) {
			// 	throw new Exception("Vendors not found", 1);
			// }
			// $this->getView()->setTemplate('vendor/grid.phtml')->setData(['vendors'=>$vendors]);
			// $this->render();
			$layout = new Block_Core_Layout();
			$grid = $layout->createBlock('Vendor_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			// echo $layout->toHtml();
			$layout->render();
		} catch (Exception $e) {
			echo "catch found";
		}
	}



	public function addAction()
	{
		$message = Ccc::getModel('Core_Message');
		try 
		{
			$vendor = Ccc::getModel('Vendor');
			if(!$vendor){
				throw new Exception("Invalid request.", 1);
			}
			
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Vendor_Edit');
			$edit->setData(['vendor'=>$vendor]);
			$layout->getChild('content')->addChild('edit',$edit);
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Vendor not Saved.',Model_Core_Message::FAILURE);
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
			

			$vendor=Ccc::getModel('Vendor')->load($id);
			if(!$vendor){
				throw new Exception("Invalid Id.", 1);
			}

			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Vendor_Edit');
			$edit->setData(['vendor'=>$vendor]);
			$layout->getChild('content')
					->addChild('edit',$edit);
			// $layout->render();
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Vendor Not Saved',Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
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
				$vendor=Ccc::getModel('Vendor')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$vendor->updated_at=date('Y-m-d H:i:s');
			}
			else{
				$vendor= Ccc::getModel('Vendor');
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
			$vendorAddress = Ccc::getModel('Vendor_Address')->load($id);
			if (!$vendorAddress) {
				throw new Exception("Invalid id.", 1);
			}
		}
		else{
			$vendorAddress = Ccc::getModel('Vendor_Address');
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
		try
		{
		$message=Ccc::getModel('Core_Message');
		$request=$this->getRequest();
		$id = (int) $request->getParams('id');
		if(!$id){
			throw new Exception("Invalid ID.", 1);
		}
		$vendorModeRow = Ccc::getModel('Vendor'); 
		$vendorModeRow->load($id);
		$vendorResult = $vendorModeRow->delete();
		if(!$vendorResult)
		{
			throw new Exception("Error Data is Not Deleted", 1);
		}
		$message->addMessage('Vendor Deleted Successfully',Model_Core_Message::SUCCESS);
		}
		catch(Exception $e)
		{
			$message->addMessage('Vendor is Not Deleted',Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}
}
?>