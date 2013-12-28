<?php

namespace Piso\Config\ShowsConfig;

use Piso\Config\ShowsConfig;
use Piso\Config\ShowConfig\YamlShowConfig;
use Piso\Exception\ConfigException;
use Piso\Util\YamlReader;

/**
 * Shows configuration originating from a Yaml config
 */
class YamlShowsConfig implements ShowsConfig
{

    /**
     * @var YamlReader parser initialised wiht the config file
     */
    private $reader;

    /**
     * @param YamlReader $reader parser initialised wiht the config file
     */
    public function __construct(YamlReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return array ShowConfig objects, numerically indexed
     */
    public function getShowConfigs()
    {
        $assocShowConfigs = $this->getAssocShowConfigs();

        return array_values($assocShowConfigs);
    }

    /**
     * Gets the ShowConfig object for the specified named show
     *
     * @param string $showName
     * @return ShowConfig
     * @throws ConfigException
     */
    public function getShowConfigFor($showName)
    {
        $showConfigs = $this->getAssocShowConfigs();

        if (!array_key_exists($showName, $showConfigs)) {
            throw new ConfigException(sprintf('Show "%s" not configured', $showName));
        }

        return $showConfigs[$showName];
    }

    /**
     * Gets all of the ShowConfig objects defined in the file as an associative array
     *
     * @return array
     */
    private function getAssocShowConfigs()
    {
        $config = $this->reader->parseFile() ? : [];
        $showsNode = $this->getShowDefinitions($config);
        $libraryPath = $this->getLibraryPath($config);

        $showConfigs = [];

        foreach ($showsNode as $name => $config) {
            $showConfigs[$name] = new YamlShowConfig($name, $libraryPath);
        }

        return $showConfigs;
    }

    /**
     * Locates the show config node in the config and validates its type
     *
     * @param array $config Complete Yaml config
     * @return array Node corresponding to shows definition
     * @throws ConfigException
     */
    private function getShowDefinitions($config)
    {

        $showsNode = array_key_exists('shows', $config) ? $config['shows'] : [];

        if (!is_array($showsNode)) {
            throw new ConfigException('Error in Yaml file: shows node should be array');
        }

        return $showsNode;
    }

    /**
     * @param array $config Complete Yaml config
     * @return string|null The base library path
     */
    private function getLibraryPath($config)
    {
        if (array_key_exists('library', $config) && array_key_exists('path', $config['library'])) {
            return $config['library']['path'];
        }

        return null;
    }
}
