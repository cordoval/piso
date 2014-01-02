<?php

namespace spec\Piso\Console\Command;

use PhpSpec\ObjectBehavior;
use Piso\Console\Formatter\EpisodeListFormatter;
use Piso\Exception\ConfigException;
use Piso\Index\Episode;
use Piso\Index\EpisodeList;
use Piso\Index\EpisodeIndex;
use Prophecy\Argument;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListEpisodesCommandSpec extends ObjectBehavior
{
    const EXAMPLE_SHOW = 'someshow';

    function let(InputInterface $input, EpisodeIndex $episodeIndex, EpisodeList $episodes, EpisodeListFormatter $formatter)
    {
        $this->beConstructedWith('list-episodes', $episodeIndex, $formatter);

        $input->bind(Argument::any())->willReturn();
        $input->validate(Argument::any())->willReturn(true);
        $input->isInteractive(Argument::any())->willReturn(true);

        $input->getArgument('show')->willReturn(self::EXAMPLE_SHOW);

        $episodeIndex->getEpisodesForShow(Argument::any())->willReturn($episodes);
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType(Command::class);
    }

    function it_should_ask_the_episode_index_for_the_show_details(InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex)
    {
        $this->run($input, $output);

        $episodeIndex->getEpisodesForShow(self::EXAMPLE_SHOW)->shouldHaveBeenCalled();
    }

    function it_should_error_when_show_is_not_configured(InputInterface $input, OutputInterface $output, EpisodeIndex $episodeIndex, EpisodeList $episodes, EpisodeListFormatter $formatter)
    {
        $episodeIndex->getEpisodesForShow(Argument::any())->willThrow(new ConfigException);

        $this->run($input, $output);

        $formatter->unknownShow($output, self::EXAMPLE_SHOW)->shouldHaveBeenCalled();
    }

    function it_shows_appropriate_message_when_no_episodes_exist(InputInterface $input, OutputInterface $output, EpisodeListFormatter $formatter)
    {
        $this->run($input, $output);

        $formatter->noEpisodes($output, self::EXAMPLE_SHOW)->shouldHaveBeenCalled();
    }

    function it_should_output_episode_list_when_there_are_some_episodes(
        InputInterface $input, OutputInterface $output, Episode $episode, EpisodeList $episodes, EpisodeListFormatter $formatter)
    {
        $episodes->getEpisodes()->willReturn([$episode]);

        $this->run($input, $output);

        $formatter->episodeList($output, self::EXAMPLE_SHOW, $episodes)->shouldHaveBeenCalled();
    }
}
