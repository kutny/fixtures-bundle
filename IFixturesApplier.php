<?php

namespace Kutny\FixturesBundle;

use Symfony\Component\Console\Output\OutputInterface;

interface IFixturesApplier
{
    public function apply(OutputInterface $output);
}
