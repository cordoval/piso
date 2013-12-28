<?php

namespace spec\Piso\Config\ShowConfig;

use PhpSpec\ObjectBehavior;

use Piso\Config\ShowConfig;

use Prophecy\Argument;

class YamlShowConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Show', '/path');
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

    function it_returns_the_base_path_concatenated_with_the_show_name()
    {
        $path = $this->getLibraryPath();

        $path->shouldBe('/path' . DIRECTORY_SEPARATOR . 'Show');
    }
}
