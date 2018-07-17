<?php
use PHPUnit\Framework\TestCase;

final class IgfcTest extends TestCase
{

    private $orderNumber;

    public function setUp(){
        //As long as the transaction is not finished you can create URLs with the same number
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
            //Same fields on both payment methods
            'baseURL' => "http://ipgadmin.sendabox.it/Callback",
            'notifyUrl' => '/Save',
            'callbackUrl' => '/Save',
            'errorUrl' => '/Save',
            'amount' => 13.89,
            'paymentReference' => $this->orderNumber,
            'transactionType' => $payg::TRANSACTION_TYPE_AUTH, //TODO: Test with: TRANSACTION_TYPE_VERIFY, TRANSACTION_TYPE_PURCHASE
            'description' => 'this is a test',
            'language' => 'IT',
            'paymentMethod'=>$payg::PAYMENT_BY_SELECTION, //TODO: Test with: PAYMENT_BY_CC,PAYMENT_BY_MY_BANK,PAYMENT_BY_MASTERPASS,PAYMENT_BY_PAYPAL
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => 'EUR',


            'checkoutMode' => $payg::CHECK_OUT_NORMAL, //TODO: Test with: CHECK_OUT_SYNTHESIS, CHECK_OUT_SELECT
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',
            'payInstrToken' => '', // TODO:
            'shopUserRef' => 'TestRef', // It's the client email
            'shopUserName' => 'TestName',
            'regenPayInstrToken' => '',  // TODO: how do i use it?
        ];

        //get response from gateway
        //$initResponse = $payg->init($params);
        //var_dump($initResponse);
    }

    public function testVerify(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );

        $params = [
            'paymentID'=>'00190344435108790396', // paymentID => retrive from init() call
            'shopID' => '11116968065b437efd081729.18058802',
            'langID' => 'IT',
            'terminalId' => null,
            'hashMessage' => null,
        ];
        // response for verify method
        //$verifyResponse = $payg->verify($params);
        //var_dump($verifyResponse);
    }

    public function testConfirm(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );

        $params = [
            'transactionId'=>'3066108060556050', // tranID => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'shopID' => '7251284915b4de217b183b5.95711638',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 11.69,
        ];
        
        // response for verify method
        $confirmResponse = $payg->confirm($params);
        var_dump($confirmResponse);
    }

    public function testRefund(){
        $ref = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $ref
        );

        $params = [
            'transactionId'=>'3066108060556050', // tranID => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'shopID' => '7251284915b4de217b183b5.95711638',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 2.2,
        ];
        
        // response for verify method
        //$refResponse = $ref->refund($params);
        //var_dump($refResponse);
    }
    
    public function testCancel(){
        $ref = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $ref
        );

        $params = [
            'transactionId'=>'3066108060556050', // tranID => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
            'shopID' => '7251284915b4de217b183b5.95711638',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 2.2,
        ];
        
        // response for verify method
        //$refResponse = $ref->cancel($params);
        //var_dump($refResponse);
    }
}

