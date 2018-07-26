<?php
namespace Payment\Gateway\Computop;

class ComputopUtils{
    public static function getValue($map, $key, $default = null)
    {
        return isset($map[$key]) ? $map[$key] : $default;
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

}