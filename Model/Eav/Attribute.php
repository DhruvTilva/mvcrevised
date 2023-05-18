<?php

/**
 * 
 */
class Model_Eav_Attribute extends Model_Core_Table
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE_lBl = 'Active';
	const STATUS_INACTIVE_lBl = 'Inactive';
	const STATUS_DEFAULT = 2;
	
	public function __construct()
	{
		$this->setResourceClass('Model_Eav_Attribute_Resource')->setCollectionClass('Model_Eav_Attribute_Collection');
	}

	public function getStatus()
	{
		if($this->status){
			return $this->status;
		}
		return self::STATUS_DEFAULT;
	}

	public function getStatusText()
	{
		$statuses = $this->getResource()->getStatusOptions();
		if(array_key_exists($this->status, $statuses)){
			return $statuses[$this->status];
		}
		return $statuses[self::STATUS_DEFAULT];
	}

	public function getEntityType()
	{
		$sql = "SELECT `entity_type_id`,`name` FROM `entity_type` ORDER BY `entity_type_id`";
		return $this->getResource()->getAdapter()->fetchPairs($sql);
	}

	public function getOptions()
	{	
		// echo "<pre>";
		// print_r($this->getId()); die();
		$sql = "SELECT `option_id`,`name` FROM `eav_attribute_option` WHERE `attribute_id` = {$this->getId()} ";
		$pair = $this->getResource()->getAdapter()->fetchPairs($sql);
		if ($pair) {
			return $pair;
		}
		return $this;


		// $sql = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = `{$this->getId()}`";
		// $options = Ccc::getModel('Eav_Attribute_Option')->fetchAll($sql);
		// return $options;

		//  $sql = "SELECT * 
        // FROM `eav_attribute_option` 
        // WHERE `attribute_id` = '{$this->getAttribute()->getId()}' 
        // ORDER BY `position` ASC";
        // return $this->fetchAll($sql);
		
	}
	

	
}