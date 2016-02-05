<?php

namespace DeSmart\Adr\Responder;

use Illuminate\Http\Response;

interface ResponderInterface
{
    /**
     * @return Response
     */
    public function respond();
}
