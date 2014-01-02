<?php

namespace Piso\Console\Command;

use Piso\Console\Formatter\EpisodeListFormatter;
use Piso\Exception\ConfigException;
use Piso\Index\EpisodeIndex;
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
     * @var EpisodeIndex
     */
    private $episodeIndex;

    /**
     * @var EpisodeListFormatter
     */
    private $episodeListFormatter;

    /**
     * @param string $name
     * @param EpisodeIndex $episodeIndex
     * @param EpisodeListFormatter $formatter
     */
    public function __construct($name, EpisodeIndex $episodeIndex, EpisodeListFormatter $formatter)
    {
        $this->episodeIndex = $episodeIndex;
        $this->episodeListFormatter = $formatter;
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
            $episodes = $this->episodeIndex->getEpisodesForShow($show);
            if (count($episodes->getEpisodes()) > 0) {
                $this->episodeListFormatter->episodeList($output, $show, $episodes);
            } else {
                $this->episodeListFormatter->noEpisodes($output, $show);
            }
        }
        catch(ConfigException $e) {
            $this->episodeListFormatter->unknownShow($output, $show);
        }
    }
}
