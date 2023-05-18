<?php 



class Controller_Eav_Attribute extends Controller_Core_Action 
{
	public function render()
	{
		return $this->getView()->render();
	}
	
	public function gridAction()
	{ 
		

		$layout = new Block_Core_Layout();
		$grid = $layout->createBlock('Eav_Attribute_Grid');
		$layout->getChild('content')->addChild('grid',$grid);
		echo $layout->toHtml();

	
	}
	

	public function addAction()
	{
		$message = Ccc::getModel('Core_Message');
		try 
		{
			$attribute = Ccc::getModel('Eav_Attribute');
			if(!$attribute){
				throw new Exception("Invalid request.", 1);
			}
			
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Eav_Attribute_Edit');
			$edit->setData(['attribute'=>$attribute]);
			$layout->getChild('content')->addChild('edit',$edit);
			echo $layout->toHtml();

		} 
		catch (Exception $e) 
		{	//message classs of failure
			$message->addMessage('Attribute not Saved.',Model_Core_Message::FAILURE);
			// $this->redirect('grid');
			$this->redirect('grid',null,null,true);

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
			$attribute=Ccc::getModel('Eav_Attribute')->load($id);
			$options=Ccc::getModel('Eav_Attribute_Option')->load($id);
			if(!$attribute){
				throw new Exception("Invalid Id.", 1);
			}
			$layout = new Block_Core_Layout();
			$edit = $layout->createBlock('Eav_Attribute_Edit');
			$edit->setData(['attribute'=>$attribute,'options'=>$options]);
			$layout->getChild('content')
					->addChild('edit',$edit);
			// $layout->render();
			echo $layout->toHtml();
		} 
		catch (Exception $e) 
		{//message classs of failure
			$message->addMessage('Attribute Not Saved',Model_Core_Message::FAILURE);
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
		$attributeModeRow = Ccc::getModel('Eav_Attribute'); 
		$attributeModeRow->load($id);
		$attributeResult = $attributeModeRow->delete();
		if(!$attributeResult)
		{
			throw new Exception("Error Data is Not Deleted", 1);
		}
		//message class of success 
		$message->addMessage('Attribute Deleted Successfully',Model_Core_Message::SUCCESS);
		}
		catch(Exception $e)
		{
			$message->addMessage('Attribute is Not Deleted',Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}

	public function saveAttribute()
	{
		$request=Ccc::getModel('Core_Request');
		$data = $request->getPost('attribute');
		if (!$data) {
				throw new Exception("no data posted");
			}
		$id=$request->getParams('id');
		if ($id) {
			$attribute=Ccc::getModel('Eav_Attribute')->load($id);
		}
		else{
			
			$attribute= Ccc::getModel('Eav_Attribute');
		}
			
		$attribute->setData($data);
		$attribute->save();

		return $attribute;
		
	}
	


	public function saveAction()
	{
		try{
			$request=Ccc::getModel('Core_Request');
			if(!$request->isPost()){
				throw new Exception("Error Request");
			}
			$attribute = $this->saveAttribute();
			$attributeId = $attribute->getId();
			$options = $request->getPost('options');

			if (!$options) {
				throw new Exception("no options posted");
			}
			if (array_key_exists('exits',$postData['option'])) {
				$query = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = $attributeId";
				$attributeModel = Ccc::getModel('Core_Eav_Attribute_Option');
				$attributeOption = $attributeModel->fetchAll($query);
				if ($attributeOption) {
					foreach ($attributeOption->getData() as $row) {
						if (!array_key_exists($row->option_id,$postData['option']['exits'])) {
							$row->setData(['option_id' => $row->option_id]);
							if (!$row->delete()) {
								throw new Exception("Error Processing Request", 1);
								
							}
						}
					}
				}
			}
			foreach ($postOptions as $key => $value) {
				if($key == 'new'){
					$count = 0;
					foreach ($value as $value1) {
						if($value1){
							$option = Ccc::getModel('Eav_Attribute_Option');
							$option->setData([
								'attribute_id'=>$attributeId,
								'name'=>$value1,
								
							]);
							if(!$option->save()){
								throw new Exception("Unable to save option.", 1);
							}
							$count++;
						}
					}
				}
				else{
					foreach ($value as $optionId => $value1) {
						if($value1){
							$option = Ccc::getModel('Eav_Attribute_Option')
								->load($optionId);
							$option->setData([
								'name'=>$value1,
								'position'=>$postPosition['exist'][$optionId]
							]);
							if(!$option->save()){
								throw new Exception("Unable to save option.", 1);
							}
						}
					}
				}
			}
	// 		$id=$request->getParams('id');
	// 		if ($id) {
	// 			$optionobj=Ccc::getModel('Eav_Attribute_Option');
				
	// 		}
	// 		else{
			
	// 			$optionobj= Ccc::getModel('Eav_Attribute_Option');
	// 		}
			
	// 		$optionobj->setData($options);
	// 		$optionobj->save();
			$message=Ccc::getModel('Core_Message');
			$message->addMessage('A..saved successfully.', Model_Core_Message::SUCCESS);
			$this->redirect('grid','eav_attribute',null,true);
		}
		catch(Exception $e){
			$message=Ccc::getModel('Core_Message');
			$message->addMessage('A.. not saved.', Model_Core_Message::FAILURE);
			$this->redirect('grid',null,null,true);

		}
	}


}
?>