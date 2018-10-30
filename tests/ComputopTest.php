<?php
use PHPUnit\Framework\TestCase;
use Bnlpositivity\Payment\PayGateway;

final class ComputopTest extends TestCase
{
    private $orderNumber;

    public function setUp(){
        $this->orderNumber = str_replace('.','',uniqid(rand(0,100000), true));
    }

    public function testInit()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        
        $params = [
            //Same fields on both payment methods
            'baseURL' => "",
            'notifyUrl' => 'https://dev-ma1.tk/bnlpositivity_paymentservice/init/notify/orderid/100000036/',
            'callbackUrl' => 'https://dev-ma1.tk/bnlpositivity_paymentservice/init/success/orderid/100000036/',
            'errorUrl' => 'https://dev-ma1.tk/bnlpositivity_paymentservice/init/error/orderid/100000036/',
            'amount' => 6.0000,
            'orderReference' => 1540805977,
            'paymentReference' => 1540805977,
            'transactionType' => 'AUTO', 
            'description' => 'Casuale',
            'language' => 'it_IT', 
            'paymentMethod' => 'cc', // test with: cc,mybank,alipay,cupay,wechat,giropay,sofort,ideal,p24,multibanco,zimpler
            'terminalId' => 'bnl_test',
            'hashMessage' => 'Fw3[7(bAP8=or*D2',
            'currency' => 'EUR',
            'addInfo1' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo2' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo3' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo4' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo5' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'acquirer' => 'bnlpositivity',

            'hMacPassword' => '3Hn)[7Pe2Qf(!j8TK=t9*6DsJk5\?m4_C',
            
            // Extra values
            'addrCountryCode' => '004',
            'sellingPoint' => 'Default Store View',
            'accOwner' => null,
            'device' => 'desktop',
            'email' => 'owner@example.com',
            'phone' => null,
            'scheme' => null,
            'bic' => null,
            'expirationTime' => '2018-10-30UTC09:39:37',
            'iban' => null,
            'mobileNo' => null,

            // Configuration values
            'template' => null,
            //'background' => null,
            //'bgColor' => null,
            //'bgImage' => null,
            //'fColor' => null,
            //'fFace' => null,
            //'fSize' => null,
            //'centro' => null,
            //'tWidth' => null,
            //'tHeight' => null,
            
            'logoUrl' => null,
            'shippingDetails' => 'oih, 20156, IT',
            'invoiceDetails' => 'ji, lkj, oih',
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);
    }

    public function testVerify()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        //ComputopUtils::getPaymentResultParam($_GET);
        $params = [
            'hashMessage' => null,
            'UrlParams' => 'mid=bnl_test&PayID=cf79a82132944c698ecbabe3d239ee31&XID=e4cab57b078a4ec78e6b0258ac9a1c20&TransID=748405bb33d6ae8b9c4.98465381&Type=SSL&customfield1=1.1%20EURO&refnr=748405bb33d6ae8b9c4.98465381&Code=00000000&Status=OK&Description=success&MAC=5F5C34868B5857B6DD583BCB0E03B9B08F0E9B4F91F7CFD66CD4397D02677167',
        ];

        //get response from gateway
        //$pResult = $payg->verify($params);
        //var_dump($pResult);
    }

    public function testConfirm()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => null,
            'hashMessage' => null,
            'hMacPassword' => null,
            'paymentID' => '4146830fd2274fb296c8f5e24425ac0b', // we retrieve it from them
            'paymentReference' => '548465bb335daccf4e1.99383120',
            'orderReference' => '548465bb335daccf4e1.99383120',
            'amount' => 1.1,
            'currency' => null,
            'acquirer' => 'bnlpositivity',
        ];

        //get response from gateway
        //$pResult = $payg->confirm($params);
        //var_dump($pResult);
    }

    public function testRefund()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => null,
            'hashMessage' => null,
            'hMacPassword' => null,
            'paymentID' => '4b14cc77abbf4a6d98755e0ddbe17cd7', // we retrieve it from them
            'paymentReference' => '669325bb3397ad6f677.04866787',
            'amount' => 1.1,
            'currency' => null,
            'acquirer' => 'bnlpositivity',
        ];

        //get response from gateway
        //$pResult = $payg->refund($params);
        //var_dump($pResult);
    }

    public function testCancel()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => 'bnl_test',
            'hashMessage' => 'Fw3[7(bAP8=or*D2',
            'hMacPassword' => '3Hn)[7Pe2Qf(!j8TK=t9*6DsJk5?m4_C',
            'paymentID' => '5455bbabb1df44e884a618b1978f72e1', // we retrieve it from them
            'paymentReference' => '1539157394',
            'orderReference' => '1539157394',
            'amount' => 10.00,
            'testmode' => 1,
            'currency' => 'EUR',
            'acquirer' => 'bnlpositivity',
            'xId' => '',
        ];

        //get response from gateway
        //$pResult = $payg->cancel($params);
        //var_dump($pResult);
    }

    public function testSplit(){

        $urls = array('https://dev-wp.tk/checkout/order-received/232/?key=wc_order_5b680faa8b145',
                    'https://dev-wp.tk/checkout/order-received/232/?key=wc_order_5b680faa8b145',
                    'https://dev-wp.tk/cart/?cancel_order=true&order=wc_order_5b680faa8b145&order_id=232&redirect&_wpnonce=8f275c8cd6');
        $onlyParams = \Payment\Gateway\Computop\ComputopUtils::combineQueryParams($urls);
        
        //var_dump($onlyParams);
        //var_dump(\Payment\Gateway\Computop\ComputopUtils::clearUrl('https://dev-wp.tk/checkout/order-received/232/?key=wc_order_5b680faa8b145'));
        //var_dump(\Payment\Gateway\Computop\ComputopUtils::clearUrl('https://dev-wp.tk/cart/?cancel_order=true&order=wc_order_5b680faa8b145&order_id=232&redirect&_wpnonce=8f275c8cd6'));
    }

    public function testXmlCurrencies(){
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        //var_dump($payg->getCurrenciesAllowed(true));
    }

    public function testXml(){
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        //var_dump($payg->getSellingLocations());
    }

    public function testGetLanguagesAllowed(){
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        //var_dump($payg->getLanguagesAllowed());
    }

    public function testGetCheckoutTypes(){
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        //var_dump($payg->getCheckoutTypes());
    }
}

