<?php 
require_once 'Model/Core/Table.php';

class Model_Product extends Model_Core_Table
{
			

	protected $resourceClass = 'Model_Product_Resource';
    protected $collectionClass= 'Model_Core_Table_Collection';


	public function getStatusText()
    {
        $statues = $this->getResource()->getStatusOptions();
        if(array_key_exists($this->status,$statues)){
            return $statues[$this->status];
        }
        return $statues[Model_Product_Resource::STATUS_DEFAULT];
    }

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Product_Resource::STATUS_DEFAULT;
    }
}

?>