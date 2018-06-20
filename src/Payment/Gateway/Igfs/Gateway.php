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
    public function init(array $params = [])
    {

        $initObj = new Init\IgfsCgInit(); 

        $initObj->serverURL = IgfsUtils::getValue(
            $params,
            'serverURL',
            'https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/'
        );
        $initObj->kSig = IgfsUtils::getValue(
            $params,
            'kSig',
            'xHosiSb08fs8BQmt9Yhq3Ub99E8='
        );
        $initObj->tid = IgfsUtils::getValue(
            $params,
            'tid',
            '06165845'
        );
        $initObj->langID =IgfsUtils::getValue($params, 'langID', 'IT');
        

        //mandatory
        $initObj->amount = IgfsUtils::getValue($params, 'amount', '100');
        $initObj->shopID = IgfsUtils::getValue($params, 'shopID');
        

        $initObj->currencyCode =IgfsUtils::getValue(
            $params,
            'currencyCode',
            'EUR'
        );
        //notifyURL
        $url= 'http://ipgadmin.sendabox.it/Callback/Save?token=';
        $unique = uniqid(rand(), true);
        
        
        $initObj->notifyURL =IgfsUtils::getValue(
            $params,
            'notifyURL',
            $url.'notifyURL'.urlencode($unique) 
        );

        $initObj->errorURL =IgfsUtils::getValue(
            $params,
            'errorURL',
            $url.'errorURL'.urlencode($unique) 
        );

        $initObj->callBackUrl =IgfsUtils::getValue(
            $params,
            'callBackUrl',
            $url.'callBackUrl'.urlencode($unique) 
        );


        $initObj->addInfo1 =IgfsUtils::getValue(
            $params,
            'addInfo1',
            'addInfo1' 
        );
        $initObj->addInfo3 =IgfsUtils::getValue(
            $params,
            'addInfo3',
            'addInfo3' 
        );
        $initObj->addInfo4 =IgfsUtils::getValue(
            $params,
            'addInfo4',
            'addInfo4' 
        );
        $initObj->addInfo5 =IgfsUtils::getValue(
            $params,
            'addInfo5',
            'addInfo5' 
        );
        $initObj->addInfo6 =IgfsUtils::getValue(
            $params,
            'addInfo6',
            'addInfo6' 
        );

        $initObj->execute();
        return array(
            'id' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID
        );
    }

}