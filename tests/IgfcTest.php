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
            'orderReference' => $this->orderNumber,
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
            'orderReference' => '7251284915b4de217b183b5.95711638',
            'language' => 'IT',
            'terminalId' => null,
            'hashMessage' => null,

            'paymentID'=>'00198222215108845543', // paymentID => retrive from init() call
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
            'orderReference' => '4104327475b4f19ac562a28.77757816',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 10,
            
            'paymentReference'=>'3066114830711236', // tranID => retrive the final tid from the notifyUrl/callbackUrl/errorUrl
        ];
        
        // response for verify method
        //$confirmResponse = $payg->confirm($params);
        //var_dump($confirmResponse);
    }

    public function testRefund(){
        $ref = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $ref
        );

        $params = [
            'paymentReference'=>'3066114890873273', // tranID => must contain the Transaction ID of the "SETTLEMENT"/"PURCHASE"
            'orderReference' => '4104327475b4f19ac562a28.77757816',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 10,
        ];
        
        // response for refund method
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
            'paymentReference'=>'3066114830711236', // tranID => Must contain the "TRANSACTION ID" of the "Authorization"
            'orderReference' => '4104327475b4f19ac562a28.77757816',
            'terminalId' => null,
            'hashMessage' => null,
            'amount' => 3.89,
        ];
        
        // response for cancel method
        //$refResponse = $ref->cancel($params);
        //var_dump($refResponse);
    }
}

