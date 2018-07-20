<?php
use PHPUnit\Framework\TestCase;

final class ComputopTest extends TestCase
{
    private $orderNumber;
    private $paymentNumber;

    public function setUp(){
        $this->orderNumber = uniqid(rand(), true);
        $this->paymentNumber = uniqid(rand(), true);
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
            'baseURL' => "https://localhost/ctPaygatePHP",
            'notifyUrl' => '/notify.php',
            'callbackUrl' => '/success.php',
            'errorUrl' => '/failure.php',
            'amount' => 17,
            'orderReference' => $this->orderNumber,
            'paymentReference' => $this->paymentNumber,
            'transactionType' => null, 
            'description' => 'test',
            'language' => null, 
            'paymentMethod' => $payg::PAYMENT_BY_SSL,
            'terminalId' => null,
            'hashMessage' => null,
            'currency' => null,

            'userData' => 'test',
            'blowfishPassword' => null,
            'hMacPassword' => null,
        ];

        //get response from gateway
        $initResponse = $payg->init($params);
        var_dump($initResponse);
    }

    public function testVerify()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        //ComputopUtils::getPaymentResultParam($_GET);
        $params = [
            'blowfishPassword' => null,
            'UrlParams' => 'Len=279&Data=6256CF18B10A0FBE4D9028746090F3D19E1CA117E75593AC9D4341101841775B6EB6E3EC590665849C60252740A24C35F0FB06C0EAEBF923A4991AE4AF7909D96B2A3393C7E7089C8B008A9FBFAFF108C165F01488E5736023BB57B5D37E7EC8F4BA4C4C01D33797DA233874ABE285BCD9908A4029A16742A1254404ADB3023FC3BF3B4F574A96288FB3F0E7C9A4C6FB78ED6F02FD3C433D13E248AF46B5283D51AE89F295DF5A7E3FD796812764325C2E9755328C4C5573E8420649FBFF208039D048875B9A0CC403143068AF75C3FA02E6B7323963675CB9E1FD042C4710EBE91CCA5B5C1CDA307BFB6AB09FEB4CDD912D9DF25318D0FE13581D4276D2BD5B6BA2319DF2C014D12B99BB2236E51A11301AE35CB8177D8D',
        ];

        //get response from gateway
        //$pResult = $payg->verify($params);
        //var_dump($pResult);

    }

    public function testConfirm()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => null,
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'orderReference' => $this->orderNumber,
            'amount' => 17,
            'currency' => null,
            'action' => $payg::ACTION_CAPTURE
        ];

        //get response from gateway
        //$pResult = $payg->confirm($params);
        //var_dump($pResult);
    }

    public function testRefund()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => null,
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'amount' => 17,
            'currency' => null,
            'action' => $payg::ACTION_CREDIT
        ];

        //get response from gateway
        //$pResult = $payg->refund($params);
        //var_dump($pResult);
    }

    public function testCancel()
    {
        $payg = PayGateway::getIstance(PayGateway::CMPT1, true);
        $this->assertInstanceOf(
            \Payment\Gateway\Computop\Gateway::class,
            $payg
        );

        $params = [
            'terminalId' => null,
            'blowfishPassword' => null,
            'hMacPassword' => null,
            'payId' => '123123', // we retrieve it from them
            'paymentReference' => $this->paymentNumber,
            'orderReference' => $this->orderNumber,
            'amount' => 17,
            'currency' => null,
            'xId' => '',
            'action' => $payg::ACTION_REVERSE
        ];

        //get response from gateway
        //$pResult = $payg->cancel($params);
        //var_dump($pResult);
    }
}

