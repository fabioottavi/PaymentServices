<?php

namespace Payment\Gateway\Computo;

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