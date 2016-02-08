<?php

namespace Kutny\FixturesBundle\Command;

use Kutny\FixturesBundle\Fixtures\FixturesApplier;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesApplierCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('fixtures:apply');
        $this->setDescription('Apply all fixtures');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
	{
        /** @var FixturesApplier $fixturesApplier */
        $fixturesApplier = $this->getContainer()->get('kutny_fixtures.fixtures_applier.default');
        $fixturesApplier->applyFixtures();
    }
}
