<?php

namespace DeSmart\Adr\Responder;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DeSmart\Adr\Fractal\Transformer;

class GenericResponder implements ResponderInterface
{
    /** @var Request */
    protected $request;

    /** @var int */
    protected $statusCode = 200;

    /** @var Transformer */
    protected $transformer;

    /** @var object */
    protected $item;

    /** @var object[] */
    protected $collection;

    /**
     * @param Request $request
     * @param Transformer $transformer
     */
    public function __construct(Request $request, Transformer $transformer)
    {
        $this->request = $request;
        $this->transformer = $transformer;
    }

    /**
     * @return Response
     */
    public function respond()
    {
        return $this->createResponse();
    }

    /**
     * @return Response
     */
    protected function createResponse()
    {
        return new Response();
    }

    /**
     * @return \League\Fractal\Scope
     */
    protected function getResource()
    {
        if (null !== $this->item) {
            return $this->transformer->transformItem($this->item);
        } else if (null !== $this->collection && false === empty($this->collection)) {
            return $this->transformer->transformCollection($this->collection);
        }

        return $this->transformer->transformNull();
    }
}
