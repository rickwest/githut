<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchUsernameModel
{
    /**
     * @var  string
     * @assert\NotBlank()
     */
    protected $username;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return SearchUsernameModel
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}