<?php 
/**
 * 
 */
class Block_Core_Layout extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('Core/layout/3columns.phtml');
		$this->prepareChildren();
	}


	public function createBlock($block)
    {
        $blockClassName='Block_'.$block;
        $block= new $blockClassName();
        $block->setLayout($this);
        return $block;
    }

	public function prepareChildren()
	{
		$head = $this->createBlock('Html_head');
        $this->addChild('head', $head);

        $header = $this->createBlock('Html_Header');
        $this->addChild('header',$header);

        $content = $this->createBlock('Html_Content');
        $this->addChild('content',$content);

        $left = $this->createBlock('Html_Left');
        $this->addChild('left',$left);

        $right = $this->createBlock('Html_Right');
        $this->addChild('right',$right);
        
        $footer = $this->createBlock('Html_Footer');
        $this->addChild('footer',$footer);
	}
}





?>