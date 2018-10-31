<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\CmptpMissingParException;
use Payment\Gateway\Computop\ComputopUtils;

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

    public $customField1;
    public $customField2;
    public $customField3;
    public $customField6;
    public $customField7;

    public $response = "encrypt";
    public $encryptResponse = false;

    public function __construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl)
    {
        parent::__construct($merchantId,$blowfishPassword,$hMacPassword,$serverUrl);
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

        $this->customField1 = null;
        $this->customField2 = null;
        $this->customField3 = null;
        $this->customField6 = null;
        $this->customField7 = null;
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
        $this->userData = join("|", array($this->addInfo1,$this->addInfo2,$this->addInfo3,$this->addInfo4,$this->addInfo5));
        // format data which is to be transmitted - required
        $arr = parent::getParams();

        $pTransId = "TransID=$this->transId";
        $pRefNr = "RefNr=$this->refNr";
        $pAmount = "Amount=$this->amount";
        $pCurrency = "Currency=$this->currency";
        $pURLSuccess = "URLSuccess=".ComputopUtils::clearUrl($this->UrlSuccess);
        $pURLFailure = "URLFailure=".ComputopUtils::clearUrl($this->UrlFailure);
        $pURLNotify = "URLNotify=".ComputopUtils::clearUrl($this->UrlNotify);
        $pOrderDesc = "OrderDesc=$this->description";
        $pReqId = "ReqID=$this->refNr";

        array_push($arr,$pTransId, $pRefNr, $pAmount, $pCurrency, $pURLSuccess, $pURLFailure, $pURLNotify, $pOrderDesc, $pReqId);

        $partsSpl = explode("&",$this->addInfo5);
        $parts = join("|", $partsSpl);

        if($parts){
            array_push($arr, "Custom=$parts");
        }
        
        if($this->encryptResponse){
            array_push($arr, "Response=$this->response");
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
            'paymentID' => '0',
            'orderReference' => $this->refNr,
            'notifyURL' => $this->UrlNotify,
            'redirectURL' => $retUrl,
        );
    }
}