<?php 


/**
 * 
 */
class Block_Core_Template extends Model_Core_View
{
	
	protected $children=[];
	protected $layout=null;
	//auto run when obj of class
	public function __construct()
	{
		//view parent calling
	    parent::__construct();
	
	}
	//getter setter of layout
	public function setLayout(Block_Core_Layout $layout)
	{
		$this->layout = $layout;
	}

	public function getLayout()
	{
		return $this->layout;
	}
	//to set the children in array of children
	public function setChildren(array $children)
	{
		$this->children = $children;
		return $this;
	}
	//to get the children from array children
	public function getChildren()
	{
		return $this->children;
	}
	//to unset any key means remove from children array
	public function removeChildren($key)
	{
		if (array_key_exists($key,$this->children)) {
			unset($this->children[$key]);
		}
		return false;
	}
      //add the child with key value pair basis
	public function addChild($key,$value)
	{
		$this->children[$key]=$value;
		return $this;
	}
	//to get the children with help of key
	public function getChild($key)
	{
		if (!array_key_exists($key,$this->children)) {
			return false;
		}
		return $this->children[$key];
	}
	//to get the childhtmlcontent
	public function getChildHtml($key)
	{
		if(!$key){
			return false;
		}

		$child = $this->getChild($key);
		if($child){
			return $child->toHtml();
		}
		return false;
	}

	//to catch the template of html without direct rendering

	public function toHtml()
	{
		ob_start();
		$this->render();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}






}

?>