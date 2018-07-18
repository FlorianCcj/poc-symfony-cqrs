<?php
// File: src/AppBundle/Profile/CreateNewProfile.php;
// Source: https://gnugat.github.io/2016/05/11/towards-cqrs-command-bus.html
// Phase: P1

namespace AppBundle\Profile;

class CreateNewProfile
{
    public $name;

    public function __construct($name)
    {
        if (null === $name) {
            throw new \DomainException('Missing required "name" parameter');
        }
        $this->name = (string) $name;
    }
}
