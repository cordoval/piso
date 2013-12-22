<?php

namespace spec\Piso\Shows;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShowConfigSpec extends ObjectBehavior
{
    function it_contains_the_name_of_the_show()
    {
        $this->beConstructedWith('showname');

        $this->getName()->shouldReturn('showname');
    }
}
