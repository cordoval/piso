<?php

namespace Piso\Index;

/**
 * Interface for objects that can generate a list of configured shows
 */
interface ShowsIndex
{
    /**
     * Lists the names of all configured shows
     *
     * @return array String names of all the shows
     */
    public function getNames();
} 