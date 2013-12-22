<?php

namespace Piso\Shows;

/**
 * Interface for objects that can generate a list of configured shows
 */
interface ShowIndex
{
    /**
     * @return array String names of all the shows
     */
    public function getNames();

    /**
     * @param string $showName
     * @return ShowConfig
     */
    public function getConfigForShow($showName);
} 