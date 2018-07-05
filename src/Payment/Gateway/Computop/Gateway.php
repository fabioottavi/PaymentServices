<?php

namespace Payment\Gateway\Computop;

class Gateway implements \Payment\Gateway\GatewayInterface
{
    /**
     * 
     * @return object
     *
     * @throws \Exception
     */
    public function init(array $params = [])
    {
        $initObj = new Init\ComputopCgInit(); 

        

        $initObj->execute();
        return array(
            'id' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'redirectURL' => $initObj->redirectURL,
        );
    }
    public function verify(array $params = [])
    {
        $initObj = new Init\ComputopCgVerify(); 
        

        $initObj->execute();
        return array(
            'id' => $initObj->tid,
            'returnCode' => $initObj->rc,
            'error' => $initObj->errorDesc,
            'paymentID' => $initObj->paymentID,
            'redirectURL' => $initObj->redirectURL,
        );
    }
}