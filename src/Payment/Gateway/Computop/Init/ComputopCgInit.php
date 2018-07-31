<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\CmptpMissingParException;

/**
 * Computop class
 * Responsible for all the init() calls
 */
class ComputopCgInit extends \Payment\Gateway\Computop\BaseComputopCg {

    public $UrlSuccess; //$sUrlDirname . "/success.php";
    public $UrlFailure; //$sUrlDirname . "/failure.php";
    public $UrlNotify; //$sUrlDirname . "/notify.php";

    public $refNr;
    public $description; // = "your order description";
    public $userData; // = "your user data";
    public $payGate; // = "PHP - PayGate";
    public $InpSend; // = "Select Payment";
    public $capture; // = "AUTO";
    public $addInfo1;
    public $addInfo2;
    public $addInfo3;
    public $addInfo4;
    public $addInfo5;

    public $template;
    public $background;
    public $bgColor;
    public $bgImage;
    public $fColor;
    public $fFace;
    public $fSize;
    public $centro;
    public $tWidth;
    public $tHeight;

    public $CustomField1;
    public $CustomField2;
    public $CustomField3;
    public $CustomField6;
    public $CustomField7;

    public $response = "encrypt";

    public function __construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl)
    {
        parent::__construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl.'/payssl.aspx');
    }

    protected function resetFields(){
        parent::resetFields();
        $this->UrlSuccess = null;
        $this->UrlFailure = null;
        $this->UrlNotify = null;
        $this->description = null;
        $this->userData = null;
        $this->payGate = null;
        $this->InpSend = null;
        $this->refNr = null;
        $this->addInfo1 = null;
        $this->addInfo2 = null;
        $this->addInfo3 = null;
        $this->addInfo4 = null;
        $this->addInfo5 = null;
        $this->template = null;
        $this->background = null;
        $this->bgColor = null;
        $this->bgImage = null;
        $this->fColor = null;
        $this->fFace = null;
        $this->fSize = null;
        $this->centro = null;
        $this->tWidth = null;
        $this->tHeight = null;

        $this->CustomField1 = null;
        $this->CustomField2 = null;
        $this->CustomField3 = null;
        $this->CustomField6 = null;
        $this->CustomField7 = null;
    }

    protected function checkFields() {
        parent::checkFields();
        if (!$this->description) {
            throw new CmptpMissingParException("Missing description");
        }
    }
    
    /**
     * Return an array of objects containing all the extra parameters that have to be passed in the request 
     *
     * @return array|array|string
     */
    public function getExtraParams(){}

    protected function getParams(){
        $custom = join("|", array($this->addInfo1,$this->addInfo2,$this->addInfo3,$this->addInfo4,$this->addInfo5));
        // format data which is to be transmitted - required
        $arr = parent::getParams();

        $pTransId = "TransID=$this->transId";
        $pRefNr = "RefNr=$this->refNr";
        $pAmount = "Amount=$this->amount";
        $pCurrency = "Currency=$this->currency";
        $pURLSuccess = "URLSuccess=$this->UrlSuccess";
        $pURLFailure = "URLFailure=$this->UrlFailure";
        $pResponse = "Response=$this->response";
        $pURLNotify = "URLNotify=$this->UrlNotify";
        $pUserData = "UserData=$this->userData";
        $pCapture = "Capture=$this->capture";
        $pOrderDesc = "OrderDesc=$this->description";
        $pReqId = "ReqID=$this->refNr";
        $pCustom = "UserData=$custom";

        array_push($arr,$pTransId, $pRefNr, $pAmount, $pCurrency, $pURLSuccess, $pURLFailure, $pResponse, $pURLNotify, $pUserData, $pCapture, $pOrderDesc, $pReqId, $pCustom);
        
        if($this->template){
            array_push($arr, "Template=$this->template");
        }
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
        
        if($this->CustomField1){
            array_push($arr, "CustomField1=$this->CustomField1");
        }
        if($this->CustomField2){
            array_push($arr, "CustomField2=$this->CustomField2");
        }
        if($this->CustomField3){
            array_push($arr, "CustomField3=$this->CustomField3");
        }
        if($this->CustomField6){
            array_push($arr, "CustomField6=$this->CustomField6");
        }
        if($this->CustomField7){
            array_push($arr, "CustomField7=$this->CustomField7");
        }
        
        return $arr;
    }
    public function execute(){
        $this->checkFields();
        
        // create url
        $retUrl = $this->buildRequest();

        return array(
            'returnCode' => '',
            'error' => '',
            'paymentID' => '',
            'redirectURL' => $retUrl,
        );
    }
}