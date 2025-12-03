<?php

declare(strict_types=1);

namespace Tests\Common\Builder;

use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Tests\Common\Builder\User\UserProfileBuilder;

final class BuilderFactory
{
    public function user(): UserBuilder
    {
        return new UserBuilder();
    }

    public function planet(): PlanetBuilder
    {
        return new PlanetBuilder();
    }

    public function userProfile(): UserProfileBuilder
    {
        return new UserProfileBuilder();
    }
}
