<?php 



class Controller_Product extends Controller_Core_Action 
{
	public function render()
		{
			return $this->getView()->render();
		}
	
	public function gridAction()
	{
			try {
			$query = "SELECT * FROM `product`";
			$products = Ccc::getModel('Product_Row')->fetchAll($query);
			if (!$products) {
				throw new Exception("Products not found", 1);
			}
			// $this->getView()->setTemplate('product/grid.phtml')->setData(['products'=>$products]);
			// $this->render();
			$layout = new Block_Core_Layout();
			$grid = $layout->createBlock('Product_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
			
		} catch (Exception $e) {
			echo "catch found";
		}
	}
	

	public function addAction()
	{
		$this->getView()->setTemplate('product/add.phtml');
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

	

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `product` WHERE `product_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=Product&a=grid");
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
				$product=Ccc::getModel('Product_Row')->load($id);
				date_default_timezone_set('Asia/Kolkata');
				$product->updated_at=date('Y-m-d H:i:s');
				
			}
			else{
				// echo 222; die();

				$product= Ccc::getModel('Product_Row');
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
			
		}
		catch(Exception $e){	
				echo "catch found";
		}
		$this->redirect('grid', 'product', null, true);
	}

}
?>