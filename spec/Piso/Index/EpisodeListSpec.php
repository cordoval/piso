<?php

namespace spec\Piso\Index;

use PhpSpec\ObjectBehavior;
use Piso\Index\Episode;
use Prophecy\Argument;
use IteratorAggregate;
use ArrayObject;

class EpisodeListSpec extends ObjectBehavior
{
    function let(Episode $episode)
    {
        $this->beConstructedWith([$episode]);
    }

    function it_iterates_array_of_episodes_it_is_constructed_with(Episode $episode)
    {
        $this->getEpisodes()->shouldEqual([$episode]);
    }
}
