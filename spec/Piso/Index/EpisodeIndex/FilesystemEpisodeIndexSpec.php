<?php

namespace spec\Piso\Index\EpisodeIndex;

use PhpSpec\ObjectBehavior;
use Piso\Config\ShowConfig;
use Piso\Config\ShowsConfig;
use Piso\Exception\ConfigException;
use Piso\Index\ShowsIndex;
use Prophecy\Argument;

use Piso\Index\EpisodeIndex;

class FilesystemEpisodeIndexSpec extends ObjectBehavior
{
    function let(ShowsConfig $showsConfig)
    {
        $this->beConstructedWith($showsConfig);
    }

    function it_is_an_episode_index()
    {
        $this->shouldHaveType(EpisodeIndex::class);
    }

    function it_gets_the_show_config_from_the_showsconfig_object(ShowsConfig $showsConfig)
    {
        $this->getEpisodesForShow('show');

        $showsConfig->getShowConfigFor('show')->shouldHaveBeenCalled();
    }

    function if_showconfig_throws_execption_getepisodes_will_pass_it_through(ShowsConfig $showsConfig)
    {
        $exception = new ConfigException;
        $showsConfig->getShowConfigFor(Argument::any())->willThrow($exception);

        $this->willThrow($exception)->duringGetEpisodesForShow('show');
    }
}
