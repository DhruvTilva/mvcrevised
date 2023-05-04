<?php

class Controller_Salesman extends Controller_Core_Action 
{
	
	public function gridAction()
	{
		try {
			$query = "SELECT * FROM `salesman`";
			$salesmans = Ccc::getModel('Salesman_Row')->fetchAll($query);
			if (!$salesmans) {
				throw new Exception("Vendors not found", 1);
			}
			$this->getView()->setTemplate('salesman/grid.phtml')->setData(['salesmans'=>$salesmans]);
			$this->render();
		} catch (Exception $e) {
			echo "catch found";
		}
	}



	public function addAction()
	{
		$this->getView()->setTemplate('salesman/add.phtml');
		$this->render();
	}

	public function editAction()
	{
			$request = $this->getRequest();
			$id = $request->getParams('id');
			$salesman = Ccc::getModel('Salesman_Row')->load($id);
			$salesmanAddress = Ccc::getModel('Salesman_Address_Row')->load($id);
			$this->getView()->setTemplate('salesman/edit.phtml')->setData(['salesman' => $salesman,'address' =>$salesmanAddress]);
			$this->render();
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
				$salesman=Ccc::getModel('Salesman_Row')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$salesman->updated_at=date('Y-m-d H:i:s');
			}
			else{
				$salesman= Ccc::getModel('Salesman_Row');
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
			$salesmanAddress = Ccc::getModel('Salesman_Address_Row')->load($id);
			if (!$salesmanAddress) {
				throw new Exception("Invalid id.", 1);
			}
		}
		else{
			$salesmanAddress = Ccc::getModel('Salesman_Address_Row');
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
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `salesman` WHERE `salesman_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=salesman&a=grid");
	}
}
?>