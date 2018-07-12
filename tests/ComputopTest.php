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
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'notifyUrl' => '/Notify',
            'callbackUrl' => '/Success',
            'errorUrl' => '/Failure',
            'amount' => 17,
            'paymentReference' => $this->orderNumber,
            'transactionType' => null, 
            'description' => '',
            'language' => null, 
            'paymentMethod' => $payg::PAYMENT_BY_SSL,
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => null,

            'userData' => '',
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);
    }
}

