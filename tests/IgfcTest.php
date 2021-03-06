<?php
use PHPUnit\Framework\TestCase;
use Bnlpositivity\Payment\PayGateway;

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
            'baseURL' => "https://localhost/ctPaygatePHP",
            'notifyUrl' => '/igfs.php',
            'callbackUrl' => '/testCback.php',
            'errorUrl' => '/testError.php',
            'amount' => 1.89,
            'orderReference' => $this->orderNumber,
            'transactionType' => 'AUTH', //TODO: Test with: PURCHASE, AUTH, VERIFY
            'description' => 'this is a test',
            'language' => 'it_IT',
            'paymentMethod'=>'', //TODO: Test with: cc,mybank,masterpass,findomestic,paypal
            'terminalId' => '', // null => if it's in test mode it will point to the test tId
            'hashMessage' => '',
            'currency' => 'EUR',
            'addInfo1' => '',
            'addInfo2' => '',
            'addInfo3' => '',
            'addInfo4' => '',
            'addInfo5' => '',

            //not used
            //'checkoutMode' => $payg::CHECK_OUT_NORMAL, //TODO: Test with: CHECK_OUT_SYNTHESIS, CHECK_OUT_SELECT
            'payInstrToken' => 'test', // TODO:
            'shopUserRef' => 'TestRef@sendabox.it', // It's the client email
            'shopUserName' => 'TestName',
            
            'terminalIdFindomestic' => '93885445',
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
            'orderReference' => '21316803735b5f1e251ad3b0.19051507',
            'language' => 'IT',
            'terminalId' => null,
            'hashMessage' => null,

            'paymentID'=>'00211978224108920891', // paymentID => retrive from init() call
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

    public function testXmlCurrencies(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        //var_dump($payg->getCurrenciesAllowed(true));
    }
    public function testgetLanguagesAllowed(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        //var_dump($payg->getLanguagesAllowed());
    }
    public function testXml(){
        $payg = PayGateway::getIstance(PayGateway::IGFC, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Igfs\Gateway::class,
            $payg
        );
        //var_dump($payg->getSellingLocations());
    }

}

