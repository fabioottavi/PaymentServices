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
        $unique = IgfsUtils::getValue($params,'token');
        $url= IgfsUtils::getValue($params,'baseURL','');

        $initObj->serverURL = $this->serverUrl;
        $initObj->tid = IgfsUtils::getValue($params,'tid').IgfsUtils::getValue($params,'paymentMethod');
        $initObj->shopID = IgfsUtils::getValue($params, 'shopID');
        $initObj->amount = IgfsUtils::getValue($params, 'amount', '0');
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

        //TODO: must be verified the use of this parameter. Add AddrCountryCode
        //TODO: must be verified the use of this parameter. Add SellingPoint
        //TODO: must be verified the use of this parameter. Add AccOwner
        //TODO: must be verified the use of this parameter. Add Device
        //TODO: must be verified the use of this parameter. Add Email
        //TODO: must be verified the use of this parameter. Add Phone

        $initObj->execute();
        return array(
            'id' => $initObj->tid,
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
        );
    }
}