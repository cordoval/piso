<?php

namespace Piso\Console\Command;

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
            $this->outputShowDetails($output, $show);
        }
        catch(ConfigException $e) {
            $this->outputUnknownShowMessage($output, $show);
        }
    }

    /**
     * Fetch the episodes and output their details
     *
     * @param OutputInterface $output
     * @param $show
     */
    private function outputShowDetails(OutputInterface $output, $show)
    {
        if ($episodes = $this->episodeIndex->getEpisodesForShow($show)) {
            $this->outputEpisodeDetails($output, $episodes);
        } else {
            $this->outputNoEpisodesMessage($output);
        }
    }

    /**
     * Display the details of the found episodes
     *
     * @param OutputInterface $output
     * @param array $episodes
     */
    private function outputEpisodeDetails(OutputInterface $output, array $episodes)
    {
        foreach ($this->groupEpisodesBySeason($episodes) as $seasonNumber => $seasonEpisodes) {
            $this->outputSeasonDetails($output, $seasonEpisodes, $seasonNumber);
        }
    }

    /**
     * Groups an array of episodes by season
     *
     * @param array $episodes
     * @return array of key => array of episodes
     */
    private function groupEpisodesBySeason(array $episodes)
    {
        return array_reduce($episodes, function($result, $episode) {
            $result[$episode->getSeason()][] = $episode;
            return $result;
        });
    }

    /**
     * Output a line summarising the episodes in a season
     *
     * @param OutputInterface $output
     * @param array $seasonEpisodes
     * @param integer $seasonNumber
     */
    private function outputSeasonDetails(OutputInterface $output, $seasonEpisodes, $seasonNumber)
    {
        $episodeNumbers = $this->formatEpisodeNumbersString($seasonEpisodes);
        $episodeString = count($seasonEpisodes) > 1 ? 'Episodes' : 'Episode';
        $output->writeln(sprintf('Season %d: %s %s', $seasonNumber, $episodeString, $episodeNumbers));
    }

    /**
     * Gets the string of episode numbers, e.g. "1-3,5-6,8"
     *
     * @param array $seasonEpisodes List of episode numbers
     * @return string Formatted string
     */
    private function formatEpisodeNumbersString($seasonEpisodes)
    {
        $numberList = array_map(
            function ($episode) {
                return $episode->getNumber();
            },
            $seasonEpisodes
        );

        $episodeNumbers = join(',', $numberList);

        return $episodeNumbers;
    }

    /**
     * Display a message that no episodes were found
     *
     * @param OutputInterface $output
     */
    private function outputNoEpisodesMessage(OutputInterface $output)
    {
        $output->writeln('No episodes found');
    }

    /**
     * Display a message that the show was not recognised
     *
     * @param OutputInterface $output
     * @param $show
     */
    private function outputUnknownShowMessage(OutputInterface $output, $show)
    {
        $output->writeln(sprintf('Unknown show "%s"', $show));
    }

}
