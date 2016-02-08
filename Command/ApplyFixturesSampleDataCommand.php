<?php

namespace Kutny\FixturesBundle\Command;

use Doctrine\DBAL\Connection;
use Kutny\FixturesBundle\AppDataManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ApplyFixturesSampleDataCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('fsd:apply');
        $this->setDescription('Apply fixtures and sample data');
        $this->addOption('no-backup', null, InputOption::VALUE_NONE, 'Set this parameter if you don\'t wanna backup');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $doctrineConnectionServiceName = $this->getContainer()->getParameter('kutny_fixtures.doctrine_connection_service_name');

        /** @var Connection $connection */
        $connection = $this->getContainer()->get($doctrineConnectionServiceName);

        if ($input->getOption('no-backup')) {
            $command = $this->getApplication()->find('doctrine:schema:drop');
            $command->run(new ArrayInput(array('command' => $command->getName(), '--force' => true)), $output);
        }
        else {
            $databaseName = $connection->getDatabase();
            $newDatabaseName = $connection->getDatabase() . '_' .date('Ymdhis');

            $output->writeln('Backing up database...');
            $this->backupDatabase($connection, $newDatabaseName, $databaseName);
            $output->writeln('Database backup created. (' . $newDatabaseName . ')');
        }

        $command = $this->getApplication()->find('doctrine:schema:create');
        $command->run(new ArrayInput(array('command' => $command->getName())), $output);

        $appDataManagerServiceName = $this->getContainer()->getParameter('kutny_fixtures.appdata_manager_service_name');

        /** @var AppDataManager $appDataManager */
        $appDataManager = $this->getContainer()->get($appDataManagerServiceName);
        $appDataManager->applyFixtures($output);
        $appDataManager->applySampleData($output);
    }

    private function backupDatabase(Connection $connection, $newDatabaseName, $databaseName)
	{
        $connection->exec('CREATE DATABASE `' . $newDatabaseName . '` COLLATE `utf8_general_ci`');

        $statement = 'SELECT ' .
            'concat("RENAME TABLE `' . $databaseName . '`.", table_name," TO `' . $newDatabaseName . '`.", table_name, ";") as query ' .
            'FROM information_schema.TABLES WHERE table_schema= "' . $databaseName . '"';

        $renameTableSql = $connection->fetchAll($statement);

        foreach ($renameTableSql as $sql) {
            $connection->exec($sql['query']);
        }
    }
}
