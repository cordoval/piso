<?php

namespace spec\Piso\Config\ShowConfig;

use PhpSpec\ObjectBehavior;

use Piso\Config\ShowConfig;

use Prophecy\Argument;

class YamlShowConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Show');
    }

    function it_is_a_show_config()
    {
        $this->shouldHaveType(ShowConfig::class);
    }

    function it_is_constructed_with_its_name()
    {
        $name = $this->getName();

        $name->shouldBe('Show');
    }
}
