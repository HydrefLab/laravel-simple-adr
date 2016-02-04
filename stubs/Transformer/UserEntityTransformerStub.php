<?php

namespace stubs\Transformer;

use League\Fractal\TransformerAbstract;
use stubs\Entity\UserEntityStub;

class UserEntityTransformerStub extends TransformerAbstract
{
    /** @var array */
    protected $availableIncludes = [
        'workplace'
    ];

    /**
     * @param UserEntityStub $entity
     * @return array
     */
    public function transform(UserEntityStub $entity)
    {
        return [
            'name' => $entity->getName(),
            'email' => $entity->getEmail(),
        ];
    }

    /**
     * @param UserEntityStub $entity
     * @return \League\Fractal\Resource\Item
     */
    public function includeWorkplace(UserEntityStub $entity)
    {
        return $this->item(
            $entity->getWorkplace(),
            new UserWorkplaceEntityTransformerStub(),
            'workplaces'
        );
    }
}
