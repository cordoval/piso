<?php

namespace Piso\Index\EpisodeIndex;

use Piso\Config\ShowsConfig;
use Piso\Index\EpisodeIndex;
use Piso\Index\ShowsIndex;

/**
 * Indexes episodes that exist on a local filesystem
 */
class FilesystemEpisodeIndex implements EpisodeIndex
{

    /**
     * @param ShowsConfig $showsConfig The shows configuration
     */
    public function __construct(ShowsConfig $showsConfig)
    {
        $this->showsConfig = $showsConfig;
    }

    /**
     * Get all of the episodes in a particular show
     *
     * @return array
     */
    public function getEpisodesForShow($showName)
    {
        $this->showsConfig->getShowConfigFor($showName);
    }
}
