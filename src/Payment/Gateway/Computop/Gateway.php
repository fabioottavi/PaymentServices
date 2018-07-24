<?php

namespace Payment\Gateway\Computop;

class Gateway implements \Payment\GatewayInterface
{
    private $test;
    private $dMerchantId = 'bnlp_test';
    private $dBlowfishPassword = 'X*b89Q=eG!s23rJ[';
    private $dHsMacPassword = '8d)N?7Zg2Jz=(4Gs3y!T_Wx59k[R*6Cn';
    //private $sUrl = 'https://ecpay.bnlpositivity.it/paymentpage';
    private $sUrl ='https://www.computop-paygate.com';
    
    //const PAYMENT_BY_MBK = '/myBank.aspx'; // need addrCountryCode,accOwner
    //const PAYMENT_BY_ALP = '/alipay.aspx'; // need accOwner
    //const PAYMENT_BY_CUP = '/Chinaunionpay.aspx'; // need accOwner
    //const PAYMENT_BY_WCH = '/wechat.aspx'; // need addrCountryCode,accOwner
    //const PAYMENT_BY_GRP = '/giropay.aspx'; // PayID=00000000000000000000000000000000&TransID=na&Status=FAILED&Description=UnexpectedError
    //const PAYMENT_BY_SFT = '/sofort.aspx'; // need addrCountryCode,accOwner
    //const PAYMENT_BY_IDL = '/ideal.aspx'; // PAYMETHOD INVALID
    //const PAYMENT_BY_P24 = '/p24.aspx'; // need accOwner
    //const PAYMENT_BY_MTB = '/multibanco.aspx'; // need accOwner
    //const PAYMENT_BY_ZMP = '/zimpler.aspx'; // need addrCountryCode,accOwner
    //const PAYMENT_BY_SSL = '/payssl.aspx'; // always fail
    
    // Action methods 
    const ACTION_CAPTURE = '/capture.aspx';
    const ACTION_CREDIT = '/credit.aspx';
    const ACTION_REVERSE = '/reverse.aspx';

    // Languages
    const DEFAULT_LANGUAGE = 'EN';

    // Transaction types
    const TRASACTION_AUTO = 'AUTO';
    const TRASACTION_MANUAL = 'MANUAL';

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
        $mId = ComputopUtils::getValue($params,'terminalId',$this->dMerchantId);    
        $bPs = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $hMcPd = ComputopUtils::getValue($params,'hMacPassword',$this->dHsMacPassword);
        $url= ComputopUtils::getValue($params,'baseURL','');

        $initObj = $this->getInstrumentEndpoint($mId,$bPs,$hMcPd,ComputopUtils::getValue($params,'paymentMethod'));
        $initObj->capture = ComputopUtils::getValue($params,'transactionType',self::TRASACTION_AUTO);
        $initObj->transId = ComputopUtils::getValue($params, 'paymentReference');
        $initObj->refNr = ComputopUtils::getValue($params, 'orderReference');
        $initObj->amount = str_replace('.', '', number_format(ComputopUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $initObj->currency = ComputopUtils::getValue($params,'currency',BaseComputopCg::DEFAULT_CURRENCY);
        $initObj->description = ComputopUtils::getValue($params,'description');
        $initObj->langID =ComputopUtils::getValue($params, 'language', self::DEFAULT_LANGUAGE);
        $initObj->UrlSuccess = $url.ComputopUtils::getValue($params,'callbackUrl','');
        $initObj->UrlFailure = $url.ComputopUtils::getValue($params,'errorUrl','');
        $initObj->UrlNotify = $url.ComputopUtils::getValue($params,'notifyUrl','');
        $initObj->userData = ComputopUtils::getValue($params,'userData');
        $initObj->payId = ComputopUtils::getValue($params,'payId','');     

        // Extra values
        $initObj->addrCountryCode = ComputopUtils::getValue($params,'addrCountryCode','');     
        $initObj->sellingPoint = ComputopUtils::getValue($params,'sellingPoint','');     
        $initObj->accOwner = ComputopUtils::getValue($params,'accOwner','');     
        $initObj->device = ComputopUtils::getValue($params,'device','');  // if device = "Mobile" it show the mobile version    
        $initObj->email = ComputopUtils::getValue($params,'email','');    
        $initObj->phone = ComputopUtils::getValue($params,'phone','');     
        $initObj->scheme = ComputopUtils::getValue($params,'scheme','');     
        $initObj->bic = ComputopUtils::getValue($params,'bic','');     
        $initObj->expirationTime = ComputopUtils::getValue($params,'expirationTime','');     
        $initObj->iban = ComputopUtils::getValue($params,'iban','');   
        $initObj->mobileNo = ComputopUtils::getValue($params,'mobileNo','');     

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
        $rsltObj = new Init\ComputopCgVerify(ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword),ComputopUtils::getValue($params, 'UrlParams')); 
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
        $mId = ComputopUtils::getValue($params,'terminalId',$this->dMerchantId);    
        $bPs = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $hMcPd = ComputopUtils::getValue($params,'hMacPassword',$this->dHsMacPassword);

        $obj = new S2S\ComputopCgCapture($mId,$bPs,$hMcPd); 
        $obj->serverUrl = $this->sUrl.self::ACTION_CAPTURE;
        
        $obj->payId = ComputopUtils::getValue($params,'payId','');     
        $obj->transId = ComputopUtils::getValue($params, 'paymentReference');
        $obj->amount = ComputopUtils::getValue($params, 'amount', '0');
        $obj->currency = ComputopUtils::getValue($params,'currency',BaseComputopCg::DEFAULT_CURRENCY);
        $obj->refNr = ComputopUtils::getValue($params, 'orderReference');

        $obj->execute();
        return array(
            'MID' => $obj->mId,
            'PayID' => $obj->payId,
            'XID' => $obj->xId,
            'TransID' => $obj->transId,
            'Status' => $obj->status,
            'Description' => $obj->description,
            'Code' => $obj->code,
            'MAC' => $obj->mac,
            'RefNr' => $obj->refNr,
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

        $mId = ComputopUtils::getValue($params,'terminalId',$this->dMerchantId);    
        $bPs = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $hMcPd = ComputopUtils::getValue($params,'hMacPassword',$this->dHsMacPassword);

        $obj = new S2S\ComputopCgCredit($mId,$bPs,$hMcPd); 
        $obj->serverUrl = $this->sUrl.self::ACTION_CREDIT;
        
        $obj->payId = ComputopUtils::getValue($params,'payId','');     
        $obj->transId = ComputopUtils::getValue($params, 'paymentReference');
        $obj->amount = ComputopUtils::getValue($params, 'amount', '0');
        $obj->currency = ComputopUtils::getValue($params,'currency',BaseComputopCg::DEFAULT_CURRENCY);

        $obj->execute();
        return array(
            'MID' => $obj->mId,
            'PayID' => $obj->payId,
            'XID' => $obj->xId,
            'TransID' => $obj->transId,
            'Status' => $obj->status,
            'Description' => $obj->description,
            'Code' => $obj->code,
            'MAC' => $obj->mac,
        ); 
    }
    /**
     * 
     * Cancel pending transaction. Return a specific amount back to buyer.
     * 
     * @param array $params
     * @return array|object
     */
    public function cancel(array $params){
        
        $mId = ComputopUtils::getValue($params,'terminalId',$this->dMerchantId);    
        $bPs = ComputopUtils::getValue($params,'blowfishPassword',$this->dBlowfishPassword);
        $hMcPd = ComputopUtils::getValue($params,'hMacPassword',$this->dHsMacPassword);

        $obj = new S2S\ComputopCgCapture($mId,$bPs,$hMcPd); 
        $obj->serverUrl = $this->sUrl.self::ACTION_REVERSE;
        
        $obj->payId = ComputopUtils::getValue($params,'payId','');   
        $obj->xId = ComputopUtils::getValue($params,'xId','');
        $obj->transId = ComputopUtils::getValue($params, 'paymentReference');
        $obj->refNr = ComputopUtils::getValue($params, 'orderReference');
        $obj->amount = ComputopUtils::getValue($params, 'amount', '0');
        $obj->currency = ComputopUtils::getValue($params,'currency',BaseComputopCg::DEFAULT_CURRENCY);

        $obj->execute();
        return array(
            'MID' => $obj->mId,
            'PayID' => $obj->payId,
            'XID' => $obj->xId,
            'TransID' => $obj->transId,
            'Status' => $obj->status,
            'Description' => $obj->description,
            'Code' => $obj->code,
            'MAC' => $obj->mac,
            'RefNr' => $obj->refNr,
        ); 
    }
    /**
     * 
     * Return all the possible payment instruments
     * 
     * @return array|object
     */
    public function getPaymentInstruments(){
        return array(
            'cc' => 'Credit Card',
            'mybank' => 'MyBank',
            'alipay' => 'Alipay',
            'cupay' => 'Chinaunionpay',
            'wechat' => 'WeChat',
            'giropay' => 'Giropay',
            'sofort' => 'Sofort',
            'ideal' => 'Ideal',
            'p24' => 'P24',
            'multibanco' => 'Multibanco',
            'zimpler' => 'Zimpler'
          );
    }
    /**
     * 
     * Return the endpoint action
     * 
     * @param string $inst
     * @return string
     */
    private function getInstrumentEndpoint($mId,$bPs,$hMcPd,$inst){
        $obj;
        switch ($inst) {
            case 'cc':
                $obj = new Init\ComputopCgInit($mId,$bPs,$hMcPd,$this->sUrl); 
                break;
            case 'mybank':
                $obj = new Init\ComputopCgInitMyBank($mId,$bPs,$hMcPd,$this->sUrl); 
                break;
            case 'alipay' : 
                $obj = new Init\ComputopCgInitAlipay($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'cupay' : 
                $obj = new Init\ComputopCgInitCup($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'wechat' : 
                $obj = new Init\ComputopCgInitWeChat($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'giropay' : 
                $obj = new Init\ComputopCgInitGiroPay($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'sofort' : 
                $obj = new Init\ComputopCgInitSofort($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'ideal' : 
                $obj = new Init\ComputopCgInitIdeal($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'p24' : 
                $obj = new Init\ComputopCgInitP24($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'multibanco' : 
                $obj = new Init\ComputopCgInitMultibanco($mId,$bPs,$hMcPd,$this->sUrl);
                break;
            case 'zimpler' : 
                $obj = new Init\ComputopCgInitZimpler($mId,$bPs,$hMcPd,$this->sUrl);
                break; 
        }
        return $obj;
    }
    /**
     * 
     * Return all the possible transaction types
     * 
     * @return array|object
     */
    public function getTransactionTypes(){
        return array(
            'AUTO' => 'Acquisto',
            'MANUAL' => 'Preautorizzazione',
          );
    }
    /**
     * 
     * Return all the possible cheout types
     * 
     * @return array|object
     */
    public function getCheckoutTypes(){
        return array(
          '1'  => 'Checkout BNLP con selezione strumento di pagamento su web store',
        );
      }
}