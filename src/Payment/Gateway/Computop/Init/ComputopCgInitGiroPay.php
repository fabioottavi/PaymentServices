<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\CmptpMissingParException;

/**
 * Computop class
 * Responsible for all the init() calls
 */
class ComputopCgInitGiroPay extends ComputopCgInit {

    public $sellingPoint;
    public $accOwner; // <name><space><surname><space>
    public $scheme; // "gir" || "eps"
    public $bic;
    public $expirationTime; // Format: YYYY-MM-ddTHH:mm:ss
    public $iban;

    protected function resetFields(){
        $this->sellingPoint = null;
        $this->accOwner = null;
        $this->scheme = null;
        $this->bic = null;
        $this->expirationTime = null;
        $this->iban = null;
        parent::resetFields();
    }

    protected function checkFields() {

    
        parent::checkFields();
    }

    protected function getParams(){
        // format data which is to be transmitted - required
        $arr = parent::getParams();
        
        $pSellingPoint = "SellingPoint=$this->sellingPoint";
        $pAccOwner = "AccOwner=$this->accOwner";
        $pScheme = "Scheme=$this->scheme";
        $pBic = "BIC=$this->bic";
        $pExpirationTime = "expirationTime=$this->expirationTime";
        $pIban = "IBAN=$this->iban";

        array_push($arr,$pSellingPoint,$pAccOwner,$pScheme,$pBic,$pExpirationTime,$pIban);
        return $arr;
    }
}