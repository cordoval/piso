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
     * @return array
     */
    public function getEpisodesForShow($showName);
} 