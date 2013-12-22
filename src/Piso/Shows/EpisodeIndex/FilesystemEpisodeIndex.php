<?php

namespace Piso\Shows\EpisodeIndex;

use Piso\Shows\EpisodeIndex;
use Piso\Shows\ShowIndex;

class FilesystemEpisodeIndex implements EpisodeIndex
{
    private $showIndex;

    public function __construct(ShowIndex $showIndex)
    {
        $this->showIndex = $showIndex;
    }

    public function getEpisodesForShow($show)
    {
        $showConfig = $this->showIndex->getConfigForShow($show);
    }
}
