<?php
final class PayGateway
{
    const IGFC = 'IGFC';
    const CMPT1 = 'CMPT1';
    const CMPT2 = 'CMPT2';
    
    const CHECK_OUT_NORMAL = 'CHECK OUT NORMAL'; //checkout BNLP
    const CHECK_OUT_SYNTHESIS = 'CHECK OUT SYNTHESIS'; // checkout BNLP with web synthesis store
    const CHECK_OUT_SELECT = 'CHECK OUT SELECT'; //checkout BNLP with selection of payment instrument on the web store

    const TRANSACTION_TYPE_PURCHASE = 'PURCHASE';
    const TRANSACTION_TYPE_AUTH = 'AUTH';
    const TRANSACTION_TYPE_VERIFY = 'VERIFY';

    /**
     * Undocumented function
     *
     * @param Payment\Gateway\GatewayInterface $paymenttype
     * @return void
     */
    public static function getIstance($paymenttype, $test)
    {
        $return =null;
        switch ($paymenttype) {
        case self::IGFC:
            $return = new \Payment\Gateway\Igfs\Gateway($test);
            break;
        case self::CMPT1:
            $return = new \Payment\Gateway\Computop\Gateway($test);
            break;
        case self::CMPT2:
            break;
        default:
            break;
        }
        return $return;
    }
}