<?php

namespace spec\Piso\Console\Formatter\EpisodeListFormatter;

use PhpSpec\ObjectBehavior;
use Piso\Console\Formatter\EpisodeListFormatter;
use Piso\Index\Episode;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;

class SimpleSpec extends ObjectBehavior
{
    function it_is_an_episode_lister()
    {
        $this->shouldHaveType(EpisodeListFormatter::class);
    }

    function it_outputs_show_not_configured_message(OutputInterface $output)
    {
        $this->unknownShow($output, 'someshow');

        $output->writeln('Unknown show "someshow"')->shouldHaveBeenCalled();
    }

    function it_outputs_a_no_episodes_message(OutputInterface $output)
    {
        $this->noEpisodes($output, 'someshow');

        $output->writeln('No episodes found')->shouldHaveBeenCalled();
    }

    function it_outputs_the_season_and_episode_number_for_one_episode(OutputInterface $output, Episode $episode)
    {
        $episode->getSeason()->willReturn(1);
        $episode->getNumber()->willReturn(2);

        $this->episodeList($output, 'someshow', [$episode]);

        $output->writeln('Season 1: Episode 2')->shouldHaveBeenCalled();
    }

    function it_outputs_multiple_rows_for_different_seasons(OutputInterface $output, Episode $episode, Episode $episode2)
    {
        $episode->getSeason()->willReturn(1);
        $episode->getNumber()->willReturn(2);

        $episode2->getSeason()->willReturn(2);
        $episode2->getNumber()->willReturn(3);

        $this->episodeList($output, 'someshow', [$episode, $episode2]);

        $output->writeln('Season 1: Episode 2')->shouldHaveBeenCalled();
        $output->writeln('Season 2: Episode 3')->shouldHaveBeenCalled();
    }

    function it_comma_separates_nonadjacent_episodes_inside_the_same_season(OutputInterface $output, Episode $episode, Episode $episode2)
    {
        $episode->getSeason()->willReturn(1);
        $episode->getNumber()->willReturn(2);

        $episode2->getSeason()->willReturn(1);
        $episode2->getNumber()->willReturn(5);

        $this->episodeList($output, 'someshow', [$episode, $episode2]);

        $output->writeln('Season 1: Episodes 2,5')->shouldHaveBeenCalled();
    }

}
