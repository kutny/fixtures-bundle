<?php

namespace Kutny\FixturesBundle\Fixtures;

class FixturesApplier
{
    private $fixtureAppliers;

    /**
     * @param IFixturesApplier[] $fixtureAppliers
     */
    public function __construct(array $fixtureAppliers = [])
    {
        $this->fixtureAppliers = $fixtureAppliers;
    }

    public function applyFixtures()
    {
        foreach ($this->fixtureAppliers as $fixtureApplier) {
            $fixtureApplier->apply();
        }
    }
}
