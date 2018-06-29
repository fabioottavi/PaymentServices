<?php
final class PayGateway
{
    const IGFC = "IGFC";
    const CMPT1 = "CMPT1";
    const CMPT2 = "CMPT2";
    
    /**
     * Undocumented function
     *
     * @param Payment\Gateway\GatewayInterface $paymenttype
     * @return void
     */
    public static function getIstance($paymenttype, $debug)
    {
        $return =null;
        switch ($paymenttype) {
        case self::IGFC:
            $return = new \Payment\Gateway\Igfs\Gateway($debug);
            break;
        case self::CMPT1:
            $return = new \Payment\Gateway\Computo\Gateway();
            break;
        case self::CMPT2:
            break;
        default:
            break;
        }
        return $return;
    }

    

}