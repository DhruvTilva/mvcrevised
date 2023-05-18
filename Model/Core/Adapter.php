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
		// $connection = new PDO('mysql:host=localhost;dbname=newmvc-dhruvtilva;charset=utf8mb4', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
	public function fetchOne($sql)
	{
		$result = $this->query($sql);
		if($result->num_rows == 0){
			return Null;
		}

		$oneRow = $result->fetch_array();
		return (array_key_exists(0, $oneRow)) ? $oneRow[0] : null;
	}


	public function fetchPairs($query)
	{
		$fetchPairs=$this->query($query);
		if(!$fetchPairs){
			return False;
		}
		$data = $fetchPairs->fetch_all();

		$column1=array_column($data, '0');
		$column2=array_column($data, '1');
		if (!$column2) {
			$column2=array_fill(0, count($column2), null);
		}
		return array_combine($column1,$column2);
	}



}


?>