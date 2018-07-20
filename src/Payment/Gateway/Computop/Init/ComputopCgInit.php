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

    protected function resetFields(){
        $this->UrlSuccess = null;
        $this->UrlFailure = null;
        $this->UrlNotify = null;
        $this->description = null;
        $this->userData = null;
        $this->payGate = null;
        $this->InpSend = null;
        $this->refNr = null;
        parent::resetFields();
    }

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