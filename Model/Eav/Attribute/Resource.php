<?php 

/**
 * 
 */
class Model_Eav_Attribute_Resource extends Model_Core_Table_Resource
{  
    public function __construct()
    {
        $this->setTableName('eav_attribute')->setPrimaryKey('attribute_id');
    }

    public function getStatusOptions()
    {
        return [
            Model_Eav_Attribute::STATUS_ACTIVE => Model_Eav_Attribute::STATUS_ACTIVE_lBl,
            Model_Eav_Attribute::STATUS_INACTIVE => Model_Eav_Attribute::STATUS_INACTIVE_lBl
        ];
    }
}