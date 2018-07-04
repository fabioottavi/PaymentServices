<?php

use PHPUnit\Framework\TestCase;

final class IgfcTest extends TestCase
{
    public function testInit()
    {
        $payg = PayGateway::getIstance(PayGateway::IGFC);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        
        $params = [
            'amount' => 100,
            'shopID' => 'WOOC000001O00000001P001',
        ];
        $initresponse = $payg->init($params);
        var_dump($initresponse);
    }
}

