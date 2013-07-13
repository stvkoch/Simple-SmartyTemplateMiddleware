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

    protected $smatyInstance = null;
    protected $output = null;

    public function render()
    {
        $resource = $this->backbone->getResourceById('simple.controller')->getResource();
        $response = $this->backbone->getResourceById('simple.controller')->getResponse();

        if(strtolower($resource['format'])=='html')
        {
            $this->getSmatyInstance()->assign($response->getVars());
            $loader = require '../vendor/autoload.php';
            $templateFile = $loader->findFile(substr($response->getContentFile(),1),1);

            $response->setContent($this->getSmatyInstance()->fetch($templateFile));
        }elseif(strtolower($resource['format'])=='json')
        {
            $rootElement = ucfirst($resource['action']);
            $response->setContent(json_encode( array('Get'.$rootElement.'Response'=>array('Get'.$rootElement.'Result'=>$response->getVars())) ));
        }
        elseif(strtolower($resource['format'])=='xml')
        {
            $rootElement = ucfirst($resource['action']);
            $response->setContent('<?xml version="1.0"?><Get'.$rootElement.'Response>'. \SmartyTemplate\Lib\ArrayToXml::encode('Get'.$rootElement.'Result', $response->getVars()) .'</Get'.$rootElement.'Response>');
        }

        return $response->getContent();
    }

    public function send()
    {
        $this->backbone->getResourceById('simple.controller')->getResponse()->sendHeader();
        echo $this->render();
    }

    /**
     * Gets the value of smatyInstance.
     *
     * @return mixed
     */
    public function getSmatyInstance()
    {
        if(is_null($this->smatyInstance))
        {
            $this->smatyInstance = new \SmartyTemplate\Lib\SmartyExt($this->backbone);
            $this->smatyInstance->setCompileDir($this->resource['compileDir']);
            if(isset($this->resource['forceCompile']))
                $this->smatyInstance->force_compile = $this->resource['forceCompile'];
            if(isset($this->resource['compileCheck']))
                $this->smatyInstance->compile_check = $this->resource['compileCheck'];
        }
        return $this->smatyInstance;
    }


    public function open()
    {
        //throw new Exception("Use @Cache middleware to open saved output", 1);
    }


    public function save()
    {
        //throw new Exception("Use @Cache middleware to open saved output", 1);
    }

}
