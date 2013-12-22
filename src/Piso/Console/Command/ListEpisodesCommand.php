<?php

namespace Piso\Console\Command;

use Piso\Exception\ConfigException;
use Piso\Shows\EpisodeIndex;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for listing the episodes of a certain show
 */
class ListEpisodesCommand extends Command
{
    private $episodeIndex;

    public function __construct($name, EpisodeIndex $episodeIndex)
    {
        $this->episodeIndex = $episodeIndex;
        parent::__construct($name);
    }

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

        try {
            $this->episodeIndex->getEpisodesForShow($show);
        }
        catch(ConfigException $e) {
            $output->writeln(sprintf('Unknown show "%s"', $show));
        }
    }
}
