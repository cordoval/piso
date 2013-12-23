<?php

namespace Piso\Util;

use Piso\Exception\ConfigException;
use Symfony\Component\Yaml\Parser;

/**
 * Utility class for reading Yaml files from disk
 */
class YamlReader {

    private $parser;

    private $path;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser, $path)
    {
        $this->parser = $parser;
        $this->path = $path;
    }

    /**
     * Parse a Yaml file from disk
     *
     * @param $path
     * @return array
     */
    public function parseFile()
    {
        if (false === $yaml = @file_get_contents($this->path)) {
            throw new ConfigException(sprintf('Cannot load file "%s"', $this->path));
        }

        return $this->parser->parse($yaml);
    }
} 