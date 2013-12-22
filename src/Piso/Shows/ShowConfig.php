<?php

namespace Piso\Shows;

/**
 * Contains the configuration options for a particular show
 */
class ShowConfig
{
    /**
     * @var string The display name of the show
     */
    private $name;

    /**
     * @param string $name The display name of the show
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string The display name of the show
     */
    public function getName()
    {
       return $this->name;
    }
}
