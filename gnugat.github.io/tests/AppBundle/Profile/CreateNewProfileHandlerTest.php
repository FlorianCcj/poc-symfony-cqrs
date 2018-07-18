<?php
// File: tests/AppBundle/Profile/CreateNewProfileHandlerTest.php;

namespace tests\AppBundle\Profile;

use AppBundle\Profile\CreateNewProfile;
use AppBundle\Profile\CreateNewProfileHandler;
use AppBundle\Profile\Profile;
use AppBundle\Profile\Service\CheckProfileNameDuplicates;
use AppBundle\Profile\Service\SaveNewProfile;
use Prophecy\Argument;

class CreateNewProfileHandlerTest extends \PHPUnit_Framework_TestCase
{
    const NAME = 'Arthur Dent';

    private $checkProfileNameDuplicates;
    private $saveNewProfile;
    private $createNewProfileHandler;

    protected function setUp()
    {
        $this->checkProfileNameDuplicates = $this->prophesize(CheckProfileNameDuplicates::class);
        $this->saveNewProfile = $this->prophesize(SaveNewProfile::class);

        $this->createNewProfileHandler = new CreateNewProfileHandler(
            $this->checkProfileNameDuplicates->reveal(),
            $this->saveNewProfile->reveal()
        );
    }

    /**
     * @test
     */
    public function it_creates_new_profiles()
    {
        $createNewProfile = new CreateNewProfile(self::NAME);

        $this->checkProfileNameDuplicates->check(self::NAME)->willReturn(false);
        $this->saveNewProfile->save(Argument::type(Profile::class))->shouldBeCalled();

        self::assertType(
            Profile::class,
            $this->createNewProfileHandler->handle($createNewProfile)
        );
    }

    /**
     * @test
     */
    public function it_cannot_create_profiles_with_duplicated_name()
    {
        $createNewProfile = new CreateNewProfile(self::NAME);

        $this->checkProfileNameDuplicates->check(self::NAME)->willReturn(true);
        $this->saveNewProfile->save(Argument::type(Profile::class))->shouldNotBeCalled();

        $this->expectException(\DomainException::class);
        $this->createNewProfileHandler->handle($createNewProfile);
    }
}
