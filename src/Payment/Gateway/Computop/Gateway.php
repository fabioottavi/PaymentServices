<?php

namespace Payment\Gateway\Computop;

class Gateway implements \Payment\Gateway\GatewayInterface
{
    

    private $test;
    private $dMerchantId = 'bnlp_test';
    private $dBlowfishPassword = 'X*b89Q=eG!s23rJ[';
    private $dHsMacPassword = '8d)N?7Zg2Jz=(4Gs3y!T_Wx59k[R*6Cn';
    private $sUrl = 'https://ecpay.bnlpositivity.it/paymentpage';
    
    const PAYMENT_BY_MBK = '/myBank.aspx';
    const PAYMENT_BY_ALP = '/alipay.aspx';
    const PAYMENT_BY_CUP = '/Chinaunionpay.aspx';
    const PAYMENT_BY_WCH = '/wechat.aspx';
    const PAYMENT_BY_GRP = '/giropay.aspx';
    const PAYMENT_BY_SFT = '/sofort.aspx';
    const PAYMENT_BY_IDL = '/ideal.aspx ';
    const PAYMENT_BY_P24 = '/p24.aspx';
    const PAYMENT_BY_MTB = '/multibanco.aspx';
    const PAYMENT_BY_ZMP = '/zimpler.aspx';

    // TODO: Are these methods available? 
    const PAYMENT_BY_SSL = '/payssl.aspx';
    const PAYMENT_BY_ELV = '/payelv.aspx';
    const PAYMENT_BY_PPL = '/paypal.aspx';

    const DEFAULT_LANGUAGE = 'EN';

    /**
     * 
     * @return object
     *
     * @throws \Exception
     */
    public function __construct ($test){
       $this->test = $test;

       if($test){
            $this->dMerchantId = 'bnlp_test';
            $this->dBlowfishPassword = 'X*b89Q=eG!s23rJ[';
            $this->dHsMacPassword = '8d)N?7Zg2Jz=(4Gs3y!T_Wx59k[R*6Cn';
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
        $initObj = new Init\ComputopCgInit(); 
        $url= ComputopUtils::getValue($params,'baseURL','');

        $initObj->transId = ComputopUtils::getValue($params, 'paymentReference');
        $initObj->amount = ComputopUtils::getValue($params, 'amount', '0');
        $initObj->currency = ComputopUtils::getValue($params,'currency','EUR');
        $initObj->description = ComputopUtils::getValue($params,'description');
        $initObj->UrlSuccess = $url.ComputopUtils::getValue($params,'callbackUrl','');
        $initObj->UrlFailure = $url.ComputopUtils::getValue($params,'errorUrl','');
        $initObj->UrlNotify = $url.ComputopUtils::getValue($params,'notifyUrl','');
        $initObj->capture = ComputopUtils::getValue($params,'transactionType','AUTO');
        $initObj->langID =ComputopUtils::getValue($params, 'language', self::DEFAULT_LANGUAGE);

        $initObj->userData = ComputopUtils::getValue($params,'userData');

        $initObj->serverUrl = $this->sUrl.ComputopUtils::getValue($params,'paymentMethod');
        $initObj->merchantId = ComputopUtils::getValue($params,'terminalId',$this->dMerchantId);     
        $initObj->blowfishPassword = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $initObj->hMacPassword = ComputopUtils::getValue($params,'hMacPassword',$this->dHsMacPassword);

        return $initObj->execute();
    }
    /**
     * 
     * Verify transaction. Receive only the status of the specific transaction.
     * 
     * @param array $params
     * @return array|object
     */
    public function verify(array $params = [])
    {
        $rsltObj = new Init\ComputopCgVerify(); 

        $rsltObj->blowfishPassword = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $rsltObj->len = ComputopUtils::getValue($params, 'Len');
        $rsltObj->data = ComputopUtils::getValue($params, 'Data');

        return $rsltObj->execute();
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
        
    }

    /**
     * 
     * Refund transaction. Return a specific amount back to buyer.
     * 
     * @param array $params
     * @return array|object
     */
    public function refund(array $params = []){

    }
}