<?php

namespace Piso\Util;

use Piso\Exception\ConfigException;
use Symfony\Component\Yaml\Parser;

/**
 * Utility class for reading Yaml files from disk
 */
class YamlReader {

    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse a Yaml file from disk
     *
     * @param $path
     * @return array
     */
    public function parseFile($path)
    {
        if (false === $yaml = @file_get_contents($path)) {
            throw new ConfigException(sprintf('Cannot load file "%s"', $path));
        }

        return $this->parser->parse($yaml);
    }
} 