<?php
use PHPUnit\Framework\TestCase;

final class ComputopTest extends TestCase
{
    private $orderNumber;
    private $paymentNumber;

    public function setUp(){
        $this->orderNumber = uniqid(rand(0,100000), true);
        $this->paymentNumber = uniqid(rand(0,100000), true);
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
            'paymentReference' => $this->paymentNumber,
            'transactionType' => 'AUTO', 
            'description' => 'test',
            'language' => null, 
            'paymentMethod' => 'cc', // test with: cc,mybank,alipay,cupay,wechat,giropay,sofort,ideal,p24,multibanco,zimpler
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => null,
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',

            'userData' => 'test',
            'blowfishPassword' => null,
            'hMacPassword' => null,
            
            // Extra values
            'addrCountryCode' => null,
            'sellingPoint' => null,
            'accOwner' => null,
            'device' => null,
            'email' => null,
            'phone' => null,
            'scheme' => null,
            'bic' => null,
            'expirationTime' => null,
            'iban' => null,
            'mobileNo' => null,
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
            'blowfishPassword' => null,
            'UrlParams' => 'Len=353&Data=6256CF18B10A0FBE4D9028746090F3D1142EA6C0E628E99D7EE5BAF8B0DBBC1E2EE4D8AB32A0B76FE0757EB72A82F22748DD0EB16DF24E2A679E55F777A318569B8D27E780DC9E2C2D5AD56A884AD9688A684B3CF73099B2659ADCB3FA11DFCACAE587FCEA3E22FB58C7E18C5F1F560BF8C4FF62CC7A8A000772AD7255D2AD2F02D49A8353843CCC4DF6F890F90BD012C218E0597317C9D62FF02B9607E13B985E57CD4E1E8BB6537ADF915BC73F1E83B47BD92955874870D19E63CCE2B7F0744B653522F0AE29E3182119C371622208AD8F33D29EA379F647F2D86B4184F344F7D18ABAE062D92D6B2B40016612DB507B417BB6F205886E542955D95BEE29F369D41FF7D6817CEB9AF51ED6803A434CC40409489E74AF1640B76CF96F659AADE07C32794BF47A85E0FECFBBFD190F436234F696C0A846570BF9634EB303BD7CB5F274B6649FF0714655314C6F91F46BF5CDDE29F9A2B9BE86A3325C6F5812141A61FA2A48E77C05',
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
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'orderReference' => $this->orderNumber,
            'amount' => 17,
            'currency' => null,
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
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'amount' => 17,
            'currency' => null,
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
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'orderReference' => $this->orderNumber,
            'amount' => 17,
            'currency' => null,
            'xId' => '',
        ];

        //get response from gateway
        //$pResult = $payg->cancel($params);
        //var_dump($pResult);
    }
}

