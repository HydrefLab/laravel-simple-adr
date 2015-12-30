<?php

namespace Fojuth\Adr\Action;

use Fojuth\Adr\Responder\ResponderInterface;

/**
 * If the action (controller) returns an instance of ResponderInterface
 * return the response generated by it.
 */
trait ReturnsResponderTrait
{
    public function callAction($method, $parameters)
    {
        $response = call_user_func_array([$this, $method], $parameters);

        if (true === $response instanceof ResponderInterface) {
            return $response->respond();
        }

        return $response;
    }
}