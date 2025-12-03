<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Builder\User\UserProfileBuilder;
use Tests\Common\Controller\BaseWebApiTestCase;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Repository\UserRepositoryInterface;

class UpdateProfileUserControllerTest extends BaseWebApiTestCase
{
    private const URL = '/user/{uuid}/update-profile';

    private UserRepositoryInterface $userRepository;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepositoryInterface::class);
        $this->userBuilder = new UserBuilder();
        $this->userProfileBuilder = new UserProfileBuilder();
    }

    /** @test */
    public function should_exists_url(): void
    {
        $response = $this->postRequestJson($this->generateUrl(UserId::random()->toString()));

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function should_fail_when_user_not_found(): void
    {
        $user = $this->userBuilder
            ->withId(UserId::random())
            ->withEmail('email@test.com')
            ->withPassword('password')
            ->build();

        $this->loginUser($user);
        $response = $this->postRequestJson($this->generateUrl(UserId::random()->toString()));

        $response = json_decode($response->getContent(), true);

        $this->assertEquals(400, $response['code']);
        $this->assertEquals('User not found', $response['message']);
        $this->assertEquals('UserNotFoundException', $response['type']);
    }

    /** @test */
    public function should_update_user_profile_when_everything_is_correct(): void
    {
        $userProfile = $this->userProfileBuilder
            ->withAddress(new Address('Old Street', '456', 'Barcelona', 'Old Country'))
            ->withName('Old name')
            ->build();

        $user = $this->userBuilder
            ->withId(UserId::random())
            ->withEmail('email@test.com')
            ->withPassword('password')
            ->withProfile($userProfile)
            ->build();

        $this->userRepository->save($user);
        $this->userRepository->flush();

        $parameters = [
            'street' => 'Street',
            'number' => '2',
            'city' => 'Madrid',
            'country' => 'Spain',
            'name' => 'New Name',
        ];

        $this->loginUser($user);
        $this->postRequestJson($this->generateUrl($user->id()->toString()), $parameters);

        $users = $this->userRepository->findAll();

        $this->assertSame('Street 2, Madrid, Spain', $users[0]->profile()->address()->toString());
        $this->assertSame('New Name', $users[0]->profile()->name());
    }

    private function generateUrl(string $uuid): string
    {
        return str_replace('{uuid}', $uuid, self::URL);
    }
}
