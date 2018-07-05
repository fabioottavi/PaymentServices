<?php
namespace Payment\Gateway\Computop;

abstract class BaseComputopCg{

    private static $version = ""; // Todo: version??
    
    public $kSig; // chiave signature
    public $serverURL = null;
    public $serverURLs = null;
    public $cTimeout = 5000;
    public $timeout = 30000;
    
    public $proxy = null;

    public $httpAuthUser = null;
    public $httpAuthPass = null;

    public $merchantId = null;

    public $rc = null;
    public $error = null;
    public $errorDesc = null;

    protected $fields2Reset = false;
    protected $checkCert = true;

    public $installPath = null;
    
    public function __construct()
    {
        $this->resetFields();
    }

    protected function resetFields()
    {
        $this->merchantId = null;
        $this->rc = null;
        $this->error = false;
        $this->errorDesc = null;
        $this->fields2Reset = false;
    }

    protected function checkFields()
    {
        if ($this->serverURL == null || "" == $this->serverURL) {
            if ($this->serverURLs == null || sizeof($this->serverURLs) == 0) {
                throw new IgfsMissingParException("Missing serverURL");
            }
        }
        if ($this->kSig == null || "" == $this->kSig) {
            throw new IgfsMissingParException("Missing kSig");
        }
        if ($this->merchantId == null || "" == $this->merchantId) {
            throw new IgfsMissingParException("Missing MerchantID");
        }
        return true;
    }
    /**
     * Disable Certification Check on SSL HandShake
     */
    public function disableCheckSSLCert()
    {
        $this->checkCert = false;
    }

}