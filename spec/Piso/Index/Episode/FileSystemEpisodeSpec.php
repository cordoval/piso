<?php

namespace spec\Piso\Index\Episode;

use PhpSpec\ObjectBehavior;
use Piso\Index\Episode;
use Prophecy\Argument;

use SplFileInfo;

class FileSystemEpisodeSpec extends ObjectBehavior
{
    function let(SplFileInfo $file)
    {
        $this->beConstructedWith($file);
    }

    function it_is_an_episode()
    {
        $this->shouldHaveType(Episode::class);
    }

    function it_has_no_episode_number_if_the_filename_does_not_contain_it(SplFileInfo $file)
    {
        $file->getFilename()->willReturn('something with no numbers');

        $episode = $this->getNumber();

        $episode->shouldBe(null);
    }

    function it_gets_the_episode_number_from_sXXeXX_filenames(SplFileInfo $file)
    {
        $file->getFilename()->willReturn('blah blah blah ( \' s03E14 { ] // ');

        $episode = $this->getNumber();

        $episode->shouldBe(14);
    }

    function it_has_no_season_number_if_the_filename_does_not_contain_it(SplFileInfo $file)
    {
        $file->getFilename()->willReturn('something with no numbers');

        $season = $this->getNumber();

        $season->shouldBe(null);
    }

    function it_gets_the_season_number_from_sXXeXX_filenames(SplFileInfo $file)
    {
        $file->getFilename()->willReturn('blah blah blah ( \' s23E04 { ] // ');

        $season = $this->getSeason();

        $season->shouldBe(23);
    }
}
