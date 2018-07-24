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
        // format data which is to be transmitted - required
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

        return array($pTransId, $pRefNr, $pAmount, $pCurrency, $pURLSuccess, $pURLFailure, $pResponse, $pURLNotify, $pUserData, $pCapture, $pOrderDesc, $pReqId);
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