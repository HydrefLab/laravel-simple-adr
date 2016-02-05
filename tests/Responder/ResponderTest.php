<?php

namespace tests\Responder;

use DeSmart\Adr\Fractal\Transformer;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use stubs\Entity\UserEntityStub;
use stubs\Responder\JsonResponderStub;
use stubs\Transformer\UserEntityTransformerStub;

class ResponderTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    protected $map = [
        \stubs\Entity\UserEntityStub::class => [
            'transformer' => UserEntityTransformerStub::class,
            'resource' => 'users'
        ]
    ];

    /** @test */
    public function it_should_generate_response()
    {
        $user = new UserEntityStub();
        $user->setName('John Doe');
        $user->setEmail('johndoe@example.com');

        $responder = new JsonResponderStub(new Request(), new Transformer(new Manager(), new Container(), $this->map));
        $responder->setUser($user);

        $response = $responder->respond();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArraySubset(['content-type' => ['application/json']], $response->headers->all());
        $this->assertEquals('{"data":{"name":"John Doe","email":"johndoe@example.com"}}', $response->getContent());
    }
}
