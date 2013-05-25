<?php

namespace Lellol\Middleware;


class View extends \Simple\Middleware\Base
{

    protected $layout = '';

    protected $contentFile = '';

    protected $templatesPath='';

    protected $smatyInstance = '';


    protected function config()
    {
        $resource = $this->backbone->getResourceById('simple.controller')->getResource();
        $this->contentFile = $templatesPath.'/'.ucfirst($resource['class'])'/'. strtolower($resource['action']).'.tpl';
        $this->smatyInstance = new Smarty();
    }


    public function render()
    {
        
    }


    public function open()
    {
        
    }

    public function 


    public function save()
    {
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
     * Gets the value of layout.
     *
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Sets the value of layout.
     *
     * @param mixed $layout the layout
     *
     * @return self
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

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
}
