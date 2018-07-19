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
        parent::resetFields();
    }

    protected function getParams(){
        // format data which is to be transmitted - required
        $pTransID = "TransID=$this->transId";
        $pAmount = "Amount=$this->amount";
        $pCurrency = "Currency=$this->currency";
        $pURLSuccess = "URLSuccess=$this->UrlSuccess";
        $pURLFailure = "URLFailure=$this->UrlFailure";
        $pURLNotify = "URLNotify=$this->UrlNotify";
        $pOrderDesc = "OrderDesc=$this->description";
        $pUserData = "UserData=$this->userData";
        $pCapture = "Capture=$this->capture";
        $pResponse = "Response=$this->response";

        return array($pTransID, $pAmount, $pCurrency, $pURLSuccess, $pURLFailure, $pURLNotify, $pOrderDesc, $pUserData, $pCapture, $pResponse);
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