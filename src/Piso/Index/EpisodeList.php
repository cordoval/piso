<?php

namespace Piso\Index;

/**
 * A list of episodes
 */
class EpisodeList
{
    /**
     * @param array $episodes
     */
    public function __construct(array $episodes)
    {
        $this->episodes = $episodes;
    }

    /**
     * @return array
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

}
