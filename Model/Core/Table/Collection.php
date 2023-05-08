
<?php

/**
 * 
 */
class Model_Core_Table_Collection
{
	
	protected $data=[];

	public function setData($data)			
	{
		$this->data=$data;
		// array_merge($this->data,$data);
		return $this;
	}

	public function getData()
	{
		
		return $this->data;
	}

	public function count()
	{
		return count($this->data);
	}

	public function getFirst($data)
	{
		if (count($this->data)>0) {
			return $this->data[0];
		}
		else{
			return null;
		}
	}


	public function getLast($data)
	{
		$lastItem=count($this->data)-1;
		if ($lastItem>=0) {
			return $this->data[$lastItem];
		}
		else{
			return null;
		}
	}
}


?>