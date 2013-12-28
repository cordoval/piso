<?php

namespace Piso\Index;

/**
 * An episode of a TV show
 */
interface Episode
{
    /**
     * @return integer The episode number
     */
    public function getNumber();

    /**
     * @return integer The season number
     */
    public function getSeason();
} 