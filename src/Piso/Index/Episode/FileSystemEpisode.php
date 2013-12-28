<?php

namespace Piso\Index\Episode;

use Piso\Index\Episode;

use SplFileInfo;

/**
 * An episode that lives on the filesystem
 */
class FileSystemEpisode implements Episode
{
    /**
     * @var int|null
     */
    private $number = null;

    /**
     * @var int|null
     */
    private $season = null;

    /**
     * Regex used to match filenames like s02e04
     */
    const FORMAT_SXXEXX = '/s(?<season>[0-9]+)e(?<episode>[0-9]+)/i';

    /**
     * @param SplFileInfo $file The file on the filesystem containing the episode
     */
    public function __construct(SplFileInfo $file)
    {
        if (preg_match(self::FORMAT_SXXEXX, $file->getFilename(), $matches)) {
            $this->number = (integer) $matches['episode'];
            $this->season = (integer) $matches['season'];
        }
    }

    /**
     * @return int|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getSeason() {
        return $this->season;
    }
}
