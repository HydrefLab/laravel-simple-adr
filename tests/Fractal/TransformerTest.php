<?php

namespace tests\Fractal;

use DeSmart\Adr\Fractal\Transformer;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use stubs\Entity\UserEntityStub;
use stubs\Entity\UserWorkplaceEntityStub;
use stubs\Transformer\UserEntityTransformerStub;

class TransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Manager */
    protected $manager;

    /** @var Transformer */
    protected $transformer;

    /** @var array */
    protected $map = [
        \stubs\Entity\UserEntityStub::class => [
            'transformer' => UserEntityTransformerStub::class,
            'resource' => 'users'
        ]
    ];

    public function setUp()
    {
        $this->manager = new Manager();
        $this->transformer = new Transformer($this->manager, new Container(), $this->map);
    }

    /** @test */
    public function it_should_transform_null()
    {
        $this->transformer->setSerializer(new JsonApiSerializer()); // Other serializers don't handle null resource yet
        $scope = $this->transformer->transformNull();

        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            ['data' => null],
            $scope->toArray()
        );
    }

    /** @test */
    public function it_should_transform_item()
    {
        $user = new UserEntityStub();
        $user->setName('John Doe');
        $user->setEmail('johndoe@example.com');

        $scope = $this->transformer->transformItem($user);
        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            [
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'johndoe@example.com'
                ]
            ],
            $scope->toArray()
        );
    }

    /** @test */
    public function it_should_transform_collection()
    {
        $userOne = new UserEntityStub();
        $userOne->setName('John Doe');
        $userOne->setEmail('johndoe@example.com');

        $userTwo = new UserEntityStub();
        $userTwo->setName('Jane Doe');
        $userTwo->setEmail('janedoe@example.com');

        $scope = $this->transformer->transformCollection([$userOne, $userTwo]);
        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            [
                'data' => [
                    [
                        'name' => 'John Doe',
                        'email' => 'johndoe@example.com'
                    ],
                    [
                        'name' => 'Jane Doe',
                        'email' => 'janedoe@example.com'
                    ]
                ]
            ],
            $scope->toArray()
        );
    }

    /** @test */
    public function it_should_transform_collection_with_paginator()
    {
        $userOne = new UserEntityStub();
        $userOne->setName('John Doe');
        $userOne->setEmail('johndoe@example.com');

        $userTwo = new UserEntityStub();
        $userTwo->setName('Jane Doe');
        $userTwo->setEmail('janedoe@example.com');

        $this->transformer->setPaginator(new LengthAwarePaginator([$userOne, $userTwo], 2, 10));

        $scope = $this->transformer->transformCollection([$userOne, $userTwo]);
        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            [
                'data' => [
                    [
                        'name' => 'John Doe',
                        'email' => 'johndoe@example.com'
                    ],
                    [
                        'name' => 'Jane Doe',
                        'email' => 'janedoe@example.com'
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 2,
                        'per_page' => 10,
                        'current_page' => 1,
                        'total_pages' => 1,
                        'links' => []
                    ]
                ]
            ],
            $scope->toArray()
        );
    }

    /** @test */
    public function it_should_transform_item_with_includes()
    {
        $this->manager->parseIncludes('workplace');

        $userWorkplace = new UserWorkplaceEntityStub();
        $userWorkplace->setName('Doe\'s Constructions');

        $user = new UserEntityStub();
        $user->setName('John Doe');
        $user->setEmail('johndoe@example.com');
        $user->setWorkplace($userWorkplace);

        $scope = $this->transformer->transformItem($user);
        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            [
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'johndoe@example.com',
                    'workplace' => [
                        'data' => [
                            'name' => 'Doe\'s Constructions'
                        ]
                    ]
                ]
            ],
            $scope->toArray()
        );
    }

    /** @test */
    public function it_should_transform_item_without_includes()
    {
        $userWorkplace = new UserWorkplaceEntityStub();
        $userWorkplace->setName('Doe\'s Constructions');

        $user = new UserEntityStub();
        $user->setName('John Doe');
        $user->setEmail('johndoe@example.com');
        $user->setWorkplace($userWorkplace);

        $scope = $this->transformer->transformItem($user);
        $this->assertInstanceOf(\League\Fractal\Scope::class, $scope);
        $this->assertEquals(
            [
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'johndoe@example.com'
                ]
            ],
            $scope->toArray()
        );
    }
}
