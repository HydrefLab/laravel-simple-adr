<?php

namespace stubs\Entity;

class UserEntityStub
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $email;

    /** @var UserWorkplaceEntityStub */
    protected $workplace;

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return UserWorkplaceEntityStub
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * @param UserWorkplaceEntityStub $workplace
     * @return void
     */
    public function setWorkplace($workplace)
    {
        $this->workplace = $workplace;
    }
}
