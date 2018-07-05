<?php
namespace Payment\Gateway;

/**
 *
 * @author Sendabox
 */
interface GatewayInterface
{
    /**
     *
     * @return object
     *
     * @throws \Doctrine\Instantiator\Exception\ExceptionInterface
     */
    public function init(array $params);
    public function verify(array $params);
    public function confirm(array $params);
    public function refund(array $params);
}
