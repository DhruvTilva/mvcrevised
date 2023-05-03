<?php 



class Controller_Product extends Controller_Core_Action 
{
	
	public function gridAction()
	{
			try {
			$query = "SELECT * FROM `product`";
			$products = Ccc::getModel('Product_Row')->fetchAll($query);
			if (!$products) {
				throw new Exception("Products not found", 1);
			}
			$this->getView()->setTemplate('product/grid.phtml')->setData(['products'=>$products]);
			$this->render();
		} catch (Exception $e) {
			echo "catch found";
		}
	}
	

	public function addAction()
	{
		$this->getView()->setTemplate('product/add.phtml');
		$this->render();
	}
	

	// public function insertAction()
	// {
	// 		$request = $this->getRequest();
	// 		$postData = $request->getPost('Product');

	// 		$query = "INSERT INTO `product`(`name`, `cost`, `price`, `sku`, `status`, `description`, `color`, `material`) VALUES ('$postData[name]','$postData[cost]','$postData[price]','$postData[sku]','$postData[status]','$postData[description]','$postData[color]','$postData[material]')";
	// 		$adapter = $this->getAdapter();
	// 		$adapter->insert($query);
	// 		// print_r($t);
	// 		header("Location:index.php?c=Product&a=grid");
	// }

	public function editAction()
	{
			$request = $this->getRequest();
			$id = $request->getParams('id');
			$product = Ccc::getModel('Product_Row')->load($id);
			$this->getView()->setTemplate('product/edit.phtml')->setData(['product' => $product]);
			$this->render();
	}

	// public function updateAction()
	// {
	// 		$request = $this->getRequest();
	// 		$postData = $request->getPost('Product');
	// 		$id = $request->getParams('id');

	// 		$query = "UPDATE `product` SET 
	// 						`name`='$postData[name]',
	// 						`cost`='$postData[cost]',
	// 						`price`='$postData[price]',
	// 						`sku`='$postData[sku]',
	// 						`status`='$postData[status]',
	// 						`description`='$postData[description]',
	// 						`color`='$postData[color]',
	// 						`material`='$postData[material]' 
	// 						WHERE `product_id` = {$id}";
	// 		$adapter = $this->getAdapter();
	// 		$adapter->update($query);
	// 		header("Location:index.php?c=Product&a=grid");
	// }

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
			// print_r($data); die;
			if (!$data) {
				throw new Exception("no data posted");
			}
			$id=$request->getParams('id');
			if ($id) {
				$product=Ccc::getModel('Product');
				date_default_timezone_set('Asia/Kolkata');
				$product->updated_at=date('Y-m-d H:i:s');
				// echo"<pre>";
				// print_r($product); die();
			}
			else{
				$product= Ccc::getModel('Product');
				date_default_timezone_set('Asia/Kolkata');
				$product->created_at = date("Y-m-d h:i:s");

			}
			// echo"<pre>";
			$product->setData($data);
			$product->save();
			
			$this->redirect('grid');
		}
		catch(Exception $e){
			
			// $this->redirect('grid');
			echo "catch found"
		}
	}

}
?>