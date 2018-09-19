<?php
namespace Payment\Gateway\Computop;

class ComputopUtils{
    public static function getValue($map, $key, $default = null, $acceptWhiteSpace = true)
    {
        return isset($map[$key]) && ($acceptWhiteSpace || $map[$key]!=='') ? $map[$key] : $default;
    }
    public static function getPaymentResultParam($obj)
    {
        return $params = [
            'Data' => $obj["Data"],
            'Len' => $obj["Len"],
        ];
    }

    public static function normalizeLanguage($language){
        return strtoupper(substr($language,0,2));
    }

    public static function clearUrl($url){
        $parsed_url = parse_url($url);
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : ''; 
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : ''; 
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : ''; 
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : ''; 
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : ''; 
        $pass     = ($user || $pass) ? "$pass@" : ''; 
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : ''; 
        return "$scheme$user$pass$host$port$path"; 
    }

    public static function combineQueryParams(array $urls = []){

        $arrayParam = array();

        foreach($urls as $url){
            $parsed_url = parse_url($url);
            if(isset($parsed_url['query'])){
                $parts = explode("&",$parsed_url['query']);
                foreach($parts as $p){

                   if(strpos($p, '=') !== false){
                    array_push($arrayParam,$p);

                   }else{
                    array_push($arrayParam,$p.'=');
                   }
                    //$paramData = explode("=",$p);
                    //$arrayParam[$paramData[0]]=$paramData[1];
                }
            }
        }

        $arrayParam = array_unique($arrayParam);
        return join("&", $arrayParam);
    }
}