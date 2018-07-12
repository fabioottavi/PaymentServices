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
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'amount' => 17,
            'shopID' => $this->orderNumber,
            'notifyUrl' => '/Notify',
            'callbackUrl' => '/Success',
            'errorUrl' => '/Failure',
            'merchantId' => 'bnlp_test',
            'blowfishPassword' => 'X*b89Q=eG!s23rJ[',
            'hMacPassword' => '8d)N?7Zg2Jz=(4Gs3y!T_Wx59k[R*6Cn',
            'description' => '',
            'userData' => '',
            'paymentMethod' => $payg::PAYMENT_BY_SSL
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);
    }
}

