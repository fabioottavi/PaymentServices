<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\CmptpMissingParException;
use Payment\Gateway\Computop\ComputopUtils;

/**
 * Computop class
 * Responsible for all the init() calls
 */
class ComputopCgInitCC extends ComputopCgInit {

    public $urlBack;

    protected function resetFields(){
        parent::resetFields();
        $this->urlBack = null;
    }

    public function __construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl)
    {
        parent::__construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl.'/payssl.aspx');
    }

    public function getParamsDecrypted(){
        $arr = parent::getParamsDecrypted();
        if($this->template){
            array_push($arr, "Template=$this->template");
        }
        if($this->urlBack){
            array_push($arr, "URLBack=$this->urlBack");
        }
        if($this->customField1){
            array_push($arr, "CustomField1=".urlencode($this->customField1));
        }
        if($this->customField2){
            array_push($arr, "CustomField2=".urlencode($this->customField2));
        }
        if($this->customField3){
            array_push($arr, "CustomField3=".urlencode($this->customField3));
        }
        if($this->customField6){
            array_push($arr, "CustomField6=".urlencode($this->customField6));
        }
        if($this->customField7){
            array_push($arr, "CustomField7=".urlencode($this->customField7));
        }
        return $arr;
    }

    protected function getParams(){
        
        $arr = parent::getParams();

        array_push($arr, "Capture=$this->capture");
        
        if($this->background){
            array_push($arr, "Background=$this->background");
        }
        if($this->bgColor){
            array_push($arr, "BGColor=$this->bgColor");
        }
        if($this->bgImage){
            array_push($arr, "BGImage=$this->bgImage");
        }
        if($this->fColor){
            array_push($arr, "FColor=$this->fColor");
        }
        if($this->fFace){
            array_push($arr, "FFace=$this->fFace");
        }
        if($this->fSize){
            array_push($arr, "FSize=$this->fSize");
        }
        if($this->centro){
            array_push($arr, "Centro=$this->centro");
        }
        if($this->tWidth){
            array_push($arr, "tWidth=$this->tWidth");
        }
        if($this->tHeight){
            array_push($arr, "tHeight=$this->tHeight");
        }
        
                
        return $arr;
    }
}