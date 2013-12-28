<?php

namespace spec\Piso\Config\ShowsConfig;

use PhpSpec\ObjectBehavior;

use Piso\Config\ShowConfig\YamlShowConfig;
use Piso\Config\ShowsConfig;
use Piso\Config\ShowConfig;
use Piso\Exception\ConfigException;
use Piso\Util\YamlReader;

use Prophecy\Argument;

class YamlShowsConfigSpec extends ObjectBehavior
{
    function let(YamlReader $reader)
    {
        $this->beConstructedWith($reader);
    }

    function it_is_a_shows_config()
    {
        $this->shouldHaveType(ShowsConfig::class);
    }

    function it_should_read_the_yaml_file(YamlReader $reader)
    {
        $this->getShowConfigs();

        $reader->parseFile()->shouldHaveBeenCalled();
    }

    function it_should_return_an_empty_array_of_show_configs_when_the_config_file_is_empty(YamlReader $reader)
    {
        $reader->parseFile()->willReturn([]);

        $configs = $this->getShowConfigs();

        $configs->shouldBe([]);
    }

    function it_should_return_an_empty_array_of_show_configs_when_the_config_node_is_present_but_empty(YamlReader $reader)
    {
        $reader->parseFile()->willReturn(['shows' => []]);

        $configs = $this->getShowConfigs();

        $configs->shouldBe([]);
    }

    function it_should_throw_an_error_when_the_config_files_shows_node_contains_a_scalar(YamlReader $reader)
    {
        $reader->parseFile()->willReturn(['shows' => 'show']);

        $this->shouldThrow(ConfigException::class)->duringGetShowConfigs();
    }

    function it_should_return_two_showconfigs_when_the_config_file_contains_two_Shows(YamlReader $reader)
    {
        $reader->parseFile()->willReturn([
            'shows' => [
                'show 1' => [],
                'show 2' => []
            ]
        ]);

        $showConfigs = $this->getShowConfigs();

        $showConfigs->shouldHaveCount(2);
        $showConfigs[0]->shouldHaveType(YamlShowConfig::class);
        $showConfigs[1]->shouldHaveType(YamlShowConfig::class);
    }

    function it_should_give_the_show_a_base_library_path(YamlReader $reader)
    {
        $reader->parseFile()->willReturn([
            'shows' => [
                'show 1' => []
            ],
            'library' => [
                'path' => '/path'
            ]
        ]);

        $showConfigs = $this->getShowConfigs();

        $showConfigs[0]->getLibraryPath()->shouldReturn('/path' . DIRECTORY_SEPARATOR . 'show 1');
    }

    function it_should_throw_a_config_exception_if_asked_for_the_config_of_an_unconfigured_show(YamlReader $reader)
    {
        $reader->parseFile()->willReturn([
                'shows' => [
                ]
            ]);

        $this->shouldThrow(new ConfigException('Show "show 3" not configured'))->duringGetShowConfigFor('show 3');
    }

    function it_should_return_a_config_object_if_asked_for_the_config_of_a_configured_show(YamlReader $reader)
    {
        $reader->parseFile()->willReturn([
                'shows' => [
                    'show 1' => []
                ]
            ]);

        $config = $this->getShowConfigFor('show 1');

        $config->shouldHaveType(ShowConfig::class);
    }
}
