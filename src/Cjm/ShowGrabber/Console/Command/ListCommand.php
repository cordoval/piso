<?php

namespace Cjm\ShowGrabber\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class responsible for listing all configured shows
 */
class ListCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('No configured shows');
    }

}
