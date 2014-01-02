<?php

namespace Piso\Index;

/**
 * Provides episode information
 */
interface EpisodeIndex
{
    /**
     * Lists the episodes available for a particular show
     *
     * @return EpisodeList
     */
    public function getEpisodesForShow($showName);
} 