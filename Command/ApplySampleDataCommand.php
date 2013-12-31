<?php

namespace Kutny\FixturesBundle\Command;

use Kutny\FixturesBundle\AppDataManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApplySampleDataCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('sample-data:apply')
			->setDescription('Apply all sample data');
	}

	/**
	 * @inheritdoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
        $appDataManagerServiceName = $this->getContainer()->getParameter('kutny_fixtures.appdata_manager_service_name');

        /** @var AppDataManager $appDataManager */
        $appDataManager = $this->getContainer()->get($appDataManagerServiceName);
        $appDataManager->applySampleData($output);
	}

}
