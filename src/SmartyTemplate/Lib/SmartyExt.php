<?php
namespace SmartyTemplate\Lib;


/**
* 
*/
class SmartyExt extends \Smarty
{
    protected $backbone;

    public function __construct($backbone)
    {
        $this->backbone = $backbone;
        parent::__construct();
    }

    public function getResourceById($resourceId)
    {
        return $this->backbone->getResourceById($resourceId);
    }
}