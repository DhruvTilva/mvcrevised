<?php 


protected $_totalRecords = Null;
protected $_recordPerPage = 10;
protected $_currentPage = Null;
protected $_numberOfPage = Null;
protected $_start = 1;
protected $_previous = Null;
protected $_next = Null;
protected $_end = Null;
protected $_startLimit = Null;
protected $_recordPerPageOption = [10,20,50,100];



public function __construct($totalRecords, $currentPage)
{			
	$this->setTotalRecords($totalRecords);
	$this->setCurrentPage($currentPage);	
}

 public function getTotalRecords()
 {
    return $this->_totalRecords;
 }

 public function setTotalRecords($_totalRecords)
 {
    $this->_totalRecords = $_totalRecords;

    return $this;
}

public function getCurrentPage()
{
    return $this->_currentPage;
 }

public function setCurrentPage($currentPage)
{
    $this->_currentPage = $currentPage;

    return $this;
 }

 public function getRecordPerPage()
 {
    return $this->_recordPerPage;
 }

 public function setRecordPerPage($recordPerPage)
 {
    $this->_recordPerPage = $recordPerPage;

    return $this;
 }

 public function getNumberOfPage()
    {
        return $this->_numberOfPage;
    }

    public function setNumberOfPage($numberOfPage)
    {
        $this->_numberOfPage = $numberOfPage;

        return $this;
    }

    public function getStart()
    {
        return $this->_start;
    }

    public function setStart($start)
    {
        $this->_start = $start;

        return $this;
    }

    public function getPrevious()
    {
        return $this->_previous;
    }

    public function setPrevious($previous)
    {
        $this->_previous = $previous;

        return $this;
    }

    public function getNext()
    {
        return $this->_next;
    }

    public function setNext($next)
    {
        $this->_next = $next;

        return $this;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function setEnd($end)
    {
        $this->_end = $end;

        return $this;
    }

    public function getStartLimit()
    {
        return $this->_startLimit;
    }

    public function setStartLimit($startLimit)
    {
        $this->_startLimit = $startLimit;

        return $this;
    }

    public function getRecordPerPageOption()
    {
        return $this->_recordPerPageOption;
    }
    public function calculate()
	{
        $this->setNumberOfPage(ceil($this->getTotalRecords()/$this->getRecordPerPage()));

        if($this->getNumberOfPage() <= 0){
            $this->setCurrentPage(0);
        }

        $this->setPrevious($this->getCurrentPage()-1);

        $this->setNext($this->getCurrentPage() + 1);
        if($this->getCurrentPage() >= $this->getNumberOfPage()){
            $this->setNext(0);
        }

        $this->setStart(1);
        if($this->getStart() == $this->getCurrentPage()){
            $this->setStart(0);
        }
        
        $this->setEnd($this->getNumberOfPage());
        if($this->getEnd() == $this->getCurrentPage()){
            $this->setEnd(0);
        }

        $this->setStartLimit(($this->getCurrentPage()-1) * $this->getRecordPerPage());
	}
?>