<?php

namespace Piso\Config;

/**
 * Aggregates the configurations for all shows
 */
interface ShowsConfig
{
    /**
     * @return array ShowConfig objects for all shows
     */
    public function getShowConfigs();

    /**
     * Gets the ShowConfig object for the specified named show
     *
     * @param string $showName
     * @return ShowConfig
     */
    public function getShowConfigFor($showName);
} 