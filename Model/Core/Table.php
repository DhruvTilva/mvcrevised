<?php

/**
 * 
 */


class Model_Core_Table
{
	
	protected $data = [];
	protected $resourceClass='Model_Core_Table_Resource';
	protected $collectionClass='Model_Core_Table_Collection';
	protected $resource=null;
	protected $collection = null;



 public function __construct()
    {
        
    }


	public function __get($key) {
    if (array_key_exists($key, $this->data)) {
      return $this->data[$key];
    } else {
      return null;
    }
  	}


    public function __set($key, $value) {
    $this->data[$key] = $value;
    }

    public function __unset($key){
    	if (array_key_exists($key, $this->data)) {
				unset($this->data[$key]);
		}
    	return $this;
    }

    public function setResourceClass($resourceClass)
	{	
		$this->resourceClass=$resourceClass;
		return $this;
	}


	public function getResourceClass()
	{
		if(!$this->resourceClass){
			return $this->resourceClass;
		}
		$resourceClass = new  $this->resourceClass;
		$this->setResourceClass($resourceClass);
		return $resourceClass;
	}

	public function setCollectionClass($collectionClass)
	{
		$this->collectionClass = $collectionClass;
		return $this;
	}
	public function getCollectionClass()
	{
		if(!$this->collectionClass){
			return $this->collectionClass;
		}
		$collectionClass = new  $this->collectionClass;
		$this->setCollectionClass($collectionClass);
		return $collectionClass;
	}

	public function setTableName($tableName)
	{
		$this->getResource()->setTableName($tableName);
		return $this;
	}

	public function getTableName()
	{
		return $this->getResource()->getTableName();
	}

	public function setPrimaryKey($primaryKey)
	{
		$this->getResource()->setPrimaryKey($primaryKey);
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->getResource()->getPrimaryKey();
	}

	public function setResource($resource)
	{
		$this->resource=$resource;
		return $this;
	}

	public function getResource(){
		if ($this->resource){
			return $this->resource;
		}
		$resource = new ($this->resourceClass)();
		$this->setResource($resource);
		return $resource;
	}
	public function setCollection($collection)
	{
		$this->collection = $collection;
		return $this;
	}

	public function getCollection()
	{
		$collectionClass = $this->collectionClass;
		if ($this->collection!=null) 
		{
			return $this->collection;
		}
		$model = new $collectionClass();
		$this->setCollection($model);
		return $model;
	}

	public function setData($data){
    	$this->data=$data;
    	// array_merge($this->data,$data);
    	return $this;
    }


    public function getData($key=null){
    	if(!$key){
    		return $this->data;
    	}
    	if(!array_key_exists($key,$this->data)){
    		return null;
    	}
    	return $this->data[$key];
    }

    public function addData($key,$value){
		$this->data[$key]=$value;
		return $this;
	}


	public function removeData($key = Null)
	{
		if(!$key){
			$this->data = [];
		}
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}



	public function setId($id)
	{
		$this->data[$this->getResource()->getPrimaryKey()]=(int) $id;
		return $this;
	}

	public function getId()			
	{		
		$primaryKey= $this->getResource()->getPrimaryKey();
		return $this->$primaryKey;	
	}

	

	public function save()
	{
		$resource= $this->getResourceClass();
		$request= new Model_Core_Request();            
		if($request->getParams('id'))
		{
			// echo 111; die();
			$id = $request->getParams('id');
			$resource->setTableName($this->getTableName());
			$resource->setPrimaryKey($this->getPrimaryKey());
			$result=$resource->update($this->data, $id);
			return $result;
		}
		else
		{
			// echo 111; die();
			$resource->setTableName($this->getTableName());
			// $resource->getResourceName();
			$result = $resource->insert($this->data);

			$this->load($result);
		  return $result;
		}
	}


	public function delete()
	{
		// $resource= new Model_Core_resource();
		$resource= $this->getResourceClass();
		$id = $this->data[$this->getPrimaryKey()];
		if (!$id) {
			return false;
		}
		$resource->setTableName($this->getTableName());
		$resource->setPrimaryKey($this->getPrimaryKey());
		$resource->delete($id);
		return $this;
	}



	public function fetchAll($query){
		// $resource = new Model_Core_resource();
		$resource=$this->getResourceClass();
		$result = $resource->fetchAll($query);
		if(!$result){
			return false;
		}
		foreach($result as &$row){
			$row = (new $this)->setData($row)->setResourceClass($this->resourceClass);
		}
		$collection = $this->getCollection()->setData($result);
		return $collection; 
	}




	public function fetchRow($query){
		// $resource = new Model_Core_resource();
		$resource=$this->getResourceClass();
		$result = $resource->fetchRow($query);
		if($result){
		 $this->data = $result;
		 return $this;
		}
		return false;
	}





	public function load($id,$column=null)
	{
		if(!$column){
			$column = $this->getPrimaryKey();
		}
		$sql = "SELECT * FROM `{$this->getResource()->getTableName()}` WHERE `{$column}`= '{$id}'";
		// $table = new Model_Core_Table();
		$resource= $this->getResourceClass();
		$result = $resource->fetchRow($sql);
		if($result){
			$this->data = $result;
		  return $this;
		}
		return null;
	}


}



?>



