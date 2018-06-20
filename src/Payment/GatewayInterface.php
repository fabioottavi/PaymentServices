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
}
