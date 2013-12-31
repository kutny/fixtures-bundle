<?php

namespace Kutny\FixturesBundle;

use Symfony\Component\Console\Output\OutputInterface;

interface ISampleDataApplier
{

    public function apply(OutputInterface $output);

}
