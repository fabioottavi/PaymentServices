<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\CmptpMissingParException;

/**
 * Computop class
 * Responsible for all the init() calls
 */
class ComputopCgInitMyBank extends ComputopCgInit {

    public $addrCountryCode;
    public $sellingPoint;
    public $accOwner;

    protected function resetFields(){
        $this->addrCountryCode = null;
        $this->sellingPoint = null;
        $this->accOwner = null;
        parent::resetFields();
    }

    protected function checkFields() {

        if (!$this->addrCountryCode) {
            throw new CmptpMissingParException("Missing addrCountryCode");
        }
        if (!$this->accOwner) {
            throw new CmptpMissingParException("Missing accOwner");
        }

        parent::checkFields();
    }

    protected function getParams(){
        // format data which is to be transmitted - required
        $arr = parent::getParams();
        
        $pAddrCountryCode = "AddrCountryCode=$this->addrCountryCode";
        $pSellingPoint = "SellingPoint=$this->sellingPoint";
        $pAccOwner = "AccOwner=$this->accOwner";

        array_push($arr,$pAddrCountryCode,$pSellingPoint,$pAccOwner);
        return $arr;
    }
}