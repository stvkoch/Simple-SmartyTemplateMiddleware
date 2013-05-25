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


    public function render()
    {
        $resource = $this->backbone->getResourceById('simple.controller')->getResource();
        $response = $this->backbone->getResourceById('simple.controller')->getResponse();

        if(strtolower($resource['format'])=='html')
        {
            $this->getSmatyInstance()->assign($response->getVars());
            $loader = require '../vendor/autoload.php';
            $templateFile = $loader->findFile(substr($response->getContentFile(),1),1);

            return $this->getSmatyInstance()->fetch($templateFile);
        }elseif(strtolower($resource['format'])=='json')
        {
            $rootElement = ucfirst($resource['action']);
            return json_encode( array('Get'.$rootElement.'Response'=>array('Get'.$rootElement.'Result'=>$response->getVars())) );
        }
        elseif(strtolower($resource['format'])=='xml')
        {
            $rootElement = ucfirst($resource['action']);
            return '<?xml version="1.0"?><Get'.$rootElement.'Response>'.$this->makeXml('Get'.$rootElement.'Result', $response->getVars()).'<Get'.$rootElement.'Response/>';

        }
        return 'Error @format not supported!';
    }

    public function send()
    {
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


    static protected function makeXml($node, $var, $i=0)
    {
        $xml = ($node && $i==0) ? "<{$node}>" : '';

        foreach ($var as $key => $value)
        {
            if(is_array($value))
            {
                if(is_int(key($value)))
                {
                    $xml .= self::makeXml($key, $value, 1);
                }
                elseif(!is_int($key))
                {
                    $xml .= self::makeXml($key, $value, 0);
                }
                else
                {
                    $xml .= '<'.$node.'>'.self::makeXml($key, $value, 1).'</'.$node.'>';
                }
            }
            else
            {
                if(!is_int($key))
                    $xml .= "<{$key}>$value</{$key}>";
                else
                    $xml .= "<{$node}>{$value}</{$node}>";
            }
        }
        $xml .= ($node&& $i==0) ?  "</{$node}>" :'';
        return $xml;
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
