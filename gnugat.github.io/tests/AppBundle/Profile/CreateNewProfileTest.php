<?php
// File: tests/AppBundle/Profile/CreateNewProfileTest.php;

namespace tests\AppBundle\Profile;

use AppBundle\Profile\CreateNewProfile;

class CreateNewProfileTest extends \PHPUnit_Framework_TestCase
{
    const NAME = 'Arthur Dent';

    /**
     * @test
     */
    public function it_has_a_name()
    {
        $createNewProfile = new CreateNewProfile(self::NAME);

        self::assertSame(self::NAME, $createNewProfile->name);
    }

    /**
     * @test
     */
    public function it_cannot_miss_a_name()
    {
        $this->expectException(\DomainException::class);
        $createNewProfile = new CreateNewProfile(null);
    }
}
