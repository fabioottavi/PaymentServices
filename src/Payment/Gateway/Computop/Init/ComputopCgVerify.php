<?php

namespace Payment\Gateway\Computop\Init;
use Payment\Gateway\Computop\BaseComputopCg;

class ComputopCgVerify extends BaseComputopCg {
    public $len;
    public $data;

    public function __construct(){
        $this->len = null;
        $this->data = null;
        parent::__construct();
    }

    public function execute(){
        // decrypt the data string
        $myPayGate = new ctPaygate;
        $plaintext = $myPayGate->ctDecrypt($this->data, $this->len, $this->blowfishPassword);

        // prepare information string
        $a = "";
        $a = explode('&', $plaintext);
        $info = $myPayGate->ctSplit($a, '=');
        $status = $myPayGate->ctSplit($a, '=', 'Status');

        // check transmitted decrypted status
        $realstatus = $myPayGate->ctRealstatus($status);

        array_push($a,$realstatus);
        return $a;
    }


}