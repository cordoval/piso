<?php

namespace spec\Cjm\ShowGrabber\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('list-shows');
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    function it_outputs_suitable_message_when_no_shows_are_listed(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output);

        $output->writeln("No configured shows")->shouldHaveBeenCalled();
    }
}
