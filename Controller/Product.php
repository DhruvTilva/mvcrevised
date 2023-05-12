<?php 



class Controller_Product extends Controller_Core_Action 
{
	public function render()
		{
			return $this->getView()->render();
		}
	
	public function gridAction()
	{
			$layout = new Block_Core_Layout();
			$grid = $layout->createBlock('Product_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			echo $layout->toHtml();
	
	}
	

	public function addAction()
	{
		$message = Ccc::getModel('Core_Message');
		try 
		{
			$product = Ccc::getModel('Product');
			if(!$product){
				throw new Exception("Invalid request.", 1);
			}
			
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Product_Edit');
			$edit->setData(['product'=>$product]);
			$layout->getChild('content')->addChild('edit',$edit);
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Product not Saved.',Model_Core_Message::FAILURE);
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
			

			$product=Ccc::getModel('Product')->load($id);
			if(!$product){
				throw new Exception("Invalid Id.", 1);
			}

			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Product_Edit');
			$edit->setData(['product'=>$product]);
			$layout->getChild('content')
					->addChild('edit',$edit);
			// $layout->render();
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{
			$message->addMessage('Product Not Saved',Model_Core_Message::FAILURE);
			$this->redirect('grid');
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
		$productModeRow = Ccc::getModel('Product'); 
		$productModeRow->load($id);
		$productResult = $productModeRow->delete();
		if(!$productResult)
		{
			throw new Exception("Error Data is Not Deleted", 1);
		}
		$message->addMessage('Product Deleted Successfully',Model_Core_Message::SUCCESS);
		}
		catch(Exception $e)
		{
			$message->addMessage('Product is Not Deleted',Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}

	public function saveAction()
	{
		try{
			$request=Ccc::getModel('Core_Request');
			if(!$request->isPost()){
				throw new Exception("Error Request");
			}
			$data = $request->getPost('product');
			// print_r($data); die();

			if (!$data) {
				throw new Exception("no data posted");
			}
			$id=$request->getParams('id');
			// print_r($id); die();
			if ($id) {
				// echo 111; die();
				$product=Ccc::getModel('Product')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$product->updated_at=date('Y-m-d H:i:s');
				
			}
			else{
				// echo 222; die();

				$product= Ccc::getModel('Product');
				date_default_timezone_set('Asia/Kolkata');
				$product->inserted_at = date("Y-m-d h:i:s");
				// print_r($product); die();
			}
			$product->setData($data);
			// echo "<pre>";
			// print_r($product);
			// die;
			$product->save();
			// print_r($result); die();
			
			$message=Ccc::getModel('Core_Message');
			$message->addMessage('Product saved successfully.', Model_Core_Message::SUCCESS);
			$this->redirect('grid');

		}
		catch(Exception $e){	
			$message=Ccc::getModel('Core_Message');
			$message->addMessage('Product not saved.', Model_Core_Message::FAILURE);
		}
		$this->redirect('grid', 'product', null, true);
	}

}
?>