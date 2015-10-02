<?php
namespace TYPO3\TYPO3CR\Tests\Functional\Migration\Domain\Repository;

/*
 * This file is part of the TYPO3.TYPO3CR package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Tests\FunctionalTestCase;
use TYPO3\TYPO3CR\Migration\Domain\Model\MigrationStatus;
use TYPO3\TYPO3CR\Migration\Domain\Repository\MigrationStatusRepository;

/**
 */
class MigrationStatusRepositoryTest extends FunctionalTestCase
{
    /**
     * @var boolean
     */
    protected static $testablePersistenceEnabled = true;

    /**
     * @var MigrationStatusRepository
     */
    protected $repository;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->objectManager->get('TYPO3\TYPO3CR\Migration\Domain\Repository\MigrationStatusRepository');
    }

    /**
     * @test
     */
    public function findAllReturnsResultsInAscendingVersionOrder()
    {
        $this->repository->add(new MigrationStatus('zyx', 'direction', new \DateTime()));
        $this->repository->add(new MigrationStatus('abc', 'direction', new \DateTime()));
        $this->repository->add(new MigrationStatus('mnk', 'direction', new \DateTime()));

        $this->persistenceManager->persistAll();
        $this->persistenceManager->clearState();

        $expectedVersionOrder = array('abc', 'mnk', 'zyx');

        /** @var MigrationStatus $status */
        $i = 0;
        foreach ($this->repository->findAll() as $status) {
            $this->assertEquals($expectedVersionOrder[$i], $status->getVersion());
            $i++;
        }
    }
}
