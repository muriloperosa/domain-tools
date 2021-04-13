<?php

namespace MuriloPerosa\DomainTools\Traits;

/**
 * Trait to data returns
 */
 trait HasDataPattern {
    
    /**
     * Handle data to return an array
     * @param mixed $data
     * @return array 
     */
    public function handleArrayReturn($data = []) : array 
    {
        return is_array($data) ? $data: [];
    }

    /**
     * Convert string into array
     * @param string $data 
     * @return array 
     */
    public function stringIntoArray(string $data = '') : array
    {
        return str_word_count($data, 1);
    }
}