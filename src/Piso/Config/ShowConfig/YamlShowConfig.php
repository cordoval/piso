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
     * @var string The base path of the library
     */
    private $basePath;

    /**
     * @param string $name Name of the show
     * @parah string $basePath The base library path
     */
    public function __construct($name, $basePath = null)
    {
        $this->name = $name;
        $this->basePath = $basePath;
    }

    /**
     * @return string|null The location of the show's library
     */
    public function getLibraryPath()
    {
        if ($this->basePath) {
            return $this->basePath . DIRECTORY_SEPARATOR . $this->name;
        }
    }

    /**
     * @return string The name of the show
     */
    public function getName()
    {
        return $this->name;
    }
}
