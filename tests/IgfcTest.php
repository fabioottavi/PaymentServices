<?php
use PHPUnit\Framework\TestCase;

final class IgfcTest extends TestCase
{
    public function testInit()
    {
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        
        $unique = uniqid(rand(), true);
        $params = [
            'token' => $unique,
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'amount' => 17 * 100,
            'shopID' => 'WOOC000001O00000001P001',
            'debug' => true,
            'notifyUrl' => '/Save',
            'currencyCode' => 'EUR',
            'tid' => '06165845',
            'langID' => 'IT',
            'kSig' => 'xHosiSb08fs8BQmt9Yhq3Ub99E8=',
            'currencyCode' => 'EUR',
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',

        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);

        // response for verify method
        $verifyResponse = $payg->verify($params);
        var_dump($verifyResponse);
    }
}

