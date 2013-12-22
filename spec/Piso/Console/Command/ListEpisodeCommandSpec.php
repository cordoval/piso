<?php

namespace spec\Piso\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListEpisodeCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input)
    {
        $this->beConstructedWith('list-episodes');

        $input->bind(Argument::any())->willReturn();
        $input->validate(Argument::any())->willReturn(true);
        $input->isInteractive(Argument::any())->willReturn(true);
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType(Command::class);
    }

    function it_should_error_when_show_is_not_configured(InputInterface $input, OutputInterface $output)
    {
        $input->getArgument('show')->willReturn('unconfigured');

        $this->run($input, $output);

        $output->writeln('Unknown show "unconfigured"')->shouldHaveBeenCalled();
    }
}
