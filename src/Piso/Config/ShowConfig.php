<?php

namespace Piso\Config;

/**
 * The configuration for a particular show
 */
interface ShowConfig
{
    /**
     * @return string The name of the show
     */
    public function getName();

    /**
     * @return string|null The location of the show's library
     */
    public function getLibraryPath();
} 