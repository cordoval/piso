<?php

namespace spec\Piso\Console\Command;

use PhpSpec\ObjectBehavior;
use Piso\Exception\ConfigException;
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
}
