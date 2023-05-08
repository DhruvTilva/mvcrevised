<?php

class Controller_Salesman extends Controller_Core_Action 
{
	public function render()
		{
			return $this->getView()->render();
		}
	
	public function gridAction()
	{
		try {
			$layout = new Block_Core_Layout();
			$grid = $layout->createBlock('Salesman_Grid');
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
			$salesman = Ccc::getModel('Salesman');
			if(!$salesman){
				throw new Exception("Invalid request.", 1);
			}
			
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Salesman_Edit');
			$edit->setData(['salesman'=>$salesman]);
			$layout->getChild('content')->addChild('edit',$edit);
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Salesman not Saved.',Model_Core_Message::FAILURE);
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
			

			$salesman=Ccc::getModel('Salesman')->load($id);
			$salesmanAddress=Ccc::getModel('Salesman_Address')->load($id);
			if(!$salesman){
				throw new Exception("Invalid Id.", 1);
			}

			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Salesman_Edit');
			$edit->setData(['salesman'=>$salesman,'address'=>$salesmanAddress]);
			$layout->getChild('content')
					->addChild('edit',$edit);
			// $layout->render();
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Salesman Not Saved',Model_Core_Message::FAILURE);
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
			$data = $request->getPost('salesman');
			if (!$data) {
				throw new Exception("no data posted");
			}
			$id=$request->getParams('id');
			if ($id) {
				$salesman=Ccc::getModel('Salesman')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$salesman->updated_at=date('Y-m-d H:i:s');
			}
			else{
				$salesman= Ccc::getModel('Salesman');
				date_default_timezone_set('Asia/Kolkata');
				$salesman->inserted_at = date("Y-m-d h:i:s");
			}
			$salesman->setData($data);
			$salesman->save();

			$postDataAddress = $this->getRequest()->getpost('address');
			// print_r($postDataAddress); die();
			if (!$postDataAddress) {
				throw new Exception("no data posted");
			}
		
			if ($id = (int)$this->getRequest()->getParams('id')) {
			$salesmanAddress = Ccc::getModel('Salesman_Address')->load($id);
			if (!$salesmanAddress) {
				throw new Exception("Invalid id.", 1);
			}
		}
		else{
			$salesmanAddress = Ccc::getModel('Salesman_Address');
			$salesmanAddress->salesman_id = $salesman->salesman_id;
		}
			$salesmanAddress->setData($postDataAddress);
			$salesmanAddress->save();
		}
		catch(Exception $e){	
				echo "catch found";
		}
		$this->redirect('grid', 'salesman', null, true);
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
		$salesmanModeRow = Ccc::getModel('Salesman'); 
		$salesmanModeRow->load($id);
		$salesmanResult = $salesmanModeRow->delete();
		if(!$salesmanResult)
		{
			throw new Exception("Error Data is Not Deleted", 1);
		}
		$message->addMessage('Salesman Deleted Successfully',Model_Core_Message::SUCCESS);
		}
		catch(Exception $e)
		{
			$message->addMessage('Salesman is Not Deleted',Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}
	
}
?>