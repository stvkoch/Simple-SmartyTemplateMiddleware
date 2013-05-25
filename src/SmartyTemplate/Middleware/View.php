<?php

namespace SmartyTemplate\Middleware;
/*
\Simple\Middleware\Application::definition(
    array(
        'namespace'=>'SmartyTemplate\Middleware',
        'class'=>'View',
        'function'=>'render',
        'id'=>'simple.view'
        'layout'=> \Simple\Config\PHP::get('application', 'layout')
    )
),
*/
class View extends \Simple\Middleware\Base
{

    protected $contentFile = null;

    protected $templatesPath = null;

    protected $smatyInstance = null;


    public function __construct()
    {
        $this->smatyInstance = new \SmartyTemplate\Lib\SmartyExt($this->backbone);

    }

    public function render()
    {
var_dump($this->getContentFile(), $this->backbone->getResourceById('simple.controller')->response);
        $this->smatyInstance->assign($this->backbone->getResourceById('simple.controller')->response);
        $this->smatyInstance->render($this->getContentFile());
    }

    public function send()
    {

    }

    /**
     * Gets the value of contentFile.
     *
     * @return mixed
     */
    public function getContentFile()
    {
        if(is_null($this->contentFile))
        {
            $resource = $this->backbone->getResourceById('simple.controller')->getResource();
            $this->setContentFile(ucfirst($resource['namespace']).'/../View/'.ucfirst($resource['class'])'/'. strtolower($resource['action']).'.tpl');
        }
        return $this->contentFile;
    }

    /**
     * Sets the value of contentFile.
     *
     * @param mixed $contentFile the contentFile
     *
     * @return self
     */
    public function setContentFile($contentFile)
    {
        $this->contentFile = $contentFile;

        return $this;
    }

    /**
     * Gets the value of smatyInstance.
     *
     * @return mixed
     */
    public function getSmatyInstance()
    {
        return $this->smatyInstance;
    }

    public function open()
    {
        throw new Exception("Use @Cache middleware to open saved output", 1);
    }

    public function save()
    {
        throw new Exception("Use @Cache middleware to open saved output", 1);
    }

}


include $this->getContentFile()