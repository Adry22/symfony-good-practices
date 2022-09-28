<?php

namespace Tests\Common\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseWebTestCase extends WebTestCase
{
    protected ContainerInterface $testContainer;
    protected EntityManagerInterface $entityManager;

    /** @var ORMPurger|null */
    protected $purger;

    /** @var ORMExecutor|null */
    protected $executor;

    /** @var AbstractPlatform */
    protected $platform;

    /** @var Connection */
    protected $connection;

    public function setUp(): void
    {
        $this->testContainer = static::getContainer();
        $this->entityManager = $this->testContainer->get('doctrine')->getManager();
        $this->connection = $this->entityManager->getConnection();
        $this->platform = $this->connection->getDatabasePlatform();

        $this->configureORM();
        $this->purgeDataBase();
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
}
