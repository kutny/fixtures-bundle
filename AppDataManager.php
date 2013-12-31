<?php

namespace Kutny\FixturesBundle;

use Symfony\Component\Console\Output\OutputInterface;

class AppDataManager
{
    private $fixtureAppliers;
    private $sampleDataAppliers;

    /**
     * @param IFixturesApplier[] $fixtureAppliers
     * @param ISampleDataApplier[] $sampleDataAppliers
     */
    public function __construct(array $fixtureAppliers = array(), array $sampleDataAppliers = array()) {
        $this->fixtureAppliers = $fixtureAppliers;
        $this->sampleDataAppliers = $sampleDataAppliers;
    }

    public function applyFixtures(OutputInterface $output) {
        foreach ($this->fixtureAppliers as $fixtureApplier) {
            $fixtureApplier->apply($output);
        }
    }

    public function applySampleData(OutputInterface $output) {
        foreach ($this->sampleDataAppliers as $sampleDataApplier) {
            $sampleDataApplier->apply($output);
        }
    }

}
