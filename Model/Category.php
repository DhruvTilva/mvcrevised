<?php


class Model_Category extends Model_Core_Table
{
	protected $resourceClass = 'Model_Category_Resource';
    protected $collectionClass= 'Model_Core_Table_Collection';

	

	public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if(array_key_exists($this->status,$statues)){
            return $statues[$this->status];
        }
        return $statues[Model_Category_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Category_Resource::STATUS_DEFAULT;
    }
    public function getParentCategories()
    {
        $request = Ccc::getModel('Core_Request');
        if($id = (int) $request->getParams('id')){
            $sql = "SELECT * FROM `category` WHERE `category_id` = '{$id}'";
            $except = Ccc::getModel('Category')->fetchRow($sql);
            $sql = "SELECT `category_id`,`path` FROM `category` WHERE `path` NOT LIKE '{$except->path}=%' AND `path` NOT LIKE '{$except->path}' ORDER BY `path` ASC";
            // print_r($sql); die();
        }
        else{
            $sql = "SELECT `category_id`,`path` FROM `category` ORDER BY `path` ASC";
        }
        return $this->getResource()->getAdapter()->fetchPairs($sql);
    }
    public function updatePath()
    {
        if (!$this->getId()) {
            return false;
        }
        $parent=Ccc::getModel('Category')->load($this->parent_id);
        if (!$parent) {
            $this->path=$this->getId();
        }
        else{
            $this->path=$parent->path.'='.$this->getId();
        }
    }
    public function getPathText($path = Null)
    {
        $path = ($path) ? $path : $this->path;
        $categoryId = explode('=', $path);
        $final = [];
        foreach ($categoryId as $id) {
            if($id > 1){
                $sql = "SELECT `name` FROM `category` WHERE `category_id` = '{$id}'";
                $except = Ccc::getModel('Category')->fetchRow($sql);
                $final[] = $except->name;
            }
        }

        if(!$final){
            return 'Root';
        }
        return implode('=>', $final);
    }
    public function selectPath()
    {
        return str_replace('='.$this->category_id, '', $this->path);
    }

    }


?>