<?php

namespace Kutny\FixturesBundle\SampleData;

class SampleDataApplier
{
    private $sampleDataAppliers;

    /**
     * @param ISampleDataApplier[] $sampleDataAppliers
     */
    public function __construct(array $sampleDataAppliers = [])
    {
        $this->sampleDataAppliers = $sampleDataAppliers;
    }

    public function applySampleData()
    {
        foreach ($this->sampleDataAppliers as $sampleDataApplier) {
            $sampleDataApplier->apply();
        }
    }
}
