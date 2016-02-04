<?php

namespace tests\Action;

use stubs\Action\ActionStub;
use DeSmart\Adr\Responder\ResponderInterface;

class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_returns_responders_response()
    {
        $action = new ActionStub;
        $responder = $this->prophesize(ResponderInterface::class);
        $responder->respond()->willReturn($expectedResult = 'foo');

        $response = $action->callAction('executeWithResponder', [$responder->reveal()]);

        $this->assertEquals($expectedResult, $response);
    }

    /**
     * @test
     */
    public function it_returns_data_the_old_way()
    {
        $action = new ActionStub;

        $response = $action->callAction('executeTheOldWay', []);

        $this->assertEquals('bar', $response);
    }
}
