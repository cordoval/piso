<?php

namespace Piso\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for listing the episodes of a certain show
 */
class ListEpisodesCommand extends Command
{
    /**
     * Set up the arguments
     */
    protected function configure()
    {
        $this->addArgument('show', InputArgument::REQUIRED, 'The name of the show');
    }

    /**
     * Output the episodes of the specified show
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $show = $input->getArgument('show');
        $output->writeln(sprintf('Unknown show "%s"', $show));
    }
}
