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
     public function __construct ($debug){
        $this->serverUrl = $debug ? 
        'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/' : 
        'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/';
     } 
    
    public function init(array $params = [])
    {
        $initObj = new Init\IgfsCgInit(); 

        $initObj->serverURL = $this->serverUrl;

        $initObj->kSig = IgfsUtils::getValue($params,'kSig');
        $initObj->tid = IgfsUtils::getValue($params,'tid');
        $initObj->shopID = IgfsUtils::getValue($params, 'shopID');
        $initObj->langID =IgfsUtils::getValue($params, 'langID', 'IT');
        
        //mandatory
        $initObj->amount = IgfsUtils::getValue($params, 'amount', '0');
        $initObj->currencyCode =IgfsUtils::getValue($params,'currencyCode','EUR');

        $initObj->addInfo1 =IgfsUtils::getValue($params,'addInfo1');
        $initObj->addInfo2 =IgfsUtils::getValue($params,'addInfo2');
        $initObj->addInfo3 =IgfsUtils::getValue($params,'addInfo3');
        $initObj->addInfo4 =IgfsUtils::getValue($params,'addInfo4');
        $initObj->addInfo5 =IgfsUtils::getValue($params,'addInfo5');

        //notifyURL
        $unique = IgfsUtils::getValue($params,'token');
        $url= IgfsUtils::getValue($params,'baseURL','');
        $notifyUrl= IgfsUtils::getValue($params,'notifyUrl','');
        $errorUrl= IgfsUtils::getValue($params,'errorUrl','');
        $callbackUrl= IgfsUtils::getValue($params,'callbackUrl','');
                
        $initObj->notifyURL =IgfsUtils::getValue(
            $params,
            'notifyURL',
            $url.$notifyUrl.'?token='.urlencode($unique) 
        );

        $initObj->errorURL =IgfsUtils::getValue(
            $params,
            'errorURL',
            $url.$errorUrl.'?token='.urlencode($unique) 
        );

        $initObj->callbackURL =IgfsUtils::getValue(
            $params,
            'callbackURL',
            $url.$callbackUrl.'?token='.urlencode($unique) 
        );

        $initObj->execute();
        return array(
            'id' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'redirectURL' => $initObj->redirectURL,
        );
    }

    public function verify(array $params = []){
        $initObj = new Init\IgfsCgVerify(); 

        $initObj->serverURL = $this->serverUrl;
        $initObj->kSig = IgfsUtils::getValue($params,'kSig');
        $initObj->tid = IgfsUtils::getValue($params,'tid');
        $initObj->shopID = IgfsUtils::getValue($params, 'shopID');
        $initObj->langID =IgfsUtils::getValue($params, 'langID', 'IT');
        $initObj->paymentID =IgfsUtils::getValue($params, 'paymentID', '00179695241108714733');


        $initObj->execute();
        return array(
            'id' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'redirectURL' => $initObj->redirectURL,
        );
    }
}