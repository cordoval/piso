<?php

namespace spec\Piso\Shows\ShowIndex;

use Piso\Exception\ConfigException;
use Piso\Shows\ShowIndex;
use Piso\Shows\ShowConfig;
use Piso\Util\YamlReader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YamlShowIndexSpec extends ObjectBehavior
{
    const EXAMPLE_PATH = '/foo/bar.yml';

    function let(YamlReader $parser)
    {
        $this->beConstructedWith($parser, self::EXAMPLE_PATH);
    }

    function it_is_a_show_lister()
    {
        $this->shouldHaveType(ShowIndex::class);
    }

    function it_reads_reads_the_specified_config_file_from_disk(YamlReader $parser)
    {
        $this->getNames();

        $parser->parseFile(self::EXAMPLE_PATH)->shouldHaveBeenCalled();
    }

    function it_returns_empty_array_if_no_shows_are_configured(YamlReader $parser)
    {
        $parser->parseFile(Argument::any())->willReturn([]);

        $names = $this->getNames();

        $names->shouldBeArray();
        $names->shouldHaveCount(0);
    }

    function it_returns_list_of_show_names_when_some_are_present(YamlReader $parser)
    {
        $config = [
            'shows' => [
                'show 1' => null,
                'show 2' => null
            ]
        ];
        $parser->parseFile(Argument::any())->willReturn($config);

        $names = $this->getNames();

        $names->shouldEqual(['show 1', 'show 2']);
    }

    function it_throws_a_configuration_exception_when_asked_about_an_unconfigured_show(YamlReader $parser)
    {
        $config = ['shows' => []];
        $parser->parseFile(Argument::any())->willReturn($config);

        $this->shouldThrow(ConfigException::class)->duringGetConfigForShow('someshow');
    }

    function it_returns_a_showconfig_when_asked_about_a_configured_Show(YamlReader $parser)
    {
        $config = [
            'shows' => [
                'show 1' => null
            ]
        ];
        $parser->parseFile(Argument::any())->willReturn($config);

        $result = $this->getConfigForShow('show 1');

        $result->shouldHaveType(ShowConfig::class);
    }
}
