<?php
// File: src/AppBundle/Profile/CreateNewProfileHandler.php;
// Source: https://gnugat.github.io/2016/05/11/towards-cqrs-command-bus.html
// Phase: P1

namespace AppBundle\Profile;

use AppBundle\Profile\Service\CheckProfileNameDuplicates;
use AppBundle\Profile\Service\SaveNewProfile;

class CreateNewProfileHandler
{
    private $checkProfileNameDuplicates;
    private $saveNewProfile;

    public function __construct(
        CheckProfileNameDuplicates $checkProfileNameDuplicates,
        SaveNewProfile $saveNewProfile
    ) {
        $this->checkProfileNameDuplicates = $checkProfileNameDuplicates;
        $this->saveNewProfile = $saveNewProfile;
    }

    public function handle(CreateNewProfile $createNewProfile)
    {
        if (true !== $this->checkProfileNameDuplicates->check($createNewProfile->name)) {
            throw new \DomainException("Invalid \"name\" parameter: \"$name\" already exists and duplicates are not allowed");
        }
        $newProfile = new Profile($name); // Entity moved to Profile namespace
        $this->saveNewProfile->save($newProfile);

        return $newProfile;
    }
}