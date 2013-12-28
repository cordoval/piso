<?php

namespace Piso\Util;

/**
 * Util class for getting file listings
 */
class FileLister
{
    /**
     * Gets all files inside a particular subtree (omits folders)
     *
     * @param string $path
     * @return array of SplFileInfo objects
     */
    public function getFilesInLocation($path)
    {
        try {
            return iterator_to_array(
                new \CallbackFilterIterator(
                    new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($path)
                    ),
                function(\SplFileInfo $fileInfo) { return $fileInfo->isFile(); }
                )
            );
        }
        catch (\UnexpectedValueException $e) {
            return [];
        }
    }
}