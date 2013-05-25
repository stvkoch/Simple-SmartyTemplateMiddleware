<?php
namespace SmartyTemplate\Lib;


/**
* 
*/
class SmartyExt extends Smarty
{
    protected $backbone;

    public function __construct($backbone)
    {
        $this->backbone = $backbone;
    }

    public function getResourceById($resourceId)
    {
        return $this->backbone->getResourceById($resourceId);
    }
}