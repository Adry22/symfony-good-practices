<?php
declare(strict_types=1);

namespace Tests\Universe\Planet\UseCase;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tests\Common\Builder\Planet\PlanetBuilder;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Exception;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Planet\UseCase\ListPlanetsUseCase;

class ListPlanetUseCaseTest extends WebTestCase
{

    protected ContainerInterface $testContainer;
    protected EntityManagerInterface $entityManager;

    private PlanetBuilder $planetBuilder;
    private PlanetRepository $planetRepository;
    private ListPlanetsUseCase $listPlanetsUseCase;

    /** @var ORMPurger|null */
    protected $purger;

    /** @var ORMExecutor|null */
    protected $executor;

    /** @var AbstractPlatform */
    protected $platform;

    /** @var Connection */
    protected $connection;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function setUp(): void
    {
        $this->testContainer = static::getContainer();
        $this->entityManager = $this->testContainer->get('doctrine')->getManager();
        $this->connection = $this->entityManager->getConnection();
        $this->platform = $this->connection->getDatabasePlatform();

        $this->configureORM();
        $this->purgeDataBase();

        $this->planetBuilder = new PlanetBuilder($this->entityManager);

        $this->planetRepository = $this->testContainer->get(PlanetRepository::class);

        $this->listPlanetsUseCase = new ListPlanetsUseCase($this->planetRepository);
    }

    protected function configureORM()
    {
        $this->purger = new ORMPurger($this->entityManager);
        $this->purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $this->executor = new ORMExecutor($this->entityManager, $this->purger);
    }

    public function purgeDataBase()
    {
        $this->connection->setAutoCommit(false);
        $this->disableForeignKeys();

        $this->executor->execute([]);

        $this->enableForeingKeys();
    }

    private function disableForeignKeys()
    {
        if ($this->platform instanceof MySqlPlatform) {
            $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0;');
        }
    }

    private function enableForeingKeys()
    {
        if ($this->platform instanceof MySqlPlatform) {
            $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }

    /** @test
     * @throws Exception
     */
    public function should_fail_when_no_planets_found(): void
    {
        $this->expectException(PlanetsNotFoundException::class);

        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->listPlanetsUseCase->handle('Jupiter');
    }

    /** @test */
    public function should_return_all_planets_when_no_filter(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->reset()
            ->withName('Earth')
            ->build();

        $planets = $this->listPlanetsUseCase->handle();

        $this->assertEquals('Mars', $planets[0]);
        $this->assertEquals('Earth', $planets[1]);
    }

    /** @test */
    public function should_return_planet_filtered(): void
    {
        $this->planetBuilder
            ->withName('Mars')
            ->build();

        $this->planetBuilder
            ->reset()
            ->withName('Earth')
            ->build();

        $planets = $this->listPlanetsUseCase->handle('Earth');

        $this->assertCount(1, $planets);
        $this->assertEquals('Earth', $planets[0]);
    }
}