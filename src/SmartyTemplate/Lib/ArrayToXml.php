<?php
namespace SmartyTemplate\Lib;


/**
* \SmartyTemplate\Lib\ArrayToXml::encode('RootNode', $responseArray);
*/
class ArrayToXml {

    static public function encode($node, $var, $i=0, $beforeNode=null)
    {
        $xml = ($node && $i==0) ? "<{$node}>" : '';
        foreach ($var as $key => $value)
        {
            if(is_array($value))
            {
                if(!is_int($key))
                {
                    $xml .= self::encode($key, $value, 0, $node);
                }
                elseif(is_int(key($value)))
                {
                    $xml .= '<'.$node.'>'. self::encode($key, $value, 1, \SmartyTemplate\Lib\Inflector::singularize($node)).'</'.$node.'>';
                }
                else
                {
                    $innerNode = \SmartyTemplate\Lib\Inflector::singularize($node);
                    $xml .= '<'.$innerNode.'>'.self::encode($key, $value, 1).'</'.$innerNode.'>';
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

}