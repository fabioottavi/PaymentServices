<?php
use PHPUnit\Framework\TestCase;

final class ComputopTest extends TestCase
{
    private $orderNumber;

    public function setUp(){
        $this->orderNumber = uniqid(rand(), true);
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
            'amount' => 17,
            'paymentReference' => $this->orderNumber,
            'transactionType' => null, 
            'description' => '',
            'language' => null, 
            'paymentMethod' => $payg::PAYMENT_BY_PPL,
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => null,

            'userData' => '',
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
            'Len' => '335',
            'Data' => '6256CF18B10A0FBE4D9028746090F3D103C804719E0D7F4C843E59CE5CBBCF199E8514EC4AAF6A66B23D9596AFCFB7FC8176759738BD43093DE3962EE5438E51BD519B49F6639172E6DBA6BD41989DB7EEFD7F8E068D8B7576A3B9DD39793523D7D36286813BAB8D3C175927377D7089665EF7F6087D698163DA93DD6F4AE71B12E20C2BEF58BD0A26E46F808A9B074D0C51F34B98223C41F56C349F436A197FA5CBBEC497AC88E35A68D13E60C1AA8BFEB17EB011B1CAF5F0ADDD4402AE00F93857AA0623760F2869D4D34F978B27D7E035036B9DE7E20CA6BF0B9C6F9A946436FAF55817B42695BE885FED41841358FAE250491EE01B8CE4C52E2A171781ED4506FA3215918450F99115C43BEDEAA37A927DB51F9558B959C15F281AA900418D7C6C5D53ABF837B7C6FC658A46432D2B79BFD1FAB5F84829792FF774C2ABAB41EB599E6A61D004115A76A6A026424C',
        ];

        $pResult = $payg->verify($params);
        var_dump($pResult);

    }
}

