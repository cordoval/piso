<?php

namespace Piso\Console\Formatter\EpisodeListFormatter;

use Piso\Console\Formatter\EpisodeListFormatter;

use Piso\Index\EpisodeList;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Basic episode lister
 */
class Simple implements EpisodeListFormatter
{
    /**
     * Message for when a show is not configured
     *
     * @param OutputInterface $output
     * @param string $show
     */
    public function unknownShow(OutputInterface $output, $show)
    {
        $output->writeln(sprintf('Unknown show "%s"', $show));
    }

    /**
     * Message when no episodes exist for a show
     *
     * @param OutputInterface $output
     * @param string $show
     */
    public function noEpisodes(OutputInterface $output, $show)
    {
        $output->writeln('No episodes found');
    }

    /**
     * Outputs a list of episode objects
     *
     * @param OutputInterface $output
     * @param string $show
     * @param EpisodeList $episodes Episode objects
     */
    public function episodeList(OutputInterface $output, $show, EpisodeList $episodes)
    {
        $seasons = $this->getEpisodeNumbersBySeason($episodes->getEpisodes());
        foreach ($seasons as $season => $episodeNumbers) {
            $episodeList = join(',', $episodeNumbers);
            $output->writeln(sprintf('Season %d: Episode%s %s', $season, count($episodeNumbers)>1?'s':'', $episodeList));
        }
    }

    /**
     * Goes from an array of episodes to a list of episode numbers per season
     *
     * @param array $episodes
     * @return array
     */
    private function getEpisodeNumbersBySeason(array $episodes)
    {
        return array_reduce($episodes, function($seasons, $episode){
            $seasons[$episode->getSeason()][] = $episode->getNumber();
            return $seasons;
        }, []);
    }

}
