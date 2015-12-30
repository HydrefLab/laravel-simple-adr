<?php

namespace stubs\Action;

use Fojuth\Adr\Action\ReturnsResponderTrait;
use Fojuth\Adr\Responder\ResponderInterface;

class ActionStub
{
    use ReturnsResponderTrait;

    public function executeWithResponder(ResponderInterface $responder)
    {
        return $responder;
    }

    public function executeTheOldWay()
    {
        return 'bar';
    }
}
