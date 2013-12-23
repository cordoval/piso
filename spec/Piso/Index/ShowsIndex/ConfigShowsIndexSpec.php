<?php

namespace spec\Piso\Index\ShowsIndex;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Piso\Config\ShowsConfig;
use Piso\Config\ShowConfig;
use Piso\Index\ShowsIndex;

class ConfigShowsIndexSpec extends ObjectBehavior
{
    function let(ShowsConfig $showsConfig, ShowConfig $config1, ShowConfig $config2)
    {
        $config1->getName()->willReturn('show 1');
        $config2->getName()->willReturn('show 2');

        $showsConfig->getShowConfigs()->willReturn([$config1, $config2]);

        $this->beConstructedWith($showsConfig);
    }

    function it_is_a_shows_index()
    {
        $this->shouldHaveType(ShowsIndex::class);
    }

    function it_should_get_the_show_configs_from_the_showsconfig(ShowsConfig $showsConfig)
    {
        $this->getNames();

        $showsConfig->getShowConfigs()->shouldHaveBeenCalled();
    }

    function it_should_return_the_list_of_names_from_the_showconfigs(ShowsConfig $showsConfig)
    {
        $names = $this->getNames();

        $names->shouldEqual(['show 1', 'show 2']);
    }
}
