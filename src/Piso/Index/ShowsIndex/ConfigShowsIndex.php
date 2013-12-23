<?php

namespace Piso\Index\ShowsIndex;

use Piso\Config\ShowsConfig;
use Piso\Index\ShowsIndex;

/**
 * A show index that gets its data from configuration
 */
class ConfigShowsIndex implements ShowsIndex
{
    private $showsConfig;

    /**
     * @param ShowsConfig $showsConfig Show configuration definition
     */
    public function __construct(ShowsConfig $showsConfig)
    {
        $this->showsConfig = $showsConfig;
    }

    /**
     * @return array string names of the shows that are configured
     */
    public function getNames()
    {
        $showConfigs = $this->showsConfig->getShowConfigs();
        $names = array_map(function($showConfig) { return $showConfig->getName(); }, $showConfigs);

        return $names;
    }
}
