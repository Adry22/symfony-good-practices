<?php

declare(strict_types=1);

namespace User\Domain\Entity\User\UserId;

use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    /** @test */
    public function should_create_user_id_when_receive_a_valid_uuid_v4(): void
    {
        $id = UserId::fromString('de305d54-75b4-431b-adb2-eb6b9e546014');

        $this->assertSame('de305d54-75b4-431b-adb2-eb6b9e546014', $id->toString());
    }

    /**
     * @test
     * @dataProvider invalidUuidsV4Provider
     */
    public function should_throw_exception_when_create_from_not_valid_uuid_v4(string $uuid): void
    {
        $this->expectException(UserIdInvalidArgumentException::class);

        UserId::fromString($uuid);
    }

    /**
     * @return array<string, list<string>>
     */
    public static function invalidUuidsV4Provider(): array
    {
        return [
            'Empty' => [''],
            'Whitespace' => [' '],
            'Number' => ['1234'],
            'Random test' => ['dummy'],
            'Version 1' => ['dfff729e-393f-11ef-9454-0242ac120002'],
            'Version 2' => ['000003e8-a5d0-21f0-8200-325096b39f47'],
            'Version 3' => ['6ba7b810-9dad-31d1-80b4-00c04fd430c8'],
            'Version 5' => ['6ba7b810-9dad-51d1-80b4-00c04fd430c8'],
            'Version 6' => ['1f0a5d10-2c18-6430-9617-8d77b83dd18e'],
            'Version 7' => ['019078c6-1ef2-796d-a980-a6ea04fbcc61'],
            'Unknown version' => [ '550e8400-e29b-91d4-a716-446655440000'],
            'Nil UUID' => [ '00000000-0000-0000-0000-000000000000'],
            'Max UUID' => [ 'ffffffff-ffff-ffff-ffff-ffffffffffff'],
        ];
    }
}
