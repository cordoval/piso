<?php

namespace Piso\Shows;

/**
 * Provides episode information
 */
interface EpisodeIndex
{
    public function getEpisodesForShow($show);
} 