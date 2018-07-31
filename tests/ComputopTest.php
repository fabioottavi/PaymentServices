<?php
use PHPUnit\Framework\TestCase;

final class ComputopTest extends TestCase
{
    private $orderNumber;

    public function setUp(){
        $this->orderNumber = uniqid(rand(0,100000), true);
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
            'baseURL' => "https://localhost/ctPaygatePHP",
            'notifyUrl' => '/notify.php',
            'callbackUrl' => '/success.php',
            'errorUrl' => '/failure.php',
            'amount' => 1.1,
            'orderReference' => $this->orderNumber,
            'paymentReference' => $this->orderNumber,
            'transactionType' => 'AUTO', 
            'description' => 'Casuale',
            'language' => 'it_IT', 
            'paymentMethod' => 'visa', // test with: cc,mybank,alipay,cupay,wechat,giropay,sofort,ideal,p24,multibanco,zimpler
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => 'EUR',
            'addInfo1' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo2' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo3' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo4' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'addInfo5' => '[BNL Demo] Ordine da nuovo cliente (145) - {order_date}',
            'acquirer' => 'bnlpositivity',

            'hMacPassword' => null,
            
            // Extra values
            'addrCountryCode' => '380',
            'sellingPoint' => 'BNL Demo',
            'accOwner' => null,
            'device' => null,
            'email' => null,
            'phone' => null,
            'scheme' => null,
            'bic' => null,
            'expirationTime' => null,
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
            'shippingDetails' => null,
            'invoiceDetails' => null,
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
            'UrlParams' => 'Len=361&Data=6256CF18B10A0FBE4D9028746090F3D1183DD61E4C65649C2B77EB3DEE35837EAD31FC2886FCB063E10F8C9004B281B98DEF79ED7C62C10BA8F91AADD41DFA6BCF835BD20F808E2D3578786DEE988D8049D65A9896C5B4C796311269FC12E202CB1A0504DFC748C082C77A8B540876EBBB3F62B18C18985AC648E481B77A509E8D8EECE8099CA005AC7CCC0B1514308338BC6E8DAC8193770CE8A2F831F7474A015147C66EAB7FCC5E57CD4E1E8BB6537ADF915BC73F1E83B47BD92955874870D19E63CCE2B7F0744B653522F0AE29E3182119C37162220887039550C30A00E49FC7C6221CFB366F502F514953DEF6831B34355744BC2D377B417BB6F205886E542955D95BEE29F369D41FF7D6817CEB9AF51ED6803A434CC40409489E74AF1640B76CF96F659AAD9D7093920458246BBD5E6EB93B19C9123754C07A3821EAFCC59425CFD517B33B403CF32ABE81422F0B3E3BEA82B649536D0E519A5360DB3A10221CC2312AF2B8DE4998C985A5A80A',
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
            'payId' => '65c4fe6b27944a8b84bad2c49d5fe098', // we retrieve it from them
            'paymentReference' => '612365b608a07991679.62622481',
            'orderReference' => '612365b608a07991679.62622481',
            'amount' => 1.1,
            'currency' => null,
            'acquirer' => 'bnlpositivity',
        ];

        //get response from gateway
        $pResult = $payg->confirm($params);
        var_dump($pResult);
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
            'payId' => '65c4fe6b27944a8b84bad2c49d5fe098', // we retrieve it from them
            'paymentReference' => '612365b608a07991679.62622481',
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
            'terminalId' => null,
            'hashMessage' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->orderNumber,
            'orderReference' => $this->orderNumber,
            'amount' => 17,
            'currency' => null,
            'acquirer' => 'bnlpositivity',
            'xId' => '',
        ];

        //get response from gateway
        //$pResult = $payg->cancel($params);
        //var_dump($pResult);
    }

    public function testXml(){
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        //var_dump($payg->getSellingLocations());
    }
}

