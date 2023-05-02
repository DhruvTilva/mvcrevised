<?php

/**
 * 
 */

class Model_Core_Adapter 
{
	
	public $servername = "localhost";
	public $username = "root";
	public $password = "";
	public $dbname = "newmvc-dhruvtilva";



	//to make connection
	public function connect()
	{
		$connection=mysqli_connect($this->servername,$this->username,$this->password,$this->dbname);
		return $connection;
	}

	//to run query
	public function query($query)
	{
		$connect=$this->connect();
		return $connect->query($query);
	}

	public function fetchAll($query)
	{
		$fetchAll=$this->query($query);
		if (!$fetchAll) {
			return false;
		}
		return $fetchAll->fetch_all(MYSQLI_ASSOC);
	}


	public function fetchRow($query)
	{
		$fetchRow=$this->query($query);
		if (!$fetchRow) {
			return false;
		}
		return $fetchRow->fetch_assoc();
	}

	public function insert($query)
	{
		$connect = $this->connect();
		$insertRow = $connect->query($query);
		if (!$insertRow) {
				return false;
		}
		return $connect->insert_id;
	}

	public function update($query)
	{
		$updateRow = $this->query($query);
		if (!$updateRow) {
			return false;
		}
		return true;
	}

	public function delete($query)
	{
		$deleteRow = $this->query($query);
		if(!$deleteRow){
			return false;
		}
		return true;
	}



}


?>