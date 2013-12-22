<?php

namespace spec\Piso\Shows\EpisodeIndex;

use PhpSpec\ObjectBehavior;
use Piso\Exception\ConfigException;
use Piso\Shows\ShowIndex;
use Prophecy\Argument;

use Piso\Shows\EpisodeIndex;

class FilesystemEpisodeIndexSpec extends ObjectBehavior
{
    function let(ShowIndex $showIndex)
    {
        $this->beConstructedWith($showIndex);
    }

    function it_is_an_episode_index()
    {
        $this->shouldHaveType(EpisodeIndex::class);
    }

    function it_throws_any_exceptions_thrown_by_show_index(ShowIndex $showIndex)
    {
        $exception = new ConfigException();
        $showIndex->getConfigForShow('foo')->willThrow($exception);

        $this->shouldThrow($exception)->duringGetEpisodesForShow('foo');
    }

}
