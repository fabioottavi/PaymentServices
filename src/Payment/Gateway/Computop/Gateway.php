<?php

namespace Payment\Gateway\Computop;

class Gateway implements \Payment\Gateway\GatewayInterface
{
    /**
     * 
     * @return object
     *
     * @throws \Exception
     */

    //private $serverUrl;
    private $debug;
    private $sUrl = 'https://www.computop-paygate.com';
    
    const PAYMENT_BY_SSL = '/payssl.aspx';
    const PAYMENT_BY_ELV = '/payelv.aspx';
    const PAYMENT_BY_PPL = '/paypal.aspx';
    const PAYMENT_BY_GRP = '/giropay.aspx';
    const PAYMENT_BY_SFT = '/sofort.aspx';

    public function __construct ($debug){
       $this->debug = $debug;
       //$this->serverUrl = $debug ? 
       //'https://www.computop-paygate.com/payssl.aspx' : 
       //'productionLink';
    }
    
    public function init(array $params = [])
    {
        $initObj = new Init\ComputopCgInit(); 
        $unique = ComputopUtils::getValue($params, 'shopID');
        $url= ComputopUtils::getValue($params,'baseURL','');

        $initObj->transId = $unique;

        $initObj->amount = ComputopUtils::getValue($params, 'amount', '0');
        $initObj->currency = ComputopUtils::getValue($params,'currencyCode','EUR');
        $initObj->description = ComputopUtils::getValue($params,'description');
        $initObj->UrlSuccess = $url.ComputopUtils::getValue($params,'callbackUrl','');
        $initObj->UrlFailure = $url.ComputopUtils::getValue($params,'errorUrl','');
        $initObj->UrlNotify = $url.ComputopUtils::getValue($params,'notifyUrl','');

        $initObj->userData = ComputopUtils::getValue($params,'userData');

        $initObj->serverUrl = $this->sUrl.ComputopUtils::getValue($params,'paymentMethod');
        $initObj->merchantId = ComputopUtils::getValue($params,'merchantId');     
        $initObj->blowfishPassword = ComputopUtils::getValue($params,'blowfishPassword');
        $initObj->hMacPassword = ComputopUtils::getValue($params,'hMacPassword');

        return $initObj->execute();
    }
    public function verify(array $params = [])
    {
        
    }
    public function confirm(array $params = []){
        
    }

    public function refund(array $params = []){

    }
}