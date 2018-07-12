<?php
namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\BaseComputopCg;


class ComputopCgInit extends BaseComputopCg {

    public $UrlSuccess; //$sUrlDirname . "/success.php";
    public $UrlFailure; //$sUrlDirname . "/failure.php";
    public $UrlNotify; //$sUrlDirname . "/notify.php";

    public $description; // = "your order description";
    public $userData; // = "your user data";
    public $payGate; // = "PHP - PayGate";
    public $transId; // = "TransID";
    public $amount; // = 11;
    public $currency; // = "EUR";
    public $InpSend; // = "Select Payment";

    public $response = "encrypt";
    public $capture = "AUTO";

    public function __construct()
    {
        $this->UrlSuccess = null;
        $this->UrlFailure = null;
        $this->UrlNotify = null;
        $this->description = null;
        $this->userData = null;
        $this->payGate = null;
        $this->transId = null;
        $this->amount = null;
        $this->currency = null;
        $this->InpSend = null;
        parent::__construct();
    }

    public function execute(){
        $this->currency = trim($this->currency);
        if (empty($currency)) {
            $this->currency = 'EUR';
        }

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

        //Creating MAC value
        $myPayGate = new ctPaygate;
        $MAC = $myPayGate->ctHMAC("", $this->transId, $this->merchantId, $this->amount, $this->currency, $this->hMacPassword);
        $pMAC = "MAC=$MAC";

        $query = array($pTransID, $pAmount, $pCurrency, $pURLSuccess, $pURLFailure, $pURLNotify, $pOrderDesc, $pUserData, $pCapture, $pResponse, $pMAC);
        
        // building the string MerchantID, Len and Data (encrypted)
        $plaintext = join("&", $query);
        $Len = strlen($plaintext);  // Length of the plain text string

        // encrypt plaintext
        $Data = $myPayGate->ctEncrypt($plaintext, $Len, $this->blowfishPassword);

        //if (strlen($Data) > 0) {
        //    $plaintextDec = $myPayGate->ctDecrypt($Data, $Len, $this->blowfishPassword);
        //
        //    // prepare information string
        //
        //    $a = "";
        //    $a = explode('&', $plaintext);
        //    $info = $myPayGate->ctSplit($a, '=');
        //}

        return array(
            'serverUrl' => $this->serverUrl,
            'transId'=>$this->transId,
            'amount'=>$this->amount,
            'currency'=>$this->currency,
            'UrlSuccess'=>$this->UrlSuccess,
            'UrlFailure'=>$this->UrlFailure,
            'UrlNotify'=>$this->UrlNotify,
            'description'=>$this->description,
            'userData'=>$this->userData,
            'merchantId'=>$this->merchantId,
            'MAC'=>$MAC,
            'plaintext'=>$plaintext,
            //'plaintextDec'=>$plaintextDec,
            //'info'=>$info,
            'Len'=>$Len,
            'Data'=>$Data
        );
    }
}