<?php

namespace spec\Piso\Console\Command;

use PhpSpec\ObjectBehavior;
use Piso\Exception\ConfigException;
use Piso\Index\Episode;
use Piso\Index\EpisodeIndex;
use Prophecy\Argument;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListEpisodesCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, EpisodeIndex $episodeIndex)
    {
        $this->beConstructedWith('list-episodes', $episodeIndex);

        $input->bind(Argument::any())->willReturn();
        $input->validate(Argument::any())->willReturn(true);
        $input->isInteractive(Argument::any())->willReturn(true);

        $input->getArgument('show')->willReturn('someshow');
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType(Command::class);
    }

    function it_should_ask_the_episode_index_for_the_show_details(InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex)
    {
        $this->run($input, $output);

        $episodeIndex->getEpisodesForShow('someshow')->shouldHaveBeenCalled();
    }

    function it_should_error_when_show_is_not_configured(InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex)
    {
        $episodeIndex->getEpisodesForShow(Argument::any())->willThrow(new ConfigException);

        $this->run($input, $output);

        $output->writeln('Unknown show "someshow"')->shouldHaveBeenCalled();
    }

    function it_shows_appropriate_message_when_no_episodes_exist(InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex)
    {
        $episodeIndex->getEpisodesForShow(Argument::any())->willReturn([]);

        $this->run($input, $output);

        $output->writeln('No episodes found')->shouldHaveBeenCalled();
    }

    function it_should_output_episode_description_when_there_is_one(
        InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex, Episode $episode)
    {
        $episode->getSeason()->willReturn(3);
        $episode->getNumber()->willReturn(2);

        $episodeIndex->getEpisodesForShow(Argument::any())->willReturn([$episode]);

        $this->run($input, $output);

        $output->writeln('Season 3: Episode 2')->shouldHaveBeenCalled();
    }

    function it_should_output_one_line_per_season_when_episodes_are_found(
        InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex, Episode $episode, Episode $episode2)
    {
        $episode->getSeason()->willReturn(3);
        $episode->getNumber()->willReturn(2);

        $episode2->getSeason()->willReturn(4);
        $episode2->getNumber()->willReturn(3);

        $episodeIndex->getEpisodesForShow(Argument::any())->willReturn([$episode, $episode2]);

        $this->run($input, $output);

        $output->writeln('Season 3: Episode 2')->shouldHaveBeenCalled();
        $output->writeln('Season 4: Episode 3')->shouldHaveBeenCalled();
    }

    function it_should_output_episodes_from_the_same_season_in_one_line(
        InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex, Episode $episode, Episode $episode2)
    {
        $episode->getSeason()->willReturn(3);
        $episode->getNumber()->willReturn(2);

        $episode2->getSeason()->willReturn(3);
        $episode2->getNumber()->willReturn(4);

        $episodeIndex->getEpisodesForShow(Argument::any())->willReturn([$episode, $episode2]);

        $this->run($input, $output);

        $output->writeln('Season 3: Episodes 2,4')->shouldHaveBeenCalled();
    }
}
