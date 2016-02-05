<?php

namespace stubs\Responder;

use DeSmart\Adr\Responder\GenericResponder;
use Illuminate\Http\Response;
use stubs\Entity\UserEntityStub;

class JsonResponderStub extends GenericResponder
{
    /**
     * @param UserEntityStub $user
     * @return void
     */
    public function setUser(UserEntityStub $user)
    {
        $this->item = $user;
    }

    /**
     * @return Response
     */
    protected function createResponse()
    {
        $content = $this->getResource()->toJson();
        $headers = ['Content-Type' => 'application/json'];

        return new Response($content, 200, $headers);
    }
}
