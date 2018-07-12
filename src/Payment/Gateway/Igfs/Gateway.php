<?php

namespace Payment\Gateway\Igfs;

class Gateway implements \Payment\Gateway\GatewayInterface
{
    /**
     * 
     * @return object
     *
     * @throws \Exception
     */

     private $serverUrl;
     private $debug;
     public function __construct ($debug){
        $this->debug = $debug;
        $this->serverUrl = $debug ? 
        'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/' : 
        'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/';
     }

    /**
     * @param array $params
     * @return array|object
     * @throws ConnectionException
     * @throws IgfsException
     */

    const PAYMENT_BY_SELECTION = '_S';
    const PAYMENT_BY_CC = '';
    const PAYMENT_BY_MY_BANK = 'M';
    const PAYMENT_BY_MASTERPASS = 'P';
    const PAYMENT_BY_FINDOMESTIC = '';
    const PAYMENT_BY_PAYPAL = 'PP';

    public function init(array $params = [])
    {
        $initObj = new Init\IgfsCgInit(); 
        $unique = IgfsUtils::getValue($params, 'shopID');
        $url= IgfsUtils::getValue($params,'baseURL','');

        $initObj->serverURL = $this->serverUrl;
        if($this->debug){
            $initObj->disableCheckSSLCert();
        }
        $initObj->tid = IgfsUtils::getValue($params,'tid').IgfsUtils::getValue($params,'paymentMethod');
        $initObj->shopID = $unique;
        $initObj->amount = str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $initObj->currencyCode =IgfsUtils::getValue($params,'currencyCode','EUR');
        $initObj->kSig = IgfsUtils::getValue($params,'kSig');
        $initObj->notifyURL =$url.IgfsUtils::getValue($params,'notifyUrl','').'?token='.urlencode($unique);
        $initObj->errorURL =$url.IgfsUtils::getValue($params,'errorUrl','').'?token='.urlencode($unique);
        $initObj->callbackURL =$url.IgfsUtils::getValue($params,'callbackUrl','').'?token='.urlencode($unique);
        $initObj->addInfo1 =IgfsUtils::getValue($params,'addInfo1');
        $initObj->addInfo2 =IgfsUtils::getValue($params,'addInfo2');
        $initObj->addInfo3 =IgfsUtils::getValue($params,'addInfo3');
        $initObj->addInfo4 =IgfsUtils::getValue($params,'addInfo4');
        $initObj->addInfo5 =IgfsUtils::getValue($params,'addInfo5');
        $initObj->trType =IgfsUtils::getValue($params, 'trType', 'AUTH');
        $initObj->description =IgfsUtils::getValue($params, 'description');
        $initObj->shopUserRef =IgfsUtils::getValue($params, 'shopUserRef');
        $initObj->shopUserName =IgfsUtils::getValue($params, 'shopUserName');
        $initObj->langID =IgfsUtils::getValue($params, 'langID', 'IT');
        $initObj->payInstrToken = IgfsUtils::getValue($params, 'payInstrToken');
        $initObj->regenPayInstrToken = IgfsUtils::getValue($params, 'regenPayInstrToken');

        $initObj->execute();
        return array(
            'tid' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'redirectURL' => $initObj->redirectURL,
        );
    }

    /**
     * @param array $params
     * @return array
     * @throws ConnectionException
     * @throws IgfsException
     */
    public function verify(array $params = []){
        $verifyObj = new Init\IgfsCgVerify(); 

        $verifyObj->serverURL = $this->serverUrl;
        if($this->debug){
            $verifyObj->disableCheckSSLCert();
        }
        $verifyObj->kSig = IgfsUtils::getValue($params,'kSig');
        $verifyObj->tid = IgfsUtils::getValue($params,'tid');
        $verifyObj->shopID = IgfsUtils::getValue($params, 'shopID');
        $verifyObj->langID =IgfsUtils::getValue($params, 'langID', 'IT');
        $verifyObj->paymentID =IgfsUtils::getValue($params, 'paymentID', '00179695241108714733');


        $verifyObj->execute();
        return array(
            'tid' => $verifyObj->tid,
            'returnCode' => $verifyObj->rc,
            'error' => $verifyObj->errorDesc,
            'shopID' => $verifyObj->shopID,
            'paymentID' => $verifyObj->paymentID,
            'tranID' => $verifyObj->tranID,
        );
    }

    public function confirm(array $params = []){
        $confirmObj = new tran\IgfsCgConfirm(); 

        $confirmObj->serverURL = $this->serverUrl;
        if($this->debug){
            $confirmObj->disableCheckSSLCert();
        }

        $confirmObj->tid= IgfsUtils::getValue($params,'tid');
        $confirmObj->kSig= IgfsUtils::getValue($params,'kSig');;
        $confirmObj->shopID= IgfsUtils::getValue($params, 'shopID');
        $confirmObj->refTranID= IgfsUtils::getValue($params, 'transactionId');
        $confirmObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        
        $confirmObj->execute();
        return array(
            'id' => $confirmObj->tid,
            'returnCode' => $confirmObj->rc,
            'error' => $confirmObj->errorDesc,
        );
    }

    public function refund(array $params = []){

    }
}