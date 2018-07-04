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
            'trType' => PayGateway::TRANSACTION_TYPE_AUTH, //TODO: Test with: TRANSACTION_TYPE_VERIFY, TRANSACTION_TYPE_PURCHASE
            'checkoutMode' => PayGateway::CHECK_OUT_NORMAL, //TODO: Test with: CHECK_OUT_SYNTHESIS, CHECK_OUT_SELECT
            'tid' => '06165845',
            'kSig' => 'xHosiSb08fs8BQmt9Yhq3Ub99E8=',
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',
            'payInstrToken' => '', // TODO:
            'notifyUrl' => '/Save',
            'email' => '', // TODO: must be inserted into the request
            'currencyCode' => 'EUR',
            'shopID' => 'WOOC000001O00000001P001',
            'langID' => 'IT',

            'paymentMethod'=>$payg::PAYMENT_BY_SELECTION, //TODO: Test with: PAYMENT_BY_CC,PAYMENT_BY_MY_BANK,PAYMENT_BY_MASTERPASS,PAYMENT_BY_PAYPAL
            'token' => $unique,
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'amount' => 17 * 100,
            'debug' => true,

            'description' => 'this is a test',
            'shopUserRef' => 'Test',
            'shopUserName' => 'Test',
            'regenPayInstrToken' => '',  // TODO: how do i use it?
            
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);


    }
    public function testVerify(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );

        $params = [
            'paymentID'=>'00184353378108749731',
            'tid' => '06165845',
            'kSig' => 'xHosiSb08fs8BQmt9Yhq3Ub99E8=',
            'shopID' => 'WOOC000001O00000001P001',
            'langID' => 'IT',
            
        ];
        // response for verify method
        $verifyResponse = $payg->verify($params);
        var_dump($verifyResponse);
    }
}

