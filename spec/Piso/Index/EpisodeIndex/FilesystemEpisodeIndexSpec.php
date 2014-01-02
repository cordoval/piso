<?php

namespace spec\Piso\Index\EpisodeIndex;

use PhpSpec\ObjectBehavior;
use Piso\Config\ShowConfig;
use Piso\Config\ShowsConfig;
use Piso\Exception\ConfigException;
use Piso\Index\Episode;
use Piso\Index\EpisodeList;
use Piso\Index\ShowsIndex;
use Piso\Util\FileLister;
use Prophecy\Argument;

use Piso\Index\EpisodeIndex;

use SplFileInfo;

class FilesystemEpisodeIndexSpec extends ObjectBehavior
{
    function let(ShowsConfig $showsConfig, ShowConfig $showConfig, FileLister $lister)
    {
        $this->beConstructedWith($showsConfig, $lister);


        $showsConfig->getShowConfigFor(Argument::any())->willReturn($showConfig);

        $lister->getFilesInLocation(Argument::any())->willReturn([]);
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

    function it_passes_through_exceptions_from_the_showconfig(ShowsConfig $showsConfig)
    {
        $exception = new ConfigException;
        $showsConfig->getShowConfigFor(Argument::any())->willThrow($exception);

        $this->shouldThrow($exception)->duringGetEpisodesForShow('show');
    }

    function it_gets_library_location_from_show_config(ShowConfig $showConfig)
    {
        $this->getEpisodesForShow('show');

        $showConfig->getLibraryPath()->shouldHaveBeenCalled();
    }

    function it_returns_empty_list_of_episodes_when_the_show_has_no_library_location(ShowConfig $showConfig)
    {
        $showConfig->getLibraryPath()->willReturn(false);

        $episodes = $this->getEpisodesForShow('show');

        $episodes->shouldHaveType(EpisodeList::class);
        $episodes->getEpisodes()->shouldEqual([]);
    }

    function it_lists_the_files_in_the_library_location(ShowConfig $showConfig, FileLister $lister)
    {
        $showConfig->getLibraryPath()->willReturn('/path/to/library');

        $this->getEpisodesForShow('show');

        $lister->getFilesInLocation('/path/to/library')->shouldHaveBeenCalled();
    }

    function it_returns_empty_list_of_episodes_if_there_are_no_files(ShowConfig $showConfig, FileLister $lister)
    {
        $showConfig->getLibraryPath()->willReturn('/path/to/library');

        $episodes = $this->getEpisodesForShow('show');

        $episodes->shouldHaveType(EpisodeList::class);
        $episodes->getEpisodes()->shouldEqual([]);
    }

    function it_returns_one_episode_if_one_file_is_present(ShowConfig $showConfig, FileLister $lister, SplFileInfo $file)
    {
        $showConfig->getLibraryPath()->willReturn('/path/to/library');
        $lister->getFilesInLocation(Argument::any())->willReturn([$file]);
        $file->getFilename()->willReturn('STUFFs03e04STUFF');

        $episodes = $this->getEpisodesForShow('show');

        $episodes->getEpisodes()->shouldHaveCount(1);
        $episodes->getEpisodes()[0]->shouldHaveType(Episode::class);
    }
}
