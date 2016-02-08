<?php

namespace Kutny\FixturesBundle\Command;

use Kutny\FixturesBundle\SampleData\SampleDataApplier;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SampleDataApplierCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('sample-data:apply');
        $this->setDescription('Apply all sample data');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
	{
        /** @var SampleDataApplier $sampleDataApplier */
        $sampleDataApplier = $this->getContainer()->get('kutny_fixtures.sample_data_applier.default');
        $sampleDataApplier->applySampleData();
    }
}
