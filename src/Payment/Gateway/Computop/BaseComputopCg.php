<?php
namespace Payment\Gateway\Computop;

abstract class BaseComputopCg{

    public $merchantId = null;                // via e-mail from computop support
    public $blowfishPassword = null;   // via phone from computop support
    public $hMacPassword = null;           // via phone from computop support
    public $serverUrl = null;

    public function __construct()
    {
        $this->resetFields();
    }
    protected function resetFields()
    {
        $this->merchantId = null;      
        $this->blowfishPassword = null;
        $this->hMacPassword = null; 
        $this->serverUrl = null;      
    }
}