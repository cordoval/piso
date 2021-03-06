<?php

namespace spec\Piso\Console\Command;

use Piso\Index\ShowsIndex;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListShowsCommandSpec extends ObjectBehavior
{
    function let(ShowsIndex $lister)
    {
        $this->beConstructedWith('list-shows', $lister);
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType(Command::class);
    }

    function it_should_output_list_of_show_names(InputInterface $input, OutputInterface $output, ShowsIndex $lister)
    {
        $lister->getNames()->willReturn(['show 1', 'show 2']);

        $this->run($input, $output);

        $output->writeln('show 1')->shouldHaveBeenCalled();
        $output->writeln('show 2')->shouldHaveBeenCalled();
    }

    function it_outputs_suitable_message_when_no_shows_are_listed(InputInterface $input, OutputInterface $output, ShowsIndex $lister)
    {
        $lister->getNames()->willReturn([]);

        $this->run($input, $output);

        $output->writeln("No configured shows")->shouldHaveBeenCalled();
    }
}
