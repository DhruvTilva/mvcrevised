 <?php
class Controller_Category extends Controller_Core_Action 
{
    public function render()
        {
            return $this->getView()->render();
        }
    public function gridAction()
    {

        
        
        $layout = new Block_Core_Layout();
            $grid = $layout->createBlock('Category_Grid');
            $layout->getChild('content')->addChild('grid',$grid);
            // echo $layout->toHtml();
            $layout->render();



    } 


    public function addAction()
    {
        $message = Ccc::getModel('Core_Message');
        try 
        {
            $category = Ccc::getModel('Category');
            if(!$category){
                throw new Exception("Invalid request.", 1);
            }
            
            $layout = new Block_Core_Layout();
            $edit = $layout->createBlock('Category_Edit');
            $edit->setData(['category'=>$category]);
            $layout->getChild('content')->addChild('edit',$edit);
            echo $layout->toHtml();

        } 
        catch (Exception $e) 
        {
            $message->addMessage('Category not Saved.',Model_Core_Message::FAILURE);
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
            

            $category=Ccc::getModel('Category')->load($id);
            if(!$category){
                throw new Exception("Invalid Id.", 1);
            }

            $layout = new Block_Core_Layout();
            $edit = $layout->createBlock('Category_Edit');
            $edit->setData(['category'=>$category]);
            $layout->getChild('content')
                    ->addChild('edit',$edit);
            // $layout->render();
            echo $layout->toHtml();

        } 
        catch (Exception $e) 
        {
            $message->addMessage('Category Not Saved',Model_Core_Message::FAILURE);
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
            $data = $request->getPost('category');
            // print_r($data); die();

            if (!$data) {
                throw new Exception("no data posted");
            }
            $id=$request->getParams('id');
            // print_r($id); die();
            if ($id) {
                // echo 111; die();
                $category=Ccc::getModel('Category')->load($id);
                date_default_timezone_set('Asia/Kolkata');
                $category->updated_at=date('Y-m-d H:i:s');
                
            }
            else{
                // echo 222; die();

                $category= Ccc::getModel('category');
                date_default_timezone_set('Asia/Kolkata');
                $category->inserted_at = date("Y-m-d h:i:s");
                // print_r($category); die();
            }
            $category->setData($data);
            // echo "<pre>";
            // print_r($product);
            // die;
            $category->save();
            // print_r($result); die();
            
            $message=Ccc::getModel('Core_Message');
            $message->addMessage('Category saved successfully.', Model_Core_Message::SUCCESS);
            $this->redirect('grid');

        }
        catch(Exception $e){    
                echo "catch found";
        }
        $this->redirect('grid', 'category', null, true);
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
        $categoryModeRow = Ccc::getModel('Category'); 
        $categoryModeRow->load($id);
        $categoryResult = $categoryModeRow->delete();
        if(!$categoryResult)
        {
            throw new Exception("Error Data is Not Deleted", 1);
        }
        $message->addMessage('Category Deleted Successfully',Model_Core_Message::SUCCESS);
        }
        catch(Exception $e)
        {
            $message->addMessage('Category is Not Deleted',Model_Core_Message::FAILURE);
        }
        $this->redirect('grid');

    }
}
?>
 