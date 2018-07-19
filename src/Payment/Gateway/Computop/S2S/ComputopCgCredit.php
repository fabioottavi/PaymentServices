<?php

namespace Payment\Gateway\Computop\S2S;

class ComputopCgCredit extends BaseComputopCgS2S{

	public $textField1;
    public $textField2;
    
    protected function resetFields() {
        parent::resetFields();
        $this->textField1 = null;
        $this->textField2 = null;
    }

    protected function checkFields() {
        parent::checkFields();
    }

    protected function getParams(){
        $this->checkFields();

        // formatting data to transmit - required
        $pMerchantId = "&MerchantID=".$this->merchantId;
        $pPayId = "&PayID=".$this->payId;
        $pTransId = "&TransID=".$this->transId;
        $pAmount = "&Amount=".$this->amount;
        $pCurrency = "&Currency=".$this->currency; 

        $params = array($pMerchantId, $pPayId, $pTransId, $pAmount, $pCurrency);

        // adding optional params
        if($this->description !== null){
            array_push($params, "&OrderDesc=".$this->description);
        }
        if($this->textField1 !== null){
            array_push($params, "&Textfeld1=".$this->textField1);
        }
        if($this->textField2 !== null){
            array_push($params, "&Textfeld2=".$this->textField2);
        }

        return $params;
    }
}