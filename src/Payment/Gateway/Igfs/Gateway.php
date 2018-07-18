<?php

namespace Payment\Gateway\Igfs;

class Gateway implements \Payment\Gateway\GatewayInterface
{
    private $serverUrl;
    private $test;
    private $dTid = '';
    private $dKsig = '';
    private $dInfo1 = '';
    private $dInfo2 = '';
    private $dInfo3 = '';
    private $dInfo4 = '';
    private $dInfo5 = '';

    const PAYMENT_BY_SELECTION = '_S';
    const PAYMENT_BY_CC = '';
    const PAYMENT_BY_MY_BANK = 'M';
    const PAYMENT_BY_MASTERPASS = 'P';
    const PAYMENT_BY_FINDOMESTIC = '';
    const PAYMENT_BY_PAYPAL = 'PP';
    
    const DEFAULT_LANGUAGE = 'EN';
         
    const CHECK_OUT_NORMAL = 'CHECK OUT NORMAL'; //checkout BNLP
    const CHECK_OUT_SYNTHESIS = 'CHECK OUT SYNTHESIS'; // checkout BNLP with web synthesis store
    const CHECK_OUT_SELECT = 'CHECK OUT SELECT'; //checkout BNLP with selection of payment instrument on the web store

    const TRANSACTION_TYPE_PURCHASE = 'PURCHASE';
    const TRANSACTION_TYPE_AUTH = 'AUTH';
    const TRANSACTION_TYPE_VERIFY = 'VERIFY';

     /**
     * 
     * @return object
     *
     * @throws \Exception
     */
     public function __construct ($test){
        $this->test = $test;
        if($test){
            $this->serverUrl ='https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/';
            $this->dTid = '06231955';
            $this->dKsig = 'xHosiSb08fs8BQmt9Yhq3Ub99E8=';
            $this->dInfo1 = '';
            $this->dInfo2 = '';
            $this->dInfo3 = '';
            $this->dInfo4 = '';
            $this->dInfo5 = '';
        }
        else{
            $this->serverUrl = 'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/';
        }
     }

    /**
     * 
     * Transaction initializer. Create the Redirect URL.
     * 
     * @param array $params
     * @return array|object
     * @throws ConnectionException
     * @throws IgfsException
     */
    public function init(array $params = [])
    {
        $initObj = new Init\IgfsCgInit(); 
        $unique = IgfsUtils::getValue($params, 'paymentReference');
        $url= IgfsUtils::getValue($params,'baseURL','');

        $initObj->serverURL = $this->serverUrl;
        if($this->test){
            $initObj->disableCheckSSLCert();
        }
        $initObj->tid = IgfsUtils::getValue($params,'terminalId',$this->dTid).IgfsUtils::getValue($params,'paymentMethod');
        $initObj->shopID = $unique;
        $initObj->amount = str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $initObj->currencyCode =IgfsUtils::getValue($params,'currency','EUR');
        $initObj->kSig = IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $initObj->notifyURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'notifyUrl',''), 'token='.urlencode($unique));
        $initObj->errorURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'errorUrl',''), 'token='.urlencode($unique));
        $initObj->callbackURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'callbackUrl',''), 'token='.urlencode($unique));
        $initObj->addInfo1 =IgfsUtils::getValue($params,'addInfo1',$this->dInfo1);
        $initObj->addInfo2 =IgfsUtils::getValue($params,'addInfo2',$this->dInfo2);
        $initObj->addInfo3 =IgfsUtils::getValue($params,'addInfo3',$this->dInfo3);
        $initObj->addInfo4 =IgfsUtils::getValue($params,'addInfo4',$this->dInfo4);
        $initObj->addInfo5 =IgfsUtils::getValue($params,'addInfo5',$this->dInfo5);
        $initObj->trType =IgfsUtils::getValue($params, 'transactionType', 'AUTH');
        $initObj->description =IgfsUtils::getValue($params, 'description');
        $initObj->shopUserRef =IgfsUtils::getValue($params, 'shopUserRef');
        $initObj->shopUserName =IgfsUtils::getValue($params, 'shopUserName');
        $initObj->langID =IgfsUtils::getValue($params, 'language', self::DEFAULT_LANGUAGE);
        $initObj->payInstrToken = IgfsUtils::getValue($params, 'payInstrToken');
        $initObj->regenPayInstrToken = IgfsUtils::getValue($params, 'regenPayInstrToken');

        $initObj->execute();
        return array(
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'shopID' => $initObj->shopID,
            'notifyURL' => $initObj->notifyURL,
            'redirectURL' => $initObj->redirectURL,
        );
    }

    /**
     * 
     * Verify transaction. Receive only the status of the specific transaction.
     * 
     * @param array $params
     * @return array|object
     */
    public function verify(array $params = []){
        $verifyObj = new Init\IgfsCgVerify(); 

        $verifyObj->serverURL = $this->serverUrl;
        if($this->test){
            $verifyObj->disableCheckSSLCert();
        }
        $verifyObj->kSig = IgfsUtils::getValue($params,'kSig',$this->dKsig);
        $verifyObj->tid = IgfsUtils::getValue($params,'terminalId',$this->dTid).'_S';
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

    /**
     * 
     * Transaction confirmation. 
     * Transfer a specific amount from an authorized transaction
     * 
     * @param array $params
     * @return array|object
     */
    public function confirm(array $params = []){
        $confirmObj = new tran\IgfsCgConfirm(); 

        $confirmObj->serverURL = $this->serverUrl;
        if($this->test){
            $confirmObj->disableCheckSSLCert();
        }

        $confirmObj->tid= IgfsUtils::getValue($params,'terminalId',$this->dTid);
        $confirmObj->kSig= IgfsUtils::getValue($params,'kSig',$this->dKsig);
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

    /**
     * 
     * Refund transaction. Return a specific amount back to buyer.
     * 
     * @param array $params
     * @return array|object
     */
    public function refund(array $params = []){
        
        $rfdObj = new tran\IgfsCgCredit();

        $rfdObj->serverURL = $this->serverUrl;
        $rfdObj->tid= IgfsUtils::getValue($params,'terminalId',$this->dTid);
        $rfdObj->kSig= IgfsUtils::getValue($params,'kSig',$this->dKsig);
        $rfdObj->shopID= IgfsUtils::getValue($params, 'shopID');
        $rfdObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $rfdObj->refTranID= IgfsUtils::getValue($params, 'transactionId');

        $rfdObj->execute();
        return $rfdObj;
    }

    /**
     * 
     * Cancel pending transaction. Return a specific amount back to buyer.
     * 
     * @param array $params
     * @return array|object
     */
    public function cancel(array $params){
        $rfdObj = new tran\IgfsCgVoidAuth();
        
        $rfdObj->serverURL = $this->serverUrl;
        $rfdObj->tid= IgfsUtils::getValue($params,'terminalId',$this->dTid);
        $rfdObj->kSig= IgfsUtils::getValue($params,'kSig',$this->dKsig);
        $rfdObj->shopID= IgfsUtils::getValue($params, 'shopID');
        $rfdObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $rfdObj->refTranID= IgfsUtils::getValue($params, 'transactionId');
        
        $rfdObj->execute();
        return $rfdObj;

    }
}