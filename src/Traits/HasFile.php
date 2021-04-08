<?php

namespace MuriloPerosa\DomainTools\Traits;

use Generator;

/**
 * Trait to handle files
 */
 trait HasFile {

    /**
     * Get lines of a file to read
     * @param string $file 
     */
    public static function getFileLines(string $path) : Generator
    {
        $f = fopen($path, 'r');

        try 
        {
            while ($line = fgets($f)) 
            {
                yield $line;
            }
        } 
        finally 
        {
            fclose($f);
        }
    }
 }
