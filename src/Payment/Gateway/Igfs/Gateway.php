<?php

namespace Payment\Gateway\Igfs;

class Gateway implements \Payment\GatewayInterface
{
    private $serverUrl;
    private $test;
    private $dTid = '';
    private $dKsig = '';

    const DEFAULT_INFO1 = '';
    const DEFAULT_INFO2 = '';
    const DEFAULT_INFO3 = '';
    const DEFAULT_INFO4 = '';
    const DEFAULT_INFO5 = '';
    
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
            $this->serverUrl ='https://merchant.s2stest.bnlpositivity.it/BNL_CG_SERVICES/services/';
            $this->dTid = '06231955';
            $this->dKsig = 'xHosiSb08fs8BQmt9Yhq3Ub99E8=';
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
        $unique = IgfsUtils::getValue($params, 'orderReference');
        $url= IgfsUtils::getValue($params,'baseURL','');

        $initObj->serverURL = $this->serverUrl;
        if($this->test){
            $initObj->disableCheckSSLCert();
        }
        $initObj->tid = IgfsUtils::getValue($params,'terminalId',$this->dTid).$this->getInstrumentCode(IgfsUtils::getValue($params,'paymentMethod'));
        $initObj->shopID = $unique;
        $initObj->amount = str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $initObj->currencyCode =IgfsUtils::getValue($params,'currency','EUR');
        $initObj->kSig = IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $initObj->notifyURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'notifyUrl',''), 'token='.urlencode($unique));
        $initObj->errorURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'errorUrl',''), 'token='.urlencode($unique));
        $initObj->callbackURL = IgfsUtils::appendParameter($url.IgfsUtils::getValue($params,'callbackUrl',''), 'token='.urlencode($unique));
        $initObj->addInfo1 = substr(IgfsUtils::getValue($params,'addInfo1',self::DEFAULT_INFO1),0,256);
        $initObj->addInfo2 = substr(IgfsUtils::getValue($params,'addInfo2',self::DEFAULT_INFO2),0,256);
        $initObj->addInfo3 = substr(IgfsUtils::getValue($params,'addInfo3',self::DEFAULT_INFO3),0,256);
        $initObj->addInfo4 = substr(IgfsUtils::getValue($params,'addInfo4',self::DEFAULT_INFO4),0,256);
        $initObj->addInfo5 = substr(IgfsUtils::getValue($params,'addInfo5',self::DEFAULT_INFO5),0,256);
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
            'message' => $initObj->errorDesc,
            'error' => $initObj->rc !== 'IGFS_000',
            'paymentID' => $initObj->paymentID,
            'orderReference' => $initObj->shopID,
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
        $verifyObj->kSig = IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $verifyObj->tid = IgfsUtils::getValue($params,'terminalId',$this->dTid).'_S';
        $verifyObj->shopID = IgfsUtils::getValue($params, 'orderReference');
        $verifyObj->langID =IgfsUtils::getValue($params, 'language', 'IT');
        $verifyObj->paymentID =IgfsUtils::getValue($params, 'paymentID', '00179695241108714733');


        $verifyObj->execute();
        return array(
            'terminalId' => $verifyObj->tid,
            'returnCode' => $verifyObj->rc,
            'message' => $verifyObj->errorDesc,
            'error' => $verifyObj->rc !== 'IGFS_000',
            'orderReference' => $verifyObj->shopID,
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
        $confirmObj->kSig= IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $confirmObj->shopID= IgfsUtils::getValue($params, 'orderReference');
        $confirmObj->refTranID= IgfsUtils::getValue($params, 'paymentReference');
        $confirmObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        
        $confirmObj->execute();
        return array(
            'terminalId' => $confirmObj->tid,
            'returnCode' => $confirmObj->rc,
            'message' => $confirmObj->errorDesc,
            'error' => $confirmObj->rc !== 'IGFS_000',
            'refTranID' => $confirmObj->refTranID,
            'tranID' => $confirmObj->tranID,
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
        $rfdObj->kSig= IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $rfdObj->shopID= IgfsUtils::getValue($params, 'orderReference');
        $rfdObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $rfdObj->refTranID= IgfsUtils::getValue($params, 'paymentReference');

        $rfdObj->execute();
        return array(
            'terminalId' => $rfdObj->tid,
            'returnCode' => $rfdObj->rc,
            'message' => $rfdObj->errorDesc,
            'error' => $rfdObj->rc !== 'IGFS_000',
            'orderReference' => $rfdObj->shopID,
            'tranID' => $rfdObj->tranID,
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
        $rfdObj = new tran\IgfsCgVoidAuth();
        
        $rfdObj->serverURL = $this->serverUrl;
        $rfdObj->tid= IgfsUtils::getValue($params,'terminalId',$this->dTid);
        $rfdObj->kSig= IgfsUtils::getValue($params,'hashMessage',$this->dKsig);
        $rfdObj->shopID= IgfsUtils::getValue($params, 'orderReference');
        $rfdObj->amount= str_replace('.', '', number_format(IgfsUtils::getValue($params, 'amount', '0'), 2, '.', ''));
        $rfdObj->refTranID= IgfsUtils::getValue($params, 'paymentReference');
        
        $rfdObj->execute();
        return array(
            'terminalId' => $rfdObj->tid,
            'orderReference' => $rfdObj->shopID,
            'tranID' => $rfdObj->tranID,
            'refTranID' => $rfdObj->refTranID,
            'returnCode' => $rfdObj->rc,
            'message' => $rfdObj->errorDesc,
            'error' => $rfdObj->rc !== 'IGFS_000',
        );
    }
    /**
     * 
     * Return all the possible payment instruments
     * 
     * @param 
     * @return array|object
     */
    public function getPaymentInstruments(){
        return array(
            'cc' => 'Credit Card',
            'mybank' => 'MyBank',
            'masterpass'  => 'Masterpass',
            'findomestic' => 'Findomestic',
            'paypal'      => 'PayPal'
          );
    }
    /**
     * 
     * Return the extra characters that has to be added in the tId during the initialization
     * 
     * @param string $inst
     * @return string
     */
    private function getInstrumentCode($inst){
        $code = '_S';
        switch ($inst) {
            case 'cc':
                $code = '';
                break;
            case 'mybank':
                $code = 'M';
                break;
            case 'masterpass':
                $code = 'P';
                break;
            case 'findomestic':
                $code = ''; //TODO: ????
                break;
            case 'paypal':
                $code = 'PP';
                break;
        }
        return $code;
    }
    /**
     * 
     * Return all the possible transaction types
     * 
     * @param 
     * @return array|object
     */
    public function getTransactionTypes(){
        return array(
            'PURCHASE'  => 'Acquisto',
            'AUTH'      => 'Preautorizzazione',
            'VERIFY'    => 'Verifica',
          );
    }
    /**
     * 
     * Return all the possible cheout types
     * 
     * @param 
     * @return array|object
     */
    public function getCheckoutTypes(){
        return array(
            '1'  => 'Checkout BNLP',
            '2'  => 'Checkout BNLP con sintesi in web store',
            '3'  => 'Checkout BNLP con selezione strumento di pagamento su web store',
          );
      }
    /**
     * Get Allowed Currencies
     *
     * @return array|object
     */
    public function getCurrenciesAllowed(){
        return array(
            array(
                'title' => __('Euro', 'bnppay'),
                'code' => 'EUR',
                'symbol' => '&euro;',
            ),
            array(
                'title' => __('Dollar', 'bnppay'),
                'code' => 'USD',
                'symbol' => '$',
            ),
            array(
                'title' => __('Pound Sterling', 'bnppay'),
                'code' => 'GBP',
                'symbol' => '&pound;',
            )
        );
    }
    /**
     * Get Allowed Languages
     *
     * @return array|object
     */
    public function getLanguagesAllowed(){
        return array(
            array(
                'code' => 'IT',
                'name' => 'Italiano',
            ),
            array(
                'code' => 'EN',
                'name' => 'Inglese',
            ),
            array(
                'code' => 'FR',
                'name' => 'Francese',
            ),
        );
    }
}