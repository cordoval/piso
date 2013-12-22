<?php

namespace Piso\Shows\ShowIndex;

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
        $config = $this->parser->parseFile($this->path);

        if (is_array($config) && array_key_exists('shows', $config) && is_array($config['shows'])) {
            return array_keys($config['shows']);
        }

        return [];
    }
}
