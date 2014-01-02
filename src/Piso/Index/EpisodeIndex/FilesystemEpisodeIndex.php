<?php

namespace Piso\Index\EpisodeIndex;

use Piso\Config\ShowsConfig;
use Piso\Index\Episode\FileSystemEpisode;
use Piso\Index\EpisodeIndex;
use Piso\Index\EpisodeList;
use Piso\Index\ShowsIndex;
use Piso\Util\FileLister;

/**
 * Indexes episodes that exist on a local filesystem
 */
class FilesystemEpisodeIndex implements EpisodeIndex
{
    /**
     * @var ShowsConfig
     */
    private $showsConfig;

    /**
     * @var FileLister
     */
    private $fileLister;

    /**
     * @param ShowsConfig $showsConfig The shows configuration
     * @param FileLister $fileLister The file listing oject
     */
    public function __construct(ShowsConfig $showsConfig, FileLister $fileLister)
    {
        $this->showsConfig = $showsConfig;
        $this->fileLister = $fileLister;
    }

    /**
     * Get all of the episodes in a particular show
     *
     * @param string $showName
     * @return EpisodeList
     */
    public function getEpisodesForShow($showName)
    {
        $showConfig = $this->showsConfig->getShowConfigFor($showName);
        $episodes = [];

        if ($path = $showConfig->getLibraryPath()) {
            $files = $this->fileLister->getFilesInLocation($path);
            $episodes = array_map(function ($file) { return new FileSystemEpisode($file); }, $files);
        }

        return new EpisodeList($episodes);
    }
}
