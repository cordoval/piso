<?php

namespace spec\Cjm\ShowGrabber\Console\Command;

use Cjm\ShowGrabber\Shows\ShowLister;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, OutputInterface $output, ShowLister $lister)
    {
        $this->beConstructedWith('list-shows', $lister);
    }

    function it_is_a_console_command()
    {
        $this->shouldHaveType(Command::class);
    }

    function it_should_output_list_of_show_names(InputInterface $input, OutputInterface $output, ShowLister $lister)
    {
        $lister->getNames()->willReturn(['show 1', 'show 2']);

        $this->run($input, $output);

        $output->writeln('show 1')->shouldHaveBeenCalled();
        $output->writeln('show 2')->shouldHaveBeenCalled();
    }

    function it_outputs_suitable_message_when_no_shows_are_listed($input, $output, $lister)
    {
        $lister->getNames()->willReturn([]);

        $this->run($input, $output);

        $output->writeln("No configured shows")->shouldHaveBeenCalled();
    }
}
