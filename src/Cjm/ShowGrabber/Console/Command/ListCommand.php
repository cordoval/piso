<?php

namespace Cjm\ShowGrabber\Console\Command;

use Cjm\ShowGrabber\Shows\ShowLister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Cli Command responsible for listing all configured shows
 */
class ListCommand extends Command
{
    /**
     * Lister that actually gets the list of shows
     *
     * @var ShowLister
     */
    private $lister;

    /**
     * @param string|null $name The name of the command
     * @param ShowLister $lister Where to get the show names from
     */
    public function __construct($name = null, ShowLister $lister)
    {
        $this->lister  = $lister;
        parent::__construct($name);
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($showNames = $this->lister->getNames()) {
            $this->outputShowList($output, $showNames);
        }
        else {
            $this->outputNoShowsMessage($output);
        }
    }

    /**
     * Writes the list of shows to the output
     *
     * @param OutputInterface $output
     * @param $showNames array List of show names
     */
    private function outputShowList(OutputInterface $output, $showNames)
    {
        foreach ($showNames as $show) {
            $output->writeln($show);
        }
    }

    /**
     * Output the message when no shows are found
     *
     * @param OutputInterface $output
     */
    private function outputNoShowsMessage(OutputInterface $output)
    {
        $output->writeln('No configured shows');
    }

}
