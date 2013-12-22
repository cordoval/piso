<?php

namespace Piso\Shows\ShowIndex;

use Piso\Exception\ConfigException;
use Piso\Shows\ShowConfig;
use Piso\Shows\ShowIndex;
use Piso\Util\YamlReader;

/**
 * Class that can list shows based on a Yaml configuration
 */
class YamlShowIndex implements ShowIndex
{
    /**
     * @var YamlReader
     */
    private $parser;

    /**
     * @var string Path to the config file
     */
    private $path;

    /**
     * @param YamlReader $parser Yaml parser
     * @param $path string Path to the config file
     */
    public function __construct(YamlReader $parser, $path)
    {
        $this->parser = $parser;
        $this->path = $path;
    }

    /**
     * Gets the string names of all configured shows
     *
     * @return array
     */
    public function getNames()
    {
        $showsConfig = $this->getShowsNode();

        return array_keys($showsConfig);
    }

    /**
     * Finds the shows config in the configuration
     *
     * @return array
     */
    private function getShowsNode()
    {
        $showsConfig = [];
        $config = $this->parser->parseFile($this->path);

        if (is_array($config) && array_key_exists('shows', $config) && is_array($config['shows'])) {
            $showsConfig = $config['shows'];
        }

        return $showsConfig;
    }

    /**
     * @param string $showName
     * @return ShowConfig
     */
    public function getConfigForShow($showName)
    {
        $showsConfig = $this->getShowsNode();

        if (!array_key_exists($showName, $showsConfig)) {
            throw new ConfigException('Unconfigured show "foo"');
        }

        return new ShowConfig($showName);
    }
}
