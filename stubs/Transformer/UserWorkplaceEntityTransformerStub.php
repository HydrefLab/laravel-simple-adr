<?php

namespace stubs\Transformer;

use League\Fractal\TransformerAbstract;
use stubs\Entity\UserWorkplaceEntityStub;

class UserWorkplaceEntityTransformerStub extends TransformerAbstract
{
    /**
     * @param UserWorkplaceEntityStub $entity
     * @return array
     */
    public function transform(UserWorkplaceEntityStub $entity)
    {
        return [
            'name' => $entity->getName(),
        ];
    }
}
