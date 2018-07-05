<?php
use PHPUnit\Framework\TestCase;

final class IgfcTest extends TestCase
{

    private $ksig = 'xHosiSb08fs8BQmt9Yhq3Ub99E8=';
    private $orderNumber;

    public function setUp(){
        $this->orderNumber = uniqid(rand(), true);
    }

    public function testInit()
    {
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        
        $params = [
            'trType' => PayGateway::TRANSACTION_TYPE_AUTH, //TODO: Test with: TRANSACTION_TYPE_VERIFY, TRANSACTION_TYPE_PURCHASE
            'checkoutMode' => PayGateway::CHECK_OUT_NORMAL, //TODO: Test with: CHECK_OUT_SYNTHESIS, CHECK_OUT_SELECT
            'tid' => '06231955',
            'kSig' => $this->ksig,
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',
            'payInstrToken' => '', // TODO:
            'notifyUrl' => '/Save',
            'callbackUrl' => '/Save',
            'errorUrl' => '/Save',
            'currencyCode' => 'EUR',
            'shopID' => $this->orderNumber,
            'langID' => 'IT',

            'paymentMethod'=>$payg::PAYMENT_BY_SELECTION, //TODO: Test with: PAYMENT_BY_CC,PAYMENT_BY_MY_BANK,PAYMENT_BY_MASTERPASS,PAYMENT_BY_PAYPAL
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'amount' => 17 * 100,

            'description' => 'this is a test',
            'shopUserRef' => 'TestRef', // It's the client email
            'shopUserName' => 'TestName',
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
            'paymentID'=>'00186701744108761715', // paymentID => retrive from init() call
            'tid' => '06231955_S', // tid => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'kSig' => $this->ksig,
            'shopID' => '11505390065b3dd1b830c4b1.77223084',
            'langID' => 'IT',
        ];
        // response for verify method
        $verifyResponse = $payg->verify($params);
        var_dump($verifyResponse);
    }

    public function testConfirm(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );

        $params = [
            'transactionId'=>'3066015420386130', // tranID => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'amount' => 17 * 100,
            'tid' => '06231955', // tid => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'kSig' => $this->ksig,
            'shopID' => '1032975365b3ce858093ba3.97953546',
        ];
        
        // response for verify method
        $confirmResponse = $payg->confirm($params);
        var_dump($confirmResponse);
    }
}

