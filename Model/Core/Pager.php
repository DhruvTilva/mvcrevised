<?php 



class Model_Core_Pager
{
    
    public $totalRecord = 0;
    public $recordPerPage = 10;
    public $numberOfPages = 0;
    public $currentPage = 0;
    public $start = 0;
    public $previous = 0;
    public $next = 0;
    public $end = 0;
    public $startLimit = 0;
    public $recordPerPageOption = [5,10,20,50,100];


    function __construct()
    {
        $this->setCurrentPage();
    }

    public function setTotalRecord($totalRecord)
    {
        $this->totalRecord = $totalRecord;
        return $this;
    }
    public function getTotalRecord()
    {
        return $this->totalRecord;
    }



    public function setRecordPerPage($recordPerPage)
    {
        $this->recordPerPage = $recordPerPage;
        return $this;
    }

    public function getRecordPerPage()
    {
        return $this->recordPerPage;
    }



    public function setNumberOfPages($numberOfPages)
    {
        $this->numberOfPages = $numberOfPages;
        return $this;
    }

    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }



    public function setCurrentPage()
    {
        $request = Ccc::getModel('Core_Request');
        $this->currentPage = (int)$request->getParams('p',1);
        return $this;
    }
    public function getCurrentPage()
    {
        return $this->currentPage;
    }




    public function calculate()
    {
         //number of pages
         $numberOfPages = ceil($this->getTotalRecord()/$this->getRecordPerPage());
         $this->setNumberOfPages($numberOfPages);

         //number of currentpage
         if ($this->getNumberOfPages() == 0) {
                $this->currentPage = 0;
         }
         if ($this->getNumberOfPages() == 1 || ($this->getNumberOfPages()>1 && $this->getCurrentPage()<=0)) {
                $this->currentPage = 1;
         }
         if ($this->getNumberOfPages() < $this->getCurrentPage()) {
                $this->currentPage = $this->getNumberOfPages();
         }


         // start
         $this->start = 1;
         if (!$this->getNumberOfPages()) {      //  <= or == ???
            $this->start = 0;
         }
         if ($this->getCurrentPage() <= 1) {
            $this->start = 0;
         }


         //end
         $this->end = $this->getNumberOfPages();
         if ($this->getCurrentPage() == $this->getNumberOfPages()) {
             $this->end = 0;
         }

         //previous
         $this->previous = ($this->getCurrentPage()-1);
         if ($this->getCurrentPage() <= 1) {
            $this->previous = 0;
         }

         //next
         $this->next = $this->getCurrentPage()+1;
         if ($this->getCurrentPage() == $this->getNumberOfPages()) {
             $this->next = 0;
         }

         //startLimit
         $this->startLimit = ($this->getCurrentPage()-1)*($this->getRecordPerPage());

         return $this;
    }

}



// public $_totalRecords = Null;
// public $_recordPerPage = 10;
// public $_currentPage = Null;
// public $_numberOfPage = Null;
// public $_start = 1;
// public $_previous = Null;
// public $_next = Null;
// public $_end = Null;
// public $_startLimit = Null;
// public $_recordPerPageOption = [10,20,50,100];



// public function __construct($totalRecords, $currentPage)
// {			
// 	// $this->setTotalRecords($totalRecords);
// 	$this->setCurrentPage($currentPage);	
// }

//  public function getTotalRecord()
//  {
//     return $this->_totalRecords;
//  }

//  public function setTotalRecord($_totalRecords)
//  {
//     $this->_totalRecords = $_totalRecords;

//     return $this;
// }

// public function getCurrentPage()
// {
//     return $this->_currentPage;
//  }

// public function setCurrentPage($currentPage)
// {
//     $request =Ccc::getModel('Core_Request');
//     $this->_currentPage = (int)$request->getParams('p',1);
//     return $this;
//  }

//  public function getRecordPerPage()
//  {
//     return $this->_recordPerPage;
//  }

//  public function setRecordPerPage($recordPerPage)
//  {
//     $this->_recordPerPage = $recordPerPage;

//     return $this;
//  }

//  public function getNumberOfPage()
//     {
//         return $this->_numberOfPage;
//     }

//     public function setNumberOfPage($numberOfPage)
//     {
//         $this->_numberOfPage = $numberOfPage;

//         return $this;
//     }

//     public function getStart()
//     {
//         return $this->_start;
//     }

//     public function setStart($start)
//     {
//         $this->_start = $start;

//         return $this;
//     }

//     public function getPrevious()
//     {
//         return $this->_previous;
//     }

//     public function setPrevious($previous)
//     {
//         $this->_previous = $previous;

//         return $this;
//     }

//     public function getNext()
//     {
//         return $this->_next;
//     }

//     public function setNext($next)
//     {
//         $this->_next = $next;

//         return $this;
//     }

//     public function getEnd()
//     {
//         return $this->_end;
//     }

//     public function setEnd($end)
//     {
//         $this->_end = $end;

//         return $this;
//     }

//     public function getStartLimit()
//     {
//         return $this->_startLimit;
//     }

//     public function setStartLimit($startLimit)
//     {
//         $this->_startLimit = $startLimit;

//         return $this;
//     }

//     public function getRecordPerPageOption()
//     {
//         return $this->_recordPerPageOption;
//     }


//     public function calculate()
//     {
//          //number of pages
//          $numberOfPages = ceil($this->getTotalRecord()/$this->getRecordPerPage());
//          $this->setNumberOfPages($numberOfPages);

//          //number of currentpage
//          if ($this->getNumberOfPages() == 0) {
//                 $this->currentPage = 0;
//          }
//          if ($this->getNumberOfPages() == 1 || ($this->getNumberOfPages()>1 && $this->getCurrentPage()<=0)) {
//                 $this->currentPage = 1;
//          }
//          if ($this->getNumberOfPages() < $this->getCurrentPage()) {
//                 $this->currentPage = $this->getNumberOfPages();
//          }


//          // start
//          // $this->start = 1;
//          if (!$this->getNumberOfPages()) {      //  <= or == ???
//             $this->start = 0;
//          }
//          if ($this->getCurrentPage() <= 1) {
//             $this->start = 0;
//          }


//          //end
//          $this->end = $this->getNumberOfPages();
//          if ($this->getCurrentPage() == $this->getNumberOfPages()) {
//              $this->end = 0;
//          }

//          //previous
//          $this->previous = ($this->getCurrentPage()-1);
//          if ($this->getCurrentPage() <= 1) {
//             $this->previous = 0;
//          }

//          //next
//          $this->next = $this->getCurrentPage()+1;
//          if ($this->getCurrentPage() == $this->getNumberOfPages()) {
//              $this->next = 0;
//          }

//          //startLimit
//          $this->startLimit = ($this->getCurrentPage()-1)*($this->getRecordPerPage());

//          return $this;
//     }
?>