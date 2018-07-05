<?php
use PHPUnit\Framework\TestCase;

final class ComputopTest extends TestCase
{
    public function testInit()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );
        
        $unique = uniqid(rand(), true);
        $params = [
            'trType' => 'AUTH',
            'checkoutMode' => PayGateway::CHOUT,
            'tid' => '06165845',
            'kSig' => 'xHosiSb08fs8BQmt9Yhq3Ub99E8=',
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',
            'payInstrToken' => '',
            'notifyUrl' => '/Save',
            'shopID' => 'WOOC000001O00000001P001',
            'langID' => 'IT', // TODO: vedi foglio dati init a cronfronto

            'token' => $unique,
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'amount' => 17 * 100,
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);



        // response for verify method
        $verifyResponse = $payg->verify($params);
        var_dump($verifyResponse);
    }
}

