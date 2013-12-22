<?php

namespace Piso\Shows;

/**
 * Interface for objects that can generate a list of configured shows
 */
interface ShowLister
{
    /**
     * @return array String names of all the shows
     */
    public function getNames();
} 