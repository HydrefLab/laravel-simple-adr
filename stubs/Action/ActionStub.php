<?php

namespace stubs\Action;

use DeSmart\Adr\Action\ReturnsResponderTrait;
use DeSmart\Adr\Responder\ResponderInterface;

class ActionStub
{
    use ReturnsResponderTrait;

    /**
     * @param ResponderInterface $responder
     * @return ResponderInterface
     */
    public function executeWithResponder(ResponderInterface $responder)
    {
        return $responder;
    }

    /**
     * @return string
     */
    public function executeTheOldWay()
    {
        return 'bar';
    }
}
