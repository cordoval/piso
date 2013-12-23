<?php

namespace Piso\Config\ShowConfig;

use Piso\Config\ShowConfig;

/**
 * Show config originating from a Yaml config structure
 */
class YamlShowConfig implements ShowConfig
{
    /**
     * @var string The name of the show
     */
    private $name;

    /**
     * @param $name Name of the show
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string The name of the show
     */
    public function getName()
    {
        return $this->name;
    }
}
