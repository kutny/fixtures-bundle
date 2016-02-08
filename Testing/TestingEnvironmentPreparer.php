<?php

namespace Kutny\FixturesBundle\Testing;

use Doctrine\ORM\EntityManager;
use Kutny\FixturesBundle\Fixtures\FixturesApplier;
use Kutny\FixturesBundle\SampleData\SampleDataApplier;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

class TestingEnvironmentPreparer
{
    private $kernel;
    private $entityManager;
    private $fixturesApplier;

    public function __construct(
        KernelInterface $kernel,
        EntityManager $entityManager,
        FixturesApplier $fixturesApplier
    ) {
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
        $this->fixturesApplier = $fixturesApplier;
    }

    public function prepare(SampleDataApplier $sampleDataApplier)
    {
        $this->prepareFixturesOnly();

        $sampleDataApplier->applySampleData();

        $this->entityManager->clear();
    }

    public function prepareFixturesOnly()
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $options = array('command' => 'doctrine:database:drop', '--force' => true);
        $application->run(new ArrayInput($options));

        $options = array('command' => 'doctrine:database:create');
        $application->run(new ArrayInput($options));

        $options = array('command' => 'doctrine:schema:create');
        $application->run(new ArrayInput($options));

        $this->fixturesApplier->applyFixtures();
    }
}
